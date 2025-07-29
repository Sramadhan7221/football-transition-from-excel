<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public $icon;
    public $title;
    public $url;
    public $parent;
    /**
     * Create a new component instance.
     */
    public function __construct(string $icon, string $title, string $url, $parent=null)
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->url = $url;
        $this->parent = $parent;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.item');
    }
}
