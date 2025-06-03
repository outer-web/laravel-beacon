<?php

namespace Outerweb\Beacon\Components;

use Illuminate\View\Component;

class Script extends Component
{
    public function __construct(
        public bool $capturePageViews = true,
        public bool $debug = false,
    ) {}

    public function render()
    {
        return view('beacon::components.script');
    }
}
