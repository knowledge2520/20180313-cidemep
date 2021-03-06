<?php

namespace Modules\Pemedic\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Pemedic\Events\Handlers\RegisterPemedicSidebar;

class PemedicServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $middleware = [
        'api.mytoken' => CustAuthApiToken::class
    ];
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterPemedicSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('pemedic', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Pemedic\Repositories\PemedicRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentPemedicRepository(new \Modules\Pemedic\Entities\Pemedic());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CachePemedicDecorator($repository);
            }
        );
// add bindings
        $this->app->bind(
            'Modules\Pemedic\Repositories\UserProfileRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentUserProfileRepository(new \Modules\Pemedic\Entities\UserProfile());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheUserProfileDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\UserRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentUserRepository(new \Modules\Pemedic\Entities\User());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheUserDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\ClinicProfileRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentClinicProfileRepository(new \Modules\Pemedic\Entities\ClinicProfile());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheClinicProfileDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\ActivationRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentActivationRepository(new \Modules\Pemedic\Entities\Activation());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheActivationProfileDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\MedicalRecordRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentMedicalRecordRepository(new \Modules\Pemedic\Entities\MedicalRecord());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheMedicalRecordDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\MedicalRecordFileRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentMedicalRecordFileRepository(new \Modules\Pemedic\Entities\MedicalRecordFile());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheMedicalRecordFileDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\NewRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentNewRepository(new \Modules\Pemedic\Entities\News());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheNewDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\InsuranceRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentInsuranceRepository(new \Modules\Pemedic\Entities\Insurance());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheInsuranceDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\VoucherRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentVoucherRepository(new \Modules\Pemedic\Entities\Voucher());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheVoucherDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\GroupRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentGroupRepository(new \Modules\Pemedic\Entities\Group());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheGroupDecorator($repository);
            }
        );
        
        $this->app->bind(
            'Modules\Pemedic\Repositories\VoucherPatientRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentVoucherPatientRepository(new \Modules\Pemedic\Entities\VoucherPatient());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheVoucherPatientDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\MessageRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentMessageRepository(new \Modules\Pemedic\Entities\Message());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheMessageDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Pemedic\Repositories\NewsRepository',
            function () {
                $repository = new \Modules\Pemedic\Repositories\Eloquent\EloquentNewsRepository(new \Modules\Pemedic\Entities\News());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pemedic\Repositories\Cache\CacheNewsDecorator($repository);
            }
        );
    }
}
