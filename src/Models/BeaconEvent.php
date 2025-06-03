<?php

namespace Outerweb\Beacon\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Outerweb\Beacon\Contracts\BeaconEventTypeContract;
use Outerweb\Beacon\Facades\Beacon;

class BeaconEvent extends Model
{
    protected $fillable = [
        'uuid',
        'type',
        'label',
        'visitor_hash',
        'session_id',
        'host',
        'path',
        'properties',
        'custom_properties',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $event) {
            $event->uuid = (string) Str::uuid();
        });
    }

    public static function capture(
        BeaconEventTypeContract $type,
        string $label,
        array $properties = [],
        array $customProperties = [],
    ): self {
        Beacon::validateProperties($type, $properties);

        return self::create([
            'type' => $type,
            'label' => $label,
            'visitor_hash' => Beacon::getVisitorHash(),
            'session_id' => Session::getId(),
            'host' => Request::getHost(),
            'path' => Str::start(Request::path(), '/'),
            'properties' => $properties,
            'custom_properties' => $customProperties,
        ]);
    }

    public static function appendToCapture(
        BeaconEvent|string $event,
        array $properties = [],
        array $customProperties = [],
    ): self {
        $event = $event instanceof BeaconEvent ? $event : static::query()
            ->where('uuid', $event)
            ->firstOrFail();

        $properties = Beacon::deepMerge(
            $event->properties,
            $properties
        );

        $customProperties = Beacon::deepMerge(
            $event->custom_properties,
            $customProperties
        );

        Beacon::validateProperties(
            $event->type,
            $properties
        );

        $event->update([
            'properties' => $properties,
            'custom_properties' => $customProperties,
        ]);

        return $event;
    }

    /**
     * @return array{
     *   properties: 'array',
     *   custom_properties: 'array',
     * }
     */
    protected function casts(): array
    {
        return [
            'type' => Beacon::eventTypeEnum(),
            'properties' => 'array',
            'custom_properties' => 'array',
        ];
    }
}
