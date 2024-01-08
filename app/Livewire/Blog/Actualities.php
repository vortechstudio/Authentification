<?php

namespace App\Livewire\Blog;

use App\Models\Blog;
use Livewire\Component;

class Actualities extends Component
{
    public mixed $blogs;

    public string $type;

    public string $sub;

    public int $limit = 3;

    public function mount()
    {
        $this->blogs = Blog::where('category', $this->type)
            ->where('subcategory', $this->sub)
            ->orderBy('published_at', 'desc')
            ->limit($this->limit)
            ->get();

    }

    public function render()
    {
        return view('livewire.blog.actualities');
    }
}
