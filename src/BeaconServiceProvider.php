<?php

namespace Outerweb\Beacon;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BeaconServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-beacon')
            ->hasConfigFile()
            ->hasMigrations([
                'create_beacon_events_table',
            ])
            ->hasTranslations()
            ->hasViews()
            ->hasRoutes(['api'])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations();

                $composerFile = file_get_contents(__DIR__.'/../composer.json');

                if ($composerFile) {
                    $githubRepo = json_decode($composerFile, true)['homepage'] ?? null;

                    if ($githubRepo) {
                        $command
                            ->askToStarRepoOnGitHub($githubRepo);
                    }
                }
            });

        Blade::componentNamespace('Outerweb\Beacon\Components', 'beacon');
    }
}
