<?php

namespace SolutionForest\FilamentAccessManagement;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use SolutionForest\FilamentAccessManagement\Facades\FilamentAuthenticate;
use SolutionForest\FilamentAccessManagement\Http\Auth\Permission;

class FilamentAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            $this->configureNavigation();
            $this->configureComponent();
        });
    }

    protected function configureNavigation()
    {
        if (config('filament-access-management.filament.navigation.enabled', false)) {
            Filament::navigation(function (NavigationBuilder $builder) {
                if ($customBuilder = FilamentAuthenticate::getCustomNavigation()) {
                    $builder = $customBuilder;
                }

                return $builder->groups(FilamentAuthenticate::getUserNavigationGroups());
            });
        }
    }

    protected function configureComponent()
    {
        if (config('filament-access-management.filament.path_permission_checking.action', false)) {
            \Filament\Support\Actions\BaseAction::configureUsing(function (\Filament\Support\Actions\BaseAction $component) {
                if (method_exists($component, 'getUrl')) {
                    $component->hidden(function () use ($component) {
                        $url = $component->getUrl();

                        if (empty($url)) {
                            return false;
                        }

                        return ! Permission::checkPermission($url);
                    });
                }
            });
        }
    }
}
