<div>
    <form action="" wire:submit="store">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-title">
                    <span class="iconify" data-icon="mdi:server-add-outline"></span>
                    <span>Nouveau service</span>
                </div>
                <div class="card-toolbar">
                    <x-form.button />
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-9">
                        <x-form.input
                            name="name"
                            label="Nom du service" />
                        <x-form.textarea
                            name="description"
                            label="Description du service"
                            type="ckeditor" />
                        <x-form.input
                            name="url_site"
                            label="Adresse Principal du service" />
                    </div>

                    <div class="col-sm-12 col-lg-3">
                        <x-form.select
                            name="type"
                            :options="\App\Enum\ServiceTypeEnum::selector()"
                            selectType=""
                            no-label="true"
                            placeholder="-- Selectionner un type de service" />

                        <x-form.select
                            name="status"
                            :options="\App\Enum\ServiceStatusEnum::selector()"
                            selectType=""
                            no-label="true"
                            placeholder="-- Selectionner un statut de service" />

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
