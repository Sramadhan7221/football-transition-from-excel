<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
        public $parents;
    public $current;
    /**
     * Create a new component instance.
     */
    public function __construct(array $parents, string $current)
    {
        $this->parents = $parents;
        $this->current = $current;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
