<div>
    <form action="" wire:submit="update">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">
                    <span class="iconify" data-icon="mdi:server-add-outline"></span>
                    <span>Edition du service {{ $service->name }}</span>
                </div>
                <div class="card-toolbar">
                    <x-form.button />
                    <a href="{{ route('admin.social.services') }}" class="btn btn-outline btn-outline-dark ms-5">
                        <i class="fa-solid fa-arrow-circle-left fs-2 me-5"></i> Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-9">
                        <x-form.input
                            name="name"
                            is-model="true"
                            value="{{ $service->name }}"
                            model="service"
                            label="Nom du service" />
                        <x-form.textarea
                            name="description"
                            is-model="true"
                            :value="$service->description"
                            model="service"
                            label="Description du service"
                            type="ckeditor" />
                        <x-form.input
                            name="url_site"
                            is-model="true"
                            :value="$service->url_site"
                            model="service"
                            label="Adresse Principal du service" />
                    </div>

                    <div class="col-sm-12 col-lg-3">
                        <x-form.select
                            name="type"
                            :options="\App\Enum\ServiceTypeEnum::selector()"
                            selectType=""
                            is-model="true"
                            model="service"
                            no-label="true"
                            placeholder="-- Selectionner un type de service" />

                        <x-form.select
                            name="status"
                            :options="\App\Enum\ServiceStatusEnum::selector()"
                            selectType=""
                            is-model="true"
                            model="service"
                            no-label="true"
                            placeholder="-- Selectionner un statut de service" />

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
