<?php

namespace Outerweb\Beacon\Enums;

use Outerweb\Beacon\Contracts\BeaconEventTypeContract;

enum BeaconEventType: string implements BeaconEventTypeContract
{
    case PageView = 'page_view';
    case Click = 'click';
    case FormSubmission = 'form_submission';

    public function getLabel(): string
    {
        return match ($this) {
            self::PageView => __('laravel-beacon::events.types.page_view'),
            self::Click => __('laravel-beacon::events.types.click'),
            self::FormSubmission => __('laravel-beacon::events.types.form_submission'),
        };
    }

    public function getProperties(): array
    {
        return match ($this) {
            self::PageView => [
                'title',
                'duration_in_seconds',
                'referrer',
            ],
            self::Click => [
                'href',
            ],
            default => [],
        };
    }

    public function getValidationRules(): array
    {
        return match ($this) {
            self::PageView => [
                'title' => ['required', 'string'],
                'duration_in_seconds' => ['required', 'integer'],
                'referrer' => ['nullable', 'string'],
            ],
            self::Click => [
                'href' => ['nullable', 'string'],
            ],
            self::FormSubmission => [],
        };
    }
}
