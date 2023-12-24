<div>
    @include("components.layouts.include.alert")
    <div class="d-flex flex-row justify-content-end mb-10 p-5">
        <a href="{{ route('admin.wiki.articles') }}" class="btn btn-sm btn-outline btn-outline-dark">
            <i class="fa-solid fa-arrow-circle-left me-2"></i> Retour
        </a>
    </div>
    <div class="rounded bg-white mb-10 p-5">
        <form action="" wire:submit.prevent="editArticle">
            <div class="card shadow-lg mb-10">
                <div class="card-header">
                    <div class="card-title"></div>
                    <div class="card-toolbar">
                        <x-form.button />
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-9">
                            <x-form.input
                                name="title"
                                label=""
                                no-label="true"
                                is-model="true"
                                model="wiki"
                                placeholder="Titre de l'article"
                                :value="$wiki->title"
                                required="true" />

                            <x-form.textarea
                                name="synopsis"
                                label=""
                                no-label="true"
                                is-model="true"
                                model="wiki"
                                placeholder="Rapide description de l'article"
                                required="true"
                                :value="$wiki->synopsis"
                                type="ckeditor" />
                        </div>
                        <div class="col-sm-12 col-lg-3">
                            <x-form.select
                                name="wiki_category_id"
                                label=""
                                no-label="true"
                                is-model="true"
                                model="wiki"
                                :options="$categories"
                                :value="$wiki->wiki_category_id"
                                placeholder="-- Selectionner une categorie" />
                            <x-form.select
                                name="wiki_subcategory_id"
                                label=""
                                no-label="true"
                                is-model="true"
                                model="wiki"
                                :options="$subcategories"
                                :value="$wiki->wiki_subcategory_id"
                                placeholder="-- Selectionner une sous categorie" />
                            <div x-data="{expanded: false}">
                                <x-form.switches
                                    name="posted"
                                    label="Poster l'article"
                                    is-model="true"
                                    model="wiki"
                                    :checked="$wiki->posted"
                                    alpine="true"
                                    fun-alpine="expanded = ! expanded" />
                                <div x-show="expanded" class="mt-10">
                                    <x-form.input
                                        name="posted_at"
                                        label=""
                                        no-label="true"
                                        is-model="true"
                                        :value="$wiki->posted_at"
                                        model="wiki"
                                        type="text" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="card-title">Contenue de l'article</div>
                </div>
                <div class="card-body">
                    <x-form.textarea
                        name="content"
                        label=""
                        no-label="true"
                        is-model="true"
                        model="wiki"
                        :value="$wiki->content"
                        type="ckeditor" />
                </div>
            </div>
        </form>
    </div>
    @push("scripts")
        <script type="text/javascript">
            new tempusDominus.TempusDominus(document.querySelector('[name="posted_at"]'), {
                localization: {
                    locale: "fr",
                    startOfTheWeek: 1,
                    format: "dd/MM/yyyy"
                }
            })
        </script>
    @endpush
</div>
