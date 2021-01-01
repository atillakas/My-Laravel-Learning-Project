<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductFilterByCategory extends Component
{
    public $filter;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.product-filter-by-category');
    }
}
