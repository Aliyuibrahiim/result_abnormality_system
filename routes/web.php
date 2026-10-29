<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::get('dashboard', App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users
    Route::get('users', App\Livewire\Admin\Users\Index::class)->name('users');
    Route::get('users/create', App\Livewire\Admin\Users\Create::class)->name('users.create');
    Route::get('users/{user}/edit', App\Livewire\Admin\Users\Edit::class)->name('users.edit');

    // Courses
    Route::get('courses', App\Livewire\Admin\Courses\Index::class)->name('courses');
    Route::get('courses/create', App\Livewire\Admin\Courses\Create::class)->name('courses.create');
    Route::get('courses/{course}/edit', App\Livewire\Admin\Courses\Edit::class)->name('courses.edit');

    // Academic Sessions
    Route::get('academic-sessions', App\Livewire\Admin\AcademicSessions\Index::class)->name('academic-sessions');
    Route::get('academic-sessions/create', App\Livewire\Admin\AcademicSessions\Create::class)->name('academic-sessions.create');
    Route::get('academic-sessions/{academicSession}/edit', App\Livewire\Admin\AcademicSessions\Edit::class)->name('academic-sessions.edit');

    Route::get('validation-rules', App\Livewire\Admin\ValidationRules\Index::class)->name('validation-rules');
});

Route::middleware(['auth', 'role:admin|exam_officer'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('results', App\Livewire\Admin\Results\Index::class)->name('results');
    Route::get('abnormalities', App\Livewire\Admin\FlaggedResults\Index::class)->name('abnormalities');
    Route::get('abnormalities/{flaggedResult}', App\Livewire\Admin\FlaggedResults\Show::class)->name('abnormalities.show');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('course-registration', App\Livewire\Student\CourseRegistration\Index::class)->name('course-registration');
    Route::get('results', App\Livewire\Student\Results\Index::class)->name('results');
});

Route::middleware(['auth', 'role:lecturer|admin'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('result-upload', App\Livewire\Lecturer\ResultUpload\Index::class)->name('result-upload');
});
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
