<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/instructions', function () {
    return view('instructions');
})->name('instructions');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback');
Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

// Test route to check database connection
Route::get('/test-db', function () {
    try {
        \App\Models\Admin::first();
        return 'Database connection successful!';
    } catch (Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

// Test route to check translation
Route::get('/test-translation', function () {
    return [
        'current_locale' => app()->getLocale(),
        'english_test' => __('messages.home'),
        'sinhala_test' => __('messages.home', [], 'si'),
        'tamil_test' => __('messages.home', [], 'ta'),
        'available_locales' => ['en', 'si', 'ta']
    ];
});

// Jetstream Livewire Test Route
Route::get('/jetstream-test', function () {
    return view('jetstream-test');
})->name('jetstream.test');

// Test route to debug translation issues
Route::get('/debug-translation', function () {
    \Illuminate\Support\Facades\App::setLocale('si');
    return [
        'current_locale' => app()->getLocale(),
        'translation_result' => __('messages.home'),
        'direct_translation' => trans('messages.home'),
        'with_locale' => __('messages.home', [], 'si'),
        'all_keys' => array_keys(trans('messages'))
    ];
});

// Test route to debug form submission
Route::get('/test-form', function () {
    return '<!DOCTYPE html>
    <html>
    <head>
        <title>Form Test</title>
    </head>
    <body>
        <h1>Language Form Test</h1>
        <form method="GET" action="/test-form-result">
            <select name="lang" onchange="console.log(\'Changed to: \' + this.value); this.form.submit()">
                <option value="en">English</option>
                <option value="si">Sinhala</option>
                <option value="ta">Tamil</option>
            </select>
        </form>
        <p>Current locale: ' . app()->getLocale() . '</p>
        <p>Request lang parameter: ' . request()->get('lang', 'not set') . '</p>
    </body>
    </html>';
});

Route::get('/test-form-result', function () {
    return [
        'message' => 'Form submitted successfully!',
        'current_locale' => app()->getLocale(),
        'lang_parameter' => request()->get('lang', 'not set'),
        'all_params' => request()->all()
    ];
});

// Admin login route
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.attempt');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Authenticated Routes for Applicants
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/application', [ApplicationController::class, 'index'])->name('application');
    Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
    Route::get('/application/success', [ApplicationController::class, 'success'])->name('application.success');
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointment/success', [AppointmentController::class, 'success'])->name('appointment.success');
    Route::get('/appointment/view', [AppointmentController::class, 'view'])->name('appointment.view');
    Route::delete('/appointment/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/applications', [AdminApplicationController::class, 'index'])->name('admin.applications.index');
    Route::get('/applications/{id}', [AdminApplicationController::class, 'show'])->name('admin.applications.show');
    Route::post('/applications/{id}/status', [AdminApplicationController::class, 'updateStatus'])->name('admin.applications.update-status');
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/approved', [AdminReportController::class, 'approvedApplications'])->name('admin.reports.approved');
    Route::get('/reports/rejected', [AdminReportController::class, 'rejectedApplications'])->name('admin.reports.rejected');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/appointments/{id}/status', [AdminAppointmentController::class, 'updateStatus'])->name('admin.appointments.update-status');
    Route::post('/appointments/slot', [AdminAppointmentController::class, 'createTimeSlot'])->name('admin.appointments.create-slot');
    Route::post('/appointments/bulk-slots', [AdminAppointmentController::class, 'generateBulkSlots'])->name('admin.appointments.generate-bulk-slots');
    Route::delete('/appointments/slot/{id}', [AdminAppointmentController::class, 'deleteTimeSlot'])->name('admin.appointments.delete-slot');
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('admin.documents.index');
    Route::get('/documents/file', [AdminDocumentController::class, 'getDocumentFile'])->name('admin.documents.file');
    Route::get('/documents/{id}', [AdminDocumentController::class, 'show'])->name('admin.documents.show');
    Route::post('/documents/{id}/status', [AdminDocumentController::class, 'updateStatus'])->name('admin.documents.update-status');
    Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
