<?php

use App\Livewire\Admin\Social\Event;
use App\Livewire\Admin\Social\Feed;
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
            Route::get('{id}/edit', \App\Livewire\Admin\Social\ServiceEdit::class)->name('admin.social.services.edit');
        });

        Route::get('events', Event::class)->name('admin.social.event');
        Route::get('feeds', Feed::class)->name('admin.social.feeds');


    });

    Route::prefix('wiki')->group(function () {
        Route::get('categories', \App\Livewire\Admin\Wiki\WikiCategory::class)->name('admin.wiki.categories');
        Route::prefix('articles')->group(function() {
            Route::get('/', \App\Livewire\Admin\Wiki\WikiArticle::class)->name('admin.wiki.articles');
            Route::get('/create', \App\Livewire\Admin\Wiki\WikiArticleCreate::class)->name('admin.wiki.articles.create');
            Route::get('/{id}', \App\Livewire\Admin\Wiki\WikiArticleShow::class)->name('admin.wiki.articles.show');
            Route::get('/{id}/edit', \App\Livewire\Admin\Wiki\WikiArticleEdit::class)->name('admin.wiki.articles.edit');
        });
    });

    Route::prefix('railway')->group(function () {
        Route::prefix('engines')->group(function () {
            Route::get('/', \App\Livewire\Admin\Railway\Engine::class)->name('admin.railway.engines');
            Route::get('/create', \App\Livewire\Admin\Railway\EngineCreate::class)->name('admin.railway.engines.create');
            Route::get('/{id}', \App\Livewire\Admin\Railway\EngineShow::class)->name('admin.railway.engines.show');
            Route::get('/{id}/pictures', \App\Livewire\Admin\Railway\EnginePicture::class)->name('admin.railway.engines.pictures');
            Route::get('/{id}/edit', \App\Livewire\Admin\Railway\EngineEdit::class)->name('admin.railway.engines.editer');
        });

        Route::prefix('gares')->group(function () {
            Route::get('/', \App\Livewire\Admin\Railway\Gare\GareList::class)->name('admin.railway.gares');
            Route::get('{id}', \App\Livewire\Admin\Railway\Gare\GareShow::class)->name('admin.railway.gares.show');
        });

        Route::prefix('lignes')->group(function () {
            Route::get('/', \App\Livewire\Admin\Railway\Ligne\LigneList::class)->name("admin.railway.lignes");
            Route::get('{id}', \App\Livewire\Admin\Railway\Ligne\LigneShow::class)->name("admin.railway.lignes.show");
        });

        Route::prefix('badges')->group(function () {
            Route::get('/', \App\Livewire\Admin\Railway\Badge\BadgeList::class)->name('admin.railway.badges');
            Route::get('{id}', \App\Livewire\Admin\Railway\Badge\BadgeShow::class)->name('admin.railway.badges.show');
        });
    });
});
