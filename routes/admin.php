<?php
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    Route::prefix('social')->group(function () {
        Route::prefix('articles')->group(function () {
            Route::get('/', \App\Livewire\Admin\Social\Article::class)->name('admin.social.articles');
            Route::get('/create', \App\Livewire\Admin\Social\ArticleCreate::class)->name('admin.social.articles.create');
            Route::get('{id}', \App\Livewire\Admin\Social\ArticleEdit::class)->name('admin.social.articles.edit');
        });

        Route::prefix('pages')->group(function() {
            Route::get('/', \App\Livewire\Admin\Social\Page::class)->name('admin.social.pages');
            Route::get('/create', \App\Livewire\Admin\Social\PageCreate::class)->name('admin.social.pages.create');
            Route::get('{id}', \App\Livewire\Admin\Social\Page::class)->name('admin.social.pages.edit');
        });
    });
});
