<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\AcademicSession;
use App\Models\CourseRegistration;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Exam Officer
        $examOfficer = User::create([
            'name' => 'Sarah (Exam Officer)',
            'email' => 'exam@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $examOfficer->assignRole('exam_officer');

        // 2. Create 6 Lecturers
        $lecturers = [
            User::create(['name' => 'Dr. Smith (Lecturer)', 'email' => 'lecturer1@example.com', 'password' => Hash::make('password'), 'is_active' => true]),
            User::create(['name' => 'Prof. Johnson (Lecturer)', 'email' => 'lecturer2@example.com', 'password' => Hash::make('password'), 'is_active' => true]),
            User::create(['name' => 'Dr. Amina (Lecturer)', 'email' => 'lecturer3@example.com', 'password' => Hash::make('password'), 'is_active' => true]),
            User::create(['name' => 'Mr. Abubakar (Lecturer)', 'email' => 'lecturer4@example.com', 'password' => Hash::make('password'), 'is_active' => true]),
            User::create(['name' => 'Mrs. Ade (Lecturer)', 'email' => 'lecturer5@example.com', 'password' => Hash::make('password'), 'is_active' => true]),
            User::create(['name' => 'Dr. Bello (Lecturer)', 'email' => 'lecturer6@example.com', 'password' => Hash::make('password'), 'is_active' => true]),
        ];
        
        foreach ($lecturers as $lecturer) {
            $lecturer->assignRole('lecturer');
        }

        // 3. Create Active Academic Session
        $session = AcademicSession::create([
            'name' => '2025/2026',
            'semester' => 1, 
            'is_active' => true,
        ]);

        // 4. Create Courses assigned to the Lecturers
        $allCourses = [];
        $courseData = [
            100 => [
                ['code' => 'CSC101', 'title' => 'Introduction to Computer Science', 'unit_load' => 3, 'coordinator_id' => $lecturers[0]->id],
                ['code' => 'MTH101', 'title' => 'Elementary Mathematics I', 'unit_load' => 3, 'coordinator_id' => $lecturers[1]->id],
                ['code' => 'PHY101', 'title' => 'General Physics I', 'unit_load' => 2, 'coordinator_id' => $lecturers[2]->id],
            ],
            200 => [
                ['code' => 'CSC201', 'title' => 'Data Structures and Algorithms', 'unit_load' => 3, 'coordinator_id' => $lecturers[3]->id],
                ['code' => 'CSC203', 'title' => 'Object Oriented Programming', 'unit_load' => 3, 'coordinator_id' => $lecturers[4]->id],
                ['code' => 'MTH201', 'title' => 'Mathematical Methods I', 'unit_load' => 2, 'coordinator_id' => $lecturers[5]->id],
            ],
            300 => [
                ['code' => 'CSC301', 'title' => 'Operating Systems', 'unit_load' => 3, 'coordinator_id' => $lecturers[5]->id],
                ['code' => 'CSC303', 'title' => 'Database Design & Management', 'unit_load' => 3, 'coordinator_id' => $lecturers[4]->id],
                ['code' => 'CSC315', 'title' => 'Web Application Development', 'unit_load' => 3, 'coordinator_id' => $lecturers[3]->id],
            ],
            400 => [
                ['code' => 'CSC401', 'title' => 'Software Engineering', 'unit_load' => 3, 'coordinator_id' => $lecturers[2]->id],
                ['code' => 'CSC403', 'title' => 'Artificial Intelligence', 'unit_load' => 3, 'coordinator_id' => $lecturers[1]->id],
                ['code' => 'CSC411', 'title' => 'Computer Networks', 'unit_load' => 3, 'coordinator_id' => $lecturers[0]->id],
            ]
        ];

        foreach ($courseData as $level => $coursesForLevel) {
            foreach ($coursesForLevel as $cData) {
                $cData['level'] = $level;
                $course = Course::create($cData);
                $allCourses[$level][] = $course;
            }
        }

        // 5. Create Validation Rules
        \App\Models\ValidationRule::insert([
            ['name' => 'CA Score Limit', 'rule_type' => 'max_ca_score', 'condition' => json_encode(['max' => 30]), 'applicable_scope' => 'all', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Exam Score Limit', 'rule_type' => 'max_exam_score', 'condition' => json_encode(['max' => 70]), 'applicable_scope' => 'all', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Missing Score', 'rule_type' => 'missing_score', 'condition' => json_encode(['check' => 'ca_or_exam']), 'applicable_scope' => 'all', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. Create 5 Students per level, Register them for Courses, and Upload some Results
        $levels = [400, 300, 200, 100];
        
        foreach ($levels as $level) {
            for ($i = 1; $i <= 10; $i++) {
                $studentUser = User::create([
                    'name' => 'Maryam Ayub ' . $level . '_' . $i,
                    'email' => 'student' . $level . '_' . $i . '@example.com',
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ]);
                $studentUser->assignRole('student');

                $student = Student::create([
                    'user_id' => $studentUser->id,
                    'matric_no' => 'KASU/CSC/22/' . $level . '_' . $i,
                    'first_name' => 'Maryam',
                    'last_name' => 'Ayub ' . $level . '_' . $i,
                    'gender' => 'Female',
                    'level' => $level,
                ]);

                // Register student for all courses up to their level
                foreach ($allCourses as $courseLevel => $levelCourses) {
                    if ($courseLevel <= $level) {
                        foreach ($levelCourses as $index => $course) {
                            CourseRegistration::create([
                                'student_id' => $student->id,
                                'course_id' => $course->id,
                                'academic_session_id' => $session->id,
                            ]);

                            // Add results for some courses (e.g., lower level courses)
                            if ($courseLevel < $level || ($courseLevel == $level && $index == 0)) {
                                $caScore = rand(15, 30);
                                $examScore = rand(30, 70);
                                $total = $caScore + $examScore;
                                
                                $grade = 'F'; $points = 0;
                                if ($total >= 70) { $grade = 'A'; $points = 5; }
                                elseif ($total >= 60) { $grade = 'B'; $points = 4; }
                                elseif ($total >= 50) { $grade = 'C'; $points = 3; }
                                elseif ($total >= 45) { $grade = 'D'; $points = 2; }

                                // Create an abnormality for the very first student of each level
                                $isAbnormal = ($i == 1 && $courseLevel == $level);
                                if ($isAbnormal) {
                                    $caScore = 45; // Invalid CA
                                    $total = $caScore + $examScore;
                                }

                                $result = \App\Models\Result::create([
                                    'student_id' => $student->id,
                                    'course_id' => $course->id,
                                    'academic_session_id' => $session->id,
                                    'ca_score' => $caScore,
                                    'exam_score' => $examScore,
                                    'total_score' => $total,
                                    'grade' => $grade,
                                    'points' => $points,
                                ]);

                                if ($isAbnormal) {
                                    \App\Models\FlaggedResult::create([
                                        'result_id' => $result->id,
                                        'abnormality_type' => 'CA Score Exceeds Maximum (45 > 30)',
                                        'severity' => 'high',
                                        'is_resolved' => false,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
