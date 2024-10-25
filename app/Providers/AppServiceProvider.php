<?php

namespace App\Providers;

use App\Repository\AuthRepository;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use App\Repository\PatientRepository;
use App\Repository\QueueRepository;
use App\Repository\ReservationRepository;
use App\Repository\ScheduleRepository;
use App\Repository\UserRepository;
use App\RepositoryImpl\AuthRepositoryImpl;
use App\RepositoryImpl\ClinicRepositoryImpl;
use App\RepositoryImpl\DoctorRepositoryImpl;
use App\RepositoryImpl\PatientRepositoryImpl;
use App\RepositoryImpl\QueueRepositoryImpl;
use App\RepositoryImpl\ReservationRepositoryImpl;
use App\RepositoryImpl\ScheduleRepositoryImpl;
use App\RepositoryImpl\UserRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepository::class, AuthRepositoryImpl::class);
        $this->app->bind(ClinicRepository::class, ClinicRepositoryImpl::class);
        $this->app->bind(DoctorRepository::class, DoctorRepositoryImpl::class);
        $this->app->bind(ReservationRepository::class, ReservationRepositoryImpl::class);
        $this->app->bind(ScheduleRepository::class, ScheduleRepositoryImpl::class);
        $this->app->bind(QueueRepository::class, QueueRepositoryImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(PatientRepository::class, PatientRepositoryImpl::class);
        $this->app->bind(ReservationRepository::class, ReservationRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
