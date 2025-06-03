<?php

namespace Outerweb\Beacon\Http\Controllers;

use Illuminate\Routing\Controller;
use Outerweb\Beacon\Facades\Beacon;
use Outerweb\Beacon\Http\Requests\BeaconEventAppendToCaptureRequest;
use Outerweb\Beacon\Http\Requests\BeaconEventCaptureRequest;
use Outerweb\Beacon\Http\Resources\BeaconEventResource;
use Outerweb\Beacon\Models\BeaconEvent;

class BeaconApiController extends Controller
{
    public function capture(BeaconEventCaptureRequest $request): BeaconEventResource
    {
        $event = Beacon::capture(
            type: Beacon::eventTypeEnum()::from($request->validated('type')),
            label: $request->validated('label'),
            properties: $request->validated('properties', []),
            customProperties: $request->validated('custom_properties', [])
        );

        return BeaconEventResource::make($event);
    }

    public function appendToCapture(BeaconEventAppendToCaptureRequest $request, BeaconEvent $event): BeaconEventResource
    {
        if ($event->visitor_hash !== Beacon::getVisitorHash()) {
            abort(403, 'Visitor hash mismatch');
        }

        $event = Beacon::appendToCapture(
            event: $event,
            properties: $request->validated('properties', []),
            customProperties: $request->validated('custom_properties', [])
        );

        return BeaconEventResource::make($event);
    }
}
