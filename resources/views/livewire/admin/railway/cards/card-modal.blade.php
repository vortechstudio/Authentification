<div>
    <form action="" method="POST" id="formaddCard" wire:submit.prevent="save">
        @csrf
        <div class="modal-body" x-data="{type: ''}">
            <div class="col-6">
                <x-form.select
                    name="form.class"
                    select-type="select2"
                    label="Porte Carte"
                    :options="\App\Models\Railway\RailwayAdvantageCard::selectorClass()"
                    required="true" />
            </div>
            <div class="col-6">
                <x-form.select
                    name="form.type"
                    select-type="select2"
                    label="Type de carte"
                    :options="\App\Models\Railway\RailwayAdvantageCard::selectorType()"
                    required="true" />
            </div>
            <div class="col-6">
                <x-form.input
                    name="form.qte"
                    label="Montant/Quantité"
                    required="true" />
            </div>
            <div class="col-6">
                <x-form.input
                    name="form.tpoint_cost"
                    label="Cout pour le joueurs"
                    required="true" />
            </div>
        </div>

        <x-form.select
            select-type="select2"
            name="form.model_id"
            label="Modèle du matériel roulant"
            :options="\App\Models\Railway\Engine::selector()"
            hint="Si la carte est un matériel roulant" />
            <div class="row">

        </div>

        <x-form.button />

    </form>
</div>
