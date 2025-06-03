<?php

namespace Outerweb\Beacon\Components;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Outerweb\Beacon\Facades\Beacon;

class Script extends Component
{
    public function __construct(
        public bool $capturePageViews = true,
        public bool $debug = false,
    ) {}

    public function render()
    {
        if (! Cookie::has(Beacon::uuidCookieName())) {
            $uuid = Str::uuid()->toString();

            Cookie::queue(
                Beacon::uuidCookieName(),
                $uuid,
                60 * 24 * 365, // 1 year
            );
        }

        return view('beacon::components.script');
    }
}
