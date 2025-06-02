<?php

namespace Outerweb\Beacon;

use Outerweb\Beacon\Commands\BeaconCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BeaconServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-beacon')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_beacon_table')
            ->hasCommand(BeaconCommand::class);
    }
}
