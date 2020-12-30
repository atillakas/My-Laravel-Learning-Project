<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FeaturedProduct extends Component
{

    public $sliders;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sliders)
    {
        $this->sliders = $sliders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.home.featured-product');
    }
}
