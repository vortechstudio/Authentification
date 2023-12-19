<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::post('/preview', function (Request $request) {
        $content =json_decode($request->getContent(), true);
        return view('preview', ["blocs" => $content]);
    })->name('admin.preview')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route::prefix('social')->group(function () {
        Route::prefix('articles')->group(function () {
            Route::get('/', \App\Livewire\Admin\Social\Article::class)->name('admin.social.articles');
            Route::get('/create', \App\Livewire\Admin\Social\ArticleCreate::class)->name('admin.social.articles.create');
            Route::get('{id}', \App\Livewire\Admin\Social\ArticleEdit::class)->name('admin.social.articles.edit');
        });

        Route::prefix('pages')->group(function() {
            Route::get('/', \App\Livewire\Admin\Social\Page::class)->name('admin.social.pages');
            Route::get('/create', \App\Livewire\Admin\Social\PageCreate::class)->name('admin.social.pages.create');
            Route::get('{id}', \App\Livewire\Admin\Social\PageEdit::class)->name('admin.social.pages.edit');
        });

        Route::get('cercles', \App\Livewire\Admin\Social\Cercle::class)->name('admin.social.cercles');

        Route::prefix('services')->group(function () {
            Route::get('/', \App\Livewire\Admin\Social\Service::class)->name('admin.social.services');
            Route::get('create', \App\Livewire\Admin\Social\ServiceCreate::class)->name('admin.social.services.create');
            Route::get('{id}', \App\Livewire\Admin\Social\ServiceView::class)->name('admin.social.services.view');
            Route::get('{id}/editor', \App\Livewire\Admin\Social\ServiceEditor::class)->name('admin.social.services.editor');
            Route::get('{id}/edit', \App\Livewire\Admin\Social\Service::class)->name('admin.social.services.edit');

            Route::prefix('{id}/note')->group(function () {

            });
        });
    });
});
