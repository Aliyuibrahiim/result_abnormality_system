<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\AcademicSession;
use App\Models\CourseRegistration;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $defaultPassword = Hash::make('password123');

            // 0. Ensure Roles Exist
            Role::firstOrCreate(['name' => 'admin']);
            Role::firstOrCreate(['name' => 'exam_officer']);
            Role::firstOrCreate(['name' => 'lecturer']);
            Role::firstOrCreate(['name' => 'student']);

            // 1. Create Default Admin User
            $admin = User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'System Admin',
                    'password' => $defaultPassword,
                    'is_active' => true,
                ]
            );
            if (!$admin->hasRole('admin')) {
                $admin->assignRole('admin');
            }

            // 2. Create Exam Officer
            $examOfficer = User::firstOrCreate(
                ['email' => 'exam@example.com'],
                [
                    'name' => 'Sarah (Exam Officer)',
                    'password' => $defaultPassword,
                    'is_active' => true,
                ]
            );
            if (!$examOfficer->hasRole('exam_officer')) {
                $examOfficer->assignRole('exam_officer');
            }

            // 3. Create 6 Lecturers
            $lecturers = [
                User::firstOrCreate(['email' => 'lecturer1@example.com'], ['name' => 'Dr. Smith (Lecturer)', 'password' => $defaultPassword, 'is_active' => true]),
                User::firstOrCreate(['email' => 'lecturer2@example.com'], ['name' => 'Prof. Johnson (Lecturer)', 'password' => $defaultPassword, 'is_active' => true]),
                User::firstOrCreate(['email' => 'lecturer3@example.com'], ['name' => 'Dr. Amina (Lecturer)', 'password' => $defaultPassword, 'is_active' => true]),
                User::firstOrCreate(['email' => 'lecturer4@example.com'], ['name' => 'Mr. Abubakar (Lecturer)', 'password' => $defaultPassword, 'is_active' => true]),
                User::firstOrCreate(['email' => 'lecturer5@example.com'], ['name' => 'Mrs. Ade (Lecturer)', 'password' => $defaultPassword, 'is_active' => true]),
                User::firstOrCreate(['email' => 'lecturer6@example.com'], ['name' => 'Dr. Bello (Lecturer)', 'password' => $defaultPassword, 'is_active' => true]),
            ];
            
            foreach ($lecturers as $lecturer) {
                if (!$lecturer->hasRole('lecturer')) {
                    $lecturer->assignRole('lecturer');
                }
            }

            // 4. Create Active Academic Session
            $session = AcademicSession::firstOrCreate(
                ['name' => '2025/2026', 'semester' => 1],
                ['is_active' => true]
            );

            // 5. Create Courses assigned to Lecturers
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
                    $course = Course::firstOrCreate(['code' => $cData['code']], $cData);
                    $allCourses[$level][] = $course;
                }
            }

            // 6. Create Validation Rules
            $defaultRules = [
                ['name' => 'CA Score Limit', 'rule_type' => 'max_ca_score', 'condition' => json_encode(['max' => 30]), 'applicable_scope' => 'all'],
                ['name' => 'Exam Score Limit', 'rule_type' => 'max_exam_score', 'condition' => json_encode(['max' => 70]), 'applicable_scope' => 'all'],
                ['name' => 'Missing Score', 'rule_type' => 'missing_score', 'condition' => json_encode(['check' => 'ca_or_exam']), 'applicable_scope' => 'all'],
            ];

            foreach ($defaultRules as $rule) {
                \App\Models\ValidationRule::firstOrCreate(['name' => $rule['name']], $rule);
            }

            // 7. Create 3 Students per level (12 total for ultra-fast seeding)
            $levels = [400, 300, 200, 100];
            
            foreach ($levels as $level) {
                for ($i = 1; $i <= 3; $i++) {
                    $studentUser = User::firstOrCreate(
                        ['email' => 'student' . $level . '_' . $i . '@example.com'],
                        [
                            'name' => 'Maryam Ayub ' . $level . '_' . $i,
                            'password' => $defaultPassword,
                            'is_active' => true,
                        ]
                    );
                    if (!$studentUser->hasRole('student')) {
                        $studentUser->assignRole('student');
                    }

                    $student = Student::firstOrCreate(
                        ['matric_no' => 'KASU/CSC/22/' . $level . '_' . $i],
                        [
                            'user_id' => $studentUser->id,
                            'first_name' => 'Maryam',
                            'last_name' => 'Ayub ' . $level . '_' . $i,
                            'gender' => 'Female',
                            'level' => $level,
                        ]
                    );

                    // Register student for current level courses
                    $currentLevelCourses = $allCourses[$level] ?? [];
                    
                    // Intentionally make ONLY the 1st student in 400L exceed 24 units for demonstration
                    $coursesToRegister = $currentLevelCourses;
                    if ($level == 400 && $i == 1) {
                        $coursesToRegister = array_merge($currentLevelCourses, $allCourses[100] ?? [], $allCourses[200] ?? []);
                    }

                    foreach ($coursesToRegister as $index => $course) {
                        CourseRegistration::firstOrCreate([
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'academic_session_id' => $session->id,
                        ]);

                        $caScore = rand(15, 30);
                        $examScore = rand(30, 70);
                        $total = $caScore + $examScore;
                        
                        $grade = 'F'; $points = 0;
                        if ($total >= 70) { $grade = 'A'; $points = 5; }
                        elseif ($total >= 60) { $grade = 'B'; $points = 4; }
                        elseif ($total >= 50) { $grade = 'C'; $points = 3; }
                        elseif ($total >= 45) { $grade = 'D'; $points = 2; }

                        // Create an abnormality for the very first student of each level
                        $isAbnormal = ($i == 1 && $index == 0);
                        if ($isAbnormal) {
                            $caScore = 45; // Invalid CA (> 30)
                            $total = $caScore + $examScore;
                        }

                        $result = \App\Models\Result::updateOrCreate(
                            [
                                'student_id' => $student->id,
                                'course_id' => $course->id,
                                'academic_session_id' => $session->id,
                            ],
                            [
                                'ca_score' => $caScore,
                                'exam_score' => $examScore,
                                'total_score' => $total,
                                'grade' => $grade,
                                'points' => $points,
                            ]
                        );

                        if ($isAbnormal) {
                            \App\Models\FlaggedResult::firstOrCreate([
                                'result_id' => $result->id,
                                'abnormality_type' => 'CA Score Exceeds Maximum (45 > 30)',
                            ], [
                                'severity' => 'high',
                                'is_resolved' => false,
                            ]);
                        }
                    }
                }
            }
        });
    }
}
