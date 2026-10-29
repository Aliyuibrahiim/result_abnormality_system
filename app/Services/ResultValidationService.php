<?php

namespace App\Services;

use App\Models\Result;
use App\Models\FlaggedResult;

class ResultValidationService
{
    /**
     * Validate a single result against rule-based compilation errors.
     *
     * @param Result $result
     * @return void
     */
    public static function validate(Result $result)
    {
        $passMark = 40.0; // Standard pass mark
        $maxCa = 30.0;
        $maxExam = 70.0;
        $maxTotal = 100.0;

        // Ensure we don't duplicate flags of the same type for the same result
        $existingFlags = FlaggedResult::where('result_id', $result->id)->pluck('abnormality_type')->toArray();

        $flagsToCreate = [];

        // Rule 1: Very low CA + Very high Exam
        if ($result->ca_score !== null && $result->exam_score !== null) {
            if ((float)$result->ca_score <= 3.0 && (float)$result->exam_score >= 63.0) {
                if (!in_array('Low CA / High Exam', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Low CA / High Exam',
                        'severity' => 'Medium',
                    ];
                }
            }
        }

        // Rule 3: Scoring zero (0) in both CA and Exam
        if ($result->ca_score !== null && $result->exam_score !== null) {
            if ((float)$result->ca_score === 0.0 && (float)$result->exam_score === 0.0) {
                if (!in_array('Zero in both CA and Exam', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Zero in both CA and Exam',
                        'severity' => 'High',
                    ];
                }
            }
        }

        // Rule 5: Scoring zero in Exam only but having high CA
        if ($result->ca_score !== null && $result->exam_score !== null) {
            if ((float)$result->exam_score === 0.0 && (float)$result->ca_score >= 20.0) {
                if (!in_array('Zero Exam with High CA', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Zero Exam with High CA',
                        'severity' => 'High',
                    ];
                }
            }
        }

        // 1. Scoring zero (0) in examination (Existing, updated to medium to avoid duplicating rule 3/5 if needed, but keeping as is for safety)
        if ($result->exam_score !== null && (float)$result->exam_score === 0.0 && (float)$result->ca_score > 0 && (float)$result->ca_score < 20.0) {
            if (!in_array('Zero Exam Score', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Zero Exam Score',
                    'severity' => 'High',
                ];
            }
        }

        // Rule 6: Missing CA but marked as passed
        if ($result->ca_score === null || (float)$result->ca_score === 0.0) {
            if ($result->total_score !== null && (float)$result->total_score >= $passMark) {
                if (!in_array('Missing CA but Passed', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Missing CA but Passed',
                        'severity' => 'Critical',
                    ];
                }
            }
        }

        // Rule 4: Compilation Error: Total score mismatch
        $expectedTotal = (float)$result->ca_score + (float)$result->exam_score;
        if ($result->total_score !== null && abs((float)$result->total_score - $expectedTotal) > 0.1) {
            if (!in_array('Total Score Mismatch', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Total Score Mismatch',
                    'severity' => 'High',
                ];
            }
        }

        // Rule 7 & 14 & 16: Grade does not match total, GPA miscalculation, Scored above pass but marked failed
        if ($result->total_score !== null && $result->grade !== null) {
            $expectedGrade = 'F';
            $expectedPoints = 0.0;
            $score = (float)$result->total_score;

            if ($score >= 70) { $expectedGrade = 'A'; $expectedPoints = 5.0; }
            elseif ($score >= 60) { $expectedGrade = 'B'; $expectedPoints = 4.0; }
            elseif ($score >= 50) { $expectedGrade = 'C'; $expectedPoints = 3.0; }
            elseif ($score >= 45) { $expectedGrade = 'D'; $expectedPoints = 2.0; }
            elseif ($score >= 40) { $expectedGrade = 'E'; $expectedPoints = 1.0; }

            if ($result->grade !== $expectedGrade) {
                if (!in_array('Grade Mismatch', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Grade Mismatch',
                        'severity' => 'Critical',
                    ];
                }
            }

            if ($result->points !== null && abs((float)$result->points - $expectedPoints) > 0.01) {
                if (!in_array('Points Mismatch', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Points Mismatch',
                        'severity' => 'Critical',
                    ];
                }
            }
            
            // Rule 16 specific check
            if ($score >= $passMark && $result->grade === 'F') {
                if (!in_array('Passed but Marked Failed', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Passed but Marked Failed',
                        'severity' => 'Critical',
                    ];
                }
            }
        }

        // 4. Over-scoring: CA > Max, Exam > Max, or Total > Max
        if ((float)$result->ca_score > $maxCa) {
            if (!in_array('Invalid CA Score', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Invalid CA Score',
                    'severity' => 'High',
                ];
            }
        }

        if ((float)$result->exam_score > $maxExam) {
            if (!in_array('Invalid Exam Score', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Invalid Exam Score',
                    'severity' => 'High',
                ];
            }
        }

        if ((float)$result->total_score > $maxTotal) {
            if (!in_array('Invalid Total Score', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Invalid Total Score',
                    'severity' => 'High',
                ];
            }
        }

        // Rule 15: Carryover student scored same as before with no remark
        $previousResult = Result::where('student_id', $result->student_id)
                                ->where('course_id', $result->course_id)
                                ->where('academic_session_id', '!=', $result->academic_session_id)
                                ->orderBy('created_at', 'desc')
                                ->first();
        if ($previousResult && $result->total_score !== null && $previousResult->total_score === $result->total_score) {
            if (!in_array('Identical Carryover Score', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Identical Carryover Score',
                    'severity' => 'Medium',
                ];
            }
        }

        // Rule 17: Student offering more than maximum credit units (e.g. > 24)
        $totalRegisteredUnits = \App\Models\CourseRegistration::where('student_id', $result->student_id)
                                    ->where('academic_session_id', $result->academic_session_id)
                                    ->join('courses', 'course_registrations.course_id', '=', 'courses.id')
                                    ->sum('courses.unit_load');
        if ($totalRegisteredUnits > 24) {
            if (!in_array('Exceeded Maximum Credit Units', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Exceeded Maximum Credit Units',
                    'severity' => 'High',
                ];
            }
        }

        // Rule 20: Duplicate course for same student in same semester (Check DB for another result)
        $duplicateResult = Result::where('student_id', $result->student_id)
                                ->where('course_id', $result->course_id)
                                ->where('academic_session_id', $result->academic_session_id)
                                ->where('id', '!=', $result->id)
                                ->exists();
        if ($duplicateResult) {
            if (!in_array('Duplicate Result Record', $existingFlags)) {
                $flagsToCreate[] = [
                    'abnormality_type' => 'Duplicate Result Record',
                    'severity' => 'Critical',
                ];
            }
        }

        self::checkGpaSpikeOrDrop($result, $existingFlags, $flagsToCreate);

        // Save new flags
        foreach ($flagsToCreate as $flagData) {
            FlaggedResult::create([
                'result_id' => $result->id,
                'abnormality_type' => $flagData['abnormality_type'],
                'severity' => $flagData['severity'],
                'is_resolved' => false,
            ]);
        }
    }

    /**
     * Check for rules 11 and 12: Sudden spike or drastic drop in CGPA
     */
    private static function checkGpaSpikeOrDrop($result, $existingFlags, &$flagsToCreate)
    {
        // Get all past sessions the student was in, ordered by time
        $pastSessions = Result::where('student_id', $result->student_id)
                              ->where('academic_session_id', '!=', $result->academic_session_id)
                              ->select('academic_session_id')
                              ->distinct()
                              ->pluck('academic_session_id')
                              ->toArray();
                              
        if (count($pastSessions) === 0) return; // No past data

        // Calculate GPA for the last past session
        $lastSessionId = end($pastSessions);
        $lastSessionResults = Result::where('student_id', $result->student_id)
                                    ->where('academic_session_id', $lastSessionId)
                                    ->join('courses', 'results.course_id', '=', 'courses.id')
                                    ->get(['results.points', 'courses.unit_load']);
                                    
        $lastTotalPoints = 0;
        $lastTotalUnits = 0;
        foreach ($lastSessionResults as $lr) {
            $lastTotalPoints += ($lr->points * $lr->unit_load);
            $lastTotalUnits += $lr->unit_load;
        }
        $lastGpa = $lastTotalUnits > 0 ? ($lastTotalPoints / $lastTotalUnits) : 0;

        // Calculate GPA for current session
        $currentSessionResults = Result::where('student_id', $result->student_id)
                                    ->where('academic_session_id', $result->academic_session_id)
                                    ->join('courses', 'results.course_id', '=', 'courses.id')
                                    ->get(['results.points', 'courses.unit_load']);
                                    
        $currentTotalPoints = 0;
        $currentTotalUnits = 0;
        foreach ($currentSessionResults as $cr) {
            $currentTotalPoints += ($cr->points * $cr->unit_load);
            $currentTotalUnits += $cr->unit_load;
        }
        $currentGpa = $currentTotalUnits > 0 ? ($currentTotalPoints / $currentTotalUnits) : 0;

        if ($currentTotalUnits > 0 && $lastTotalUnits > 0) {
            // Rule 11: Sudden spike (e.g., 1.5 to 4.5)
            if (($currentGpa - $lastGpa) >= 2.5) {
                if (!in_array('Sudden CGPA Spike', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Sudden CGPA Spike',
                        'severity' => 'High',
                    ];
                }
            }
            // Rule 12: Drastic drop (e.g., 4.5 to 1.0)
            if (($lastGpa - $currentGpa) >= 2.5) {
                if (!in_array('Drastic CGPA Drop', $existingFlags)) {
                    $flagsToCreate[] = [
                        'abnormality_type' => 'Drastic CGPA Drop',
                        'severity' => 'High',
                    ];
                }
            }
        }
    }

    /**
     * Validate a collection of results (e.g., all results for a course).
     *
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @return void
     */
    public static function validateBatch($results)
    {
        foreach ($results as $result) {
            self::validate($result);
        }
        
        // Let's also run a check for "Similar C.A scores" if it's a collection from a specific course
        if ($results->count() > 0) {
            self::checkSimilarCAScores($results);
        }
    }
    
    /**
     * Detect abnormally similar CA scores within a batch.
     */
    private static function checkSimilarCAScores($results)
    {
        // Simple heuristic: If more than 50% of the class has the exact same non-zero CA score
        // Or if there are sequences of students with the same score.
        $caCounts = [];
        $totalResults = $results->count();
        
        if ($totalResults < 10) return; // Need a decent sample size
        
        foreach ($results as $result) {
            if ($result->ca_score !== null && (float)$result->ca_score > 0) {
                $scoreStr = (string)(float)$result->ca_score;
                if (!isset($caCounts[$scoreStr])) {
                    $caCounts[$scoreStr] = [];
                }
                $caCounts[$scoreStr][] = $result;
            }
        }
        
        foreach ($caCounts as $score => $studentsWithScore) {
            $count = count($studentsWithScore);
            // If more than 40% of a class (of at least 10) has the EXACT same CA score
            if ($count > ($totalResults * 0.4)) {
                foreach ($studentsWithScore as $result) {
                    $exists = FlaggedResult::where('result_id', $result->id)
                                ->where('abnormality_type', 'Suspiciously Common CA Score')
                                ->exists();
                    if (!$exists) {
                        FlaggedResult::create([
                            'result_id' => $result->id,
                            'abnormality_type' => 'Suspiciously Common CA Score',
                            'severity' => 'Medium',
                            'is_resolved' => false,
                        ]);
                    }
                }
            }
        }
    }
}
