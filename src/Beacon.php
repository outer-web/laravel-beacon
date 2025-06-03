<?php

namespace Outerweb\Beacon;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;
use Outerweb\Beacon\Contracts\BeaconEventTypeContract;
use Outerweb\Beacon\Enums\BeaconEventType;
use Outerweb\Beacon\Http\Controllers\BeaconApiController;
use Outerweb\Beacon\Models\BeaconEvent;

class Beacon
{
    public function capture(
        BeaconEventTypeContract $type,
        string $label,
        array $properties = [],
        array $customProperties = []
    ): BeaconEvent {
        return $this->eventModel()::capture(
            $type,
            $label,
            $properties,
            $customProperties
        );
    }

    public function appendToCapture(
        BeaconEvent|string $event,
        array $properties = [],
        array $customProperties = []
    ): BeaconEvent {
        return $this->eventModel()::appendToCapture(
            $event,
            $properties,
            $customProperties
        );
    }

    public function validateProperties(
        BeaconEventTypeContract $type,
        array $properties
    ): void {
        $validator = Validator::make($properties, $type->getValidationRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function getVisitorHash(): string
    {
        $agent = new Agent;

        return md5(collect([
            $agent->getUserAgent(),
            $agent->deviceType(),
            $agent->platform(),
            $agent->browser(),
        ])->implode('-'));
    }

    public function eventModel(): string
    {
        return Config::string('beacon.models.event', BeaconEvent::class);
    }

    public function eventTypeEnum(): string
    {
        return Config::string('beacon.enums.event_type', BeaconEventType::class);
    }

    public function apiMiddleware(): array
    {
        return Config::array('beacon.middleware.api', ['api']);
    }

    public function apiController(): string
    {
        return Config::string('beacon.controllers.api', BeaconApiController::class);
    }

    public function deepMerge(array $array1, array $array2): array
    {
        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($array1[$key]) && is_array($array1[$key])) {
                $array1[$key] = $this->deepMerge($array1[$key], $value);
            } else {
                $array1[$key] = $value;
            }
        }

        return $array1;
    }
}
