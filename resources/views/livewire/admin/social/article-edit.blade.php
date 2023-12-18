<div class="card shadow-lg">
    <div class="card-header">
        <div class="card-title">Edition de l'article: {{ $article->title }}</div>
        <div class="card-toolbar">
            <a href="{{ route('admin.social.articles') }}" class="btn btn-sm btn-outline btn-outline-primary">
                <i class="fa-solid fa-arrow-circle-left fs-3 me 3"></i>
                <span>Retour</span>
            </a>
        </div>
    </div>
    <form action="" wire:submit.prevent="update">
        @csrf
        <div class="card-body">
            @if(session()->has('message'))
                <x-base.alert
                    type="success"
                    icon="fa-solid fa-check"
                    title="Succès"
                    :content="session()->get('message')" />
            @endif
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <div class="mb-10">
                        <label for="title" class="form-label required">Titre</label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg @error('article.title') is-invalid @enderror" placeholder="Titre de l'article" value="{{ $article->title }}" wire:model="article.title">
                        @error('article.title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-10" wire:ignore>
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" wire:model="article.description">{!! $article->description !!}</textarea>
                    </div>
                    <div class="mb-10" wire:ignore>
                        <label for="contenue" class="form-label required">Contenue</label>
                        <textarea id="contenue" name="contenue" wire:model="article.contenue">{!! $article->contenue !!}</textarea>
                        @error('article.contenue')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="mb-10">
                        <label for="category" class="form-label">Catégorie</label>
                        <select id="category" class="form-select" data-placeholder="-- Selectionner une catégory --" wire:model="article.category">
                            <option value="{{ $article->category }}">{{ \App\Enum\BlogCategoryEnum::get($article->category) }}</option>
                            @foreach(\App\Enum\BlogCategoryEnum::all() as $k => $category)
                                <option value="{{ $k }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-10">
                        <label for="subcategory" class="form-label">Sous Catégorie</label>
                        <select id="subcategory" class="form-select" data-placeholder="-- Selectionner une sous catégorie --" wire:model="article.subcategory">
                            <option value="{{ $article->subcategory }}">{{ \App\Enum\BlogSubcategoryEnum::get($article->subcategory) }}</option>
                            @foreach(\App\Enum\BlogSubcategoryEnum::all() as $k => $subcategory)
                                <option value="{{ $k }}">{{ $subcategory }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-10">
                        <label for="cercle_id" class="form-label ">Appartient à un cerle social</label>
                        <select id="cercle_id" class="form-select" data-placeholder="-- Selectionner un cercle --" wire:model="cercle_id">
                            <option value="{{ $article->cercles()->first()->id }}">{{ $article->cercles()->first()->name }}</option>
                            @foreach(\App\Models\Social\Cercle::all() as $cercle)
                                <option value="{{ $cercle->id }}">{{ $cercle->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-10">
                        <label for="author" class="form-label required">Auteur</label>
                        <select id="author" class="form-select" data-placeholder="-- Selectionner un auteur --" wire:model="article.author">
                            <option value="{{ $article->author }}">{{ \App\Enum\BlogAuthorEnum::get($article->author) }}</option>
                            @foreach(\App\Enum\BlogAuthorEnum::all() as $k => $author)
                                <option value="{{ $k }}">{{ $author }}</option>
                            @endforeach
                        </select>
                        @error('article.author')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-10">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" wire:model="article.published" {{ $article->published ? 'checked' : '' }} value="true" id="published"/>
                            <label class="form-check-label" for="published">
                                Publié l'article
                            </label>
                        </div>
                    </div>
                    <div class="mb-10">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" wire:model="article.publish_to_social" {{ $article->publish_to_social ? 'checked' : '' }} value="true" id="publish_social"/>
                            <label class="form-check-label" for="publish_social">
                                Publié sur les réseaux
                            </label>
                        </div>
                    </div>
                    <div class="mb-10">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" wire:model="article.promote" {{ $article->promote ? 'checked' : '' }} value="true" id="promote"/>
                            <label class="form-check-label" for="promote">
                                Mise en avant
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Valider</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')

    <script src="{{ asset('/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    console.log(editor.getData());
                    @this.set('description', editor.getData())
                })
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#contenue'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    console.log(editor.getData());
                    @this.set('contenue', editor.getData())
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

