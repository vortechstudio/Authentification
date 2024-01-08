<?php

namespace App\View\Components\Admin\Wiki;

use App\Models\Wiki\WikiCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WikiEditCategory extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public WikiCategory $category
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.wiki.wiki-edit-category');
    }
}
