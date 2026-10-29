<?php

namespace App\Services;

use App\Models\Result;
use App\Models\FlaggedResult;

class ResultStatisticalAnalyzer
{
    /**
     * Analyze results for a specific course and session to flag statistical abnormalities.
     * 
     * @param int $courseId
     * @param int $sessionId
     * @return void
     */
    public static function analyzeCourseResults($courseId, $sessionId)
    {
        $results = Result::where('course_id', $courseId)
            ->where('academic_session_id', $sessionId)
            ->get();

        if ($results->count() < 3) {
            // Not enough data for meaningful statistical analysis
            return;
        }

        // Calculate Mean
        $totalScoreSum = $results->sum('total_score');
        $mean = $totalScoreSum / $results->count();

        // Calculate Standard Deviation
        $varianceSum = 0;
        foreach ($results as $result) {
            $varianceSum += pow($result->total_score - $mean, 2);
        }
        $variance = $varianceSum / $results->count();
        $stdDev = sqrt($variance);

        // Fetch Validation Rules
        $stdDevOutlierRule = \App\Models\ValidationRule::where('name', 'std_dev_outlier')->first();
        $stdDevOutlier = $stdDevOutlierRule ? (float)$stdDevOutlierRule->condition : 2.0;

        $highSeverityStdDevRule = \App\Models\ValidationRule::where('name', 'high_severity_std_dev')->first();
        $highSeverityStdDev = $highSeverityStdDevRule ? (float)$highSeverityStdDevRule->condition : 3.0;

        $suspiciousCaPercentRule = \App\Models\ValidationRule::where('name', 'suspicious_ca_percentage')->first();
        $suspiciousCaPercent = $suspiciousCaPercentRule ? (float)$suspiciousCaPercentRule->condition : 80.0;

        $suspiciousExamPercentRule = \App\Models\ValidationRule::where('name', 'suspicious_exam_percentage')->first();
        $suspiciousExamPercent = $suspiciousExamPercentRule ? (float)$suspiciousExamPercentRule->condition : 30.0;

        // Additional rules variables
        $examScores = [];
        $caScores = [];
        $grades = [];
        $scoreCombinations = [];

        // Pre-process for class-wide rules
        foreach ($results as $result) {
            if ($result->exam_score !== null) $examScores[] = $result->exam_score;
            if ($result->ca_score !== null) $caScores[] = $result->ca_score;
            if ($result->grade !== null) $grades[] = $result->grade;
            if ($result->ca_score !== null && $result->exam_score !== null) {
                $combo = $result->ca_score . '|' . $result->exam_score;
                if (!isset($scoreCombinations[$combo])) $scoreCombinations[$combo] = 0;
                $scoreCombinations[$combo]++;
            }
        }

        // Rule 8: Identical Exam scores for entire class (or >80%)
        if (count($examScores) > 5) {
            $mostCommonExam = array_count_values(array_map('strval', $examScores));
            $maxExamFrequency = max($mostCommonExam);
            if ($maxExamFrequency / count($examScores) > 0.8) {
                // Apply flag to those who have this common score
                $commonScore = array_search($maxExamFrequency, $mostCommonExam);
                foreach ($results as $result) {
                    if ((string)$result->exam_score === (string)$commonScore) {
                        FlaggedResult::firstOrCreate([
                            'result_id' => $result->id,
                            'abnormality_type' => 'Identical Exam Score (Class-wide)',
                            'severity' => 'High',
                        ]);
                    }
                }
            }
        }

        // Rule 9: Identical CA scores for entire class (or >80%)
        if (count($caScores) > 5) {
            $mostCommonCa = array_count_values(array_map('strval', $caScores));
            $maxCaFrequency = max($mostCommonCa);
            if ($maxCaFrequency / count($caScores) > 0.8) {
                $commonScore = array_search($maxCaFrequency, $mostCommonCa);
                foreach ($results as $result) {
                    if ((string)$result->ca_score === (string)$commonScore) {
                        FlaggedResult::firstOrCreate([
                            'result_id' => $result->id,
                            'abnormality_type' => 'Identical CA Score (Class-wide)',
                            'severity' => 'High',
                        ]);
                    }
                }
            }
        }

        // Rule 19: No C-grade in entire class (only A's and F's)
        if (count($grades) > 10) {
            $gradeCounts = array_count_values($grades);
            $hasA = isset($gradeCounts['A']) && $gradeCounts['A'] > 0;
            $hasF = isset($gradeCounts['F']) && $gradeCounts['F'] > 0;
            $hasC = isset($gradeCounts['C']) && $gradeCounts['C'] > 0;
            
            if ($hasA && $hasF && !$hasC) {
                foreach ($results as $result) {
                    FlaggedResult::firstOrCreate([
                        'result_id' => $result->id,
                        'abnormality_type' => 'Suspicious Grade Distribution (No Cs)',
                        'severity' => 'Medium',
                    ]);
                }
            }
        }

        // Rule 18: Bimodal distribution check
        // High variance, mean around 50, but very few near mean
        if (count($results) > 15) {
            $nearMean = 0;
            foreach ($results as $result) {
                if (abs($result->total_score - $mean) < 10) {
                    $nearMean++;
                }
            }
            if (($nearMean / count($results)) < 0.15 && $stdDev > 20) {
                foreach ($results as $result) {
                    FlaggedResult::firstOrCreate([
                        'result_id' => $result->id,
                        'abnormality_type' => 'Bimodal Distribution (Extreme Splits)',
                        'severity' => 'Medium',
                    ]);
                }
            }
        }

        // Analyze each result
        foreach ($results as $result) {
            $score = $result->total_score;
            
            // Abnormality 1: Outlier (Standard Deviations away from mean)
            if ($stdDev > 0 && abs($score - $mean) > ($stdDevOutlier * $stdDev)) {
                $severity = abs($score - $mean) > ($highSeverityStdDev * $stdDev) ? 'High' : 'Medium';
                
                FlaggedResult::firstOrCreate([
                    'result_id' => $result->id,
                    'abnormality_type' => 'Statistical Outlier (Z-Score)',
                    'severity' => $severity,
                ]);
            }

            // Rule 2: Unusually high CA score compared to Exam score (Very high CA + Very low Exam)
            if ($result->ca_score > 0 && $result->exam_score !== null) {
                $caPercentage = ($result->ca_score / 30) * 100;
                $examPercentage = ($result->exam_score / 70) * 100;

                if ($caPercentage > $suspiciousCaPercent && $examPercentage < $suspiciousExamPercent) {
                    FlaggedResult::firstOrCreate([
                        'result_id' => $result->id,
                        'abnormality_type' => 'Very high CA / Very low Exam',
                        'severity' => 'High',
                    ]);
                }
            }

            // Rule 10: Same CA and Exam for different students (duplicate record pattern)
            if ($result->ca_score !== null && $result->exam_score !== null && $result->ca_score > 0 && $result->exam_score > 0) {
                $combo = $result->ca_score . '|' . $result->exam_score;
                if (isset($scoreCombinations[$combo]) && $scoreCombinations[$combo] > 3) {
                    // If more than 3 students have the exact same non-zero CA & Exam
                    FlaggedResult::firstOrCreate([
                        'result_id' => $result->id,
                        'abnormality_type' => 'Duplicate Score Pattern (CA & Exam)',
                        'severity' => 'Medium',
                    ]);
                }
            }
        }
    }
}
