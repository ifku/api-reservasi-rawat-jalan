<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json(['message' => 'Peler!']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::post('/auth/sign-up', [AuthController::class, 'signUp']);
    Route::post('/auth/sign-in', [AuthController::class, 'signIn']);
    Route::post('/auth/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/auth/refresh-token', [AuthController::class, 'refreshToken']);
    Route::put('/auth/complete-profile', [AuthController::class, 'completeProfile']);
    Route::post('/auth/sign-out', [AuthController::class, 'signOut']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::put('/user/complete-profile', [UserController::class, 'completeProfile']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::get('/clinic', [ClinicController::class, 'getAllClinic']);
    Route::get('/clinic/{id}', [ClinicController::class, 'getClinicById']);
    Route::post('/clinic', [ClinicController::class, 'createClinic']);
    Route::put('/clinic/{id}', [ClinicController::class, 'updateClinic']);
    Route::delete('/clinic/{id}', [ClinicController::class, 'deleteClinic']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::get('/doctor', [DoctorController::class, 'getAllDoctor']);
    Route::get('/doctor/clinic/{id}', [DoctorController::class, 'getAllDoctorByClinicId']);
    Route::get('/doctor/{id}', [DoctorController::class, 'getDoctorById']);
    Route::post('/doctor', [DoctorController::class, 'createDoctor']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::get('/reservation', [ReservationController::class, 'getAllReservation']);
    Route::get('/reservation/{id}', [ReservationController::class, 'getReservationById']);
    Route::get('/reservation/patient/{id}', [ReservationController::class, 'getReservationByPatientId']);
    Route::get('/reservation/user/{id}', [ReservationController::class, 'getReservationByUserId']);
    Route::post('/reservation', [ReservationController::class, 'createReservation']);
    Route::delete('/reservation/{id}', [ReservationController::class, 'deleteReservation']);
    Route::get('/reservation/filter/advance-filter', [ReservationController::class, 'advanceFilter']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::get('/queue/{id}', [QueueController::class, 'getQueueByDoctorId']);
    Route::post('/queue', [QueueController::class, 'createQueue']);
    Route::put('/queue/{id}', [QueueController::class, 'updateQueue']);
    Route::delete('/queue/{id}', [QueueController::class, 'resetQueue']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::get('/schedule', [ScheduleController::class, 'getAllSchedule']);
    Route::get('/schedule/{id}', [ScheduleController::class, 'getScheduleById']);
    Route::get('/schedule/doctor/{id}', [ScheduleController::class, 'getScheduleByDoctorId']);
    Route::put('/schedule/{id}', [ScheduleController::class, 'updateSchedule']);
});

Route::group(['prefix' => env('API_PREFIX')], function () {
    Route::post('/patient', [PatientController::class, 'createPatient']);
    Route::get('/patient/{id}', [PatientController::class, 'getPatientByUserId']);
});
