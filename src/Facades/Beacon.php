<?php

namespace Outerweb\Beacon\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Outerweb\Beacon\Models\BeaconEvent capture(
 *    \Outerweb\Beacon\Contracts\BeaconEventTypeContract $type,
 *    string $label,
 *    array $properties = [],
 *    array $customProperties = []
 * )
 * @method static \Outerweb\Beacon\Models\BeaconEvent appendToCapture(
 *    \Outerweb\Beacon\Models\BeaconEvent|string $event,
 *    array $properties = [],
 *    array $customProperties = []
 * )
 * @method static void validateProperties(
 *    \Outerweb\Beacon\Contracts\BeaconEventTypeContract $type,
 *    array $properties
 * )
 * @method static string getVisitorHash()
 * @method static string eventTypeEnum()
 * @method static string eventModel()
 * @method static string apiMiddleware()
 * @method static string apiController()
 * @method static array deepMerge(array $array1, array $array2)
 *
 * @see \Outerweb\Beacon\Beacon
 */
class Beacon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Outerweb\Beacon\Beacon::class;
    }
}
