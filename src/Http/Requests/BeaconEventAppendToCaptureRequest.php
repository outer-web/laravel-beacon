<?php

namespace Outerweb\Beacon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeaconEventAppendToCaptureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'properties' => [
                'nullable',
                'array',
            ],
            'custom_properties' => [
                'nullable',
                'array',
            ],
        ];
    }
}
