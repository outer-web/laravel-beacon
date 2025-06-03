<?php

namespace Outerweb\Beacon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Outerweb\Beacon\Facades\Beacon;

class BeaconEventCaptureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::enum(Beacon::eventTypeEnum()),
            ],
            'label' => [
                'required',
                'string',
                'max:255',
            ],
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
