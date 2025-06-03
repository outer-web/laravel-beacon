<?php

namespace Outerweb\Beacon\Contracts;

interface BeaconEventTypeContract
{
    public function getLabel(): string;

    public function getProperties(): array;

    public function getValidationRules(): array;
}
