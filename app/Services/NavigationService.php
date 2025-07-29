<?php

namespace App\Services;

use Illuminate\Support\Collection;

class NavigationService
{
    public static function getMenus() : Collection
    {
        return collect([
            (object)[
                'icon' => '<i class="ki-duotone ki-element-11 fs-1">
					            <span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>',
                'title' => 'Dashboard',
                'url' => route('excel.form'),
                'items' => collect([]),
                'content' => false
            ]
        ]);
    }
}
