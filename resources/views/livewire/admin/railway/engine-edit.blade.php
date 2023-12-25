<div class="rounded-3 bg-white p-5">
    @include("components.layouts.include.alert")
    <div class="stepper stepper-pills" id="stepper_add_engine">
        <div class="stepper-nav flex-center flex-wrap mb-10">
            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                <div class="stepper-wrapper d-flex align-items-center">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">1</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Générales
                        </h3>

                        <div class="stepper-desc">
                            Information sur le matériel
                        </div>
                    </div>
                </div>
                <div class="stepper-line h-40px"></div>
            </div>
            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                <div class="stepper-wrapper d-flex align-items-center">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">2</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Technique
                        </h3>

                        <div class="stepper-desc">
                            Information Technique
                        </div>
                    </div>
                </div>
                <div class="stepper-line h-40px"></div>
            </div>
        </div>
        <form class="form w-lg-75 mx-auto" wire:submit.prevent="update" novalidate="novalidate" id="form_add_engine">
            <div class="flex-column current" data-kt-stepper-element="content">
                <x-form.input
                    name="name"
                    label="Désignation"
                    is-model="true"
                    model="engine"
                    required="true" />

                <x-form.select
                    :options="\App\Models\Railway\Engine::selectorTypeTransport()"
                    label="Type de transport"
                    name="type_transport"
                    select-type="select2"
                    is-model="true"
                    model="engine"
                    required="true" />

                <x-form.select
                    :options="\App\Models\Railway\Engine::selectorTypeTrain()"
                    label="Type de matériel"
                    name="type_train"
                    select-type="select2"
                    is-model="true"
                    model="engine"
                    required="true" />

                <x-form.select
                    :options="\App\Models\Railway\Engine::selectorTypeEnergy()"
                    label="Type d'énergie"
                    name="type_energy"
                    select-type="select2"
                    is-model="true"
                    model="engine"
                    required="true" />

                <div class="row mb-5">
                    <div class="col">
                        <x-form.checkbox
                            name="active"
                            is-model="true"
                            model="engine"
                            label="Publier le matériel" />
                    </div>
                    <div class="col">
                        <x-form.checkbox
                            name="in_shop"
                            is-model="true"
                            model="engine"
                            label="Disponible en boutique" />
                    </div>
                    <div class="col">
                        <x-form.checkbox
                            name="in_game"
                            is-model="true"
                            model="engine"
                            label="Disponible dans le jeux" />
                    </div>
                    <div class="col">
                        <div class="btn-group w-100 w-lg-50" data-kt-button="true" data-kt-buttons-target="[data-kt-button]">
                            <label class="btn btn-outline btn-color-muted btn-active-warning active" data-kt-button="true">
                                <input class="btn-check" type="radio" wire:model.prevent="engine.visual" name="visual" checked="checked" value="beta"/> Béta
                            </label>
                            <label class="btn btn-outline btn-color-muted btn-active-primary" data-kt-button="true">
                                <input class="btn-check" type="radio" name="visual" wire:model.prevent="engine.visual" value="prod"/> Production
                            </label>
                        </div>
                    </div>
                </div>
                <div id="row_shop" class="row d-none">
                    <x-base.underline
                        title="Information sur le tarif en boutique" />
                    <div class="col">
                        <x-form.select
                            name="money_shop"
                            :options="\App\Models\Railway\Engine::selectorMoneyShop()"
                            select-type="select2"
                            is-model="true"
                            model="engine"
                            label="Type de monnaie" />
                    </div>
                    <div class="col">
                        <x-form.input
                            name="price_shop"
                            is-model="true"
                            model="engine"
                            label="Prix" />
                    </div>
                </div>
            </div>
            <div class="flex-column" data-kt-stepper-element="content">
                <div class="row align-items-center">
                    <div class="col">
                        <x-form.input
                            name="essieux"
                            label="Essieux"
                            required="true"
                            is-model="true"
                            model="engine"
                            hint="Le calcul des essieux est automatique et permet de calculer le temps de maintenance" />
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                            <span class="fs-1 fw-bold">Temps de maintenance estimé</span>
                            <span class="fs-3x fw-bold text-blue-600" data-estimate>00:00:00</span>
                        </div>
                    </div>
                </div>
                <div class="separator separator-2 border-gray-600 my-5"></div>
                <div class="row align-items-center">
                    <div class="col">
                        <x-form.input
                            name="velocity"
                            is-model="true"
                            model="engine"
                            label="Vitesse Maximal du matériel"
                            required="true" />
                    </div>
                    <div class="col">
                        <x-form.select
                            name="type_motor"
                            label="Type de motorisation"
                            :options="\App\Models\Railway\Engine::selectorTypeMotor()"
                            required="true"
                            is-model="true"
                            model="engine"
                            select-type="select2" />
                    </div>
                    <div class="col d-none" data-wagon>
                        <x-form.input
                            name="nb_wagon"
                            is-model="true"
                            model="engine"
                            label="Nombre de voiture" />
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                        <x-form.select
                            name="type_marchandise"
                            label="Type de marchandise transporté"
                            :options="\App\Models\Railway\Engine::selectorTypeMarchandise()"
                            select-type="select2"
                            is-model="true"
                            model="engine"
                            required="true" />
                    </div>
                    <div class="col d-none" data-marchandise>
                        <x-form.input
                            name="nb_marchandise"
                            is-model="true"
                            model="engine"
                            label="Nombre de marchandise" />
                    </div>
                </div>
            </div>
            <div class="d-flex flex-stack">
                <div class="me-2">
                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                        <i class="fa-solid fa-arrow-circle-left me-2"></i> Retour
                    </button>
                </div>
                <div>
                    <x-form.button />

                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                        Suivant <i class="fa-solid fa-arrow-circle-right ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        let element = document.querySelector("#stepper_add_engine")
        let stepper = new KTStepper(element)

        stepper.on("kt.stepper.next", function (stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious(); // go previous step
        });
    </script>

    <script type="text/javascript">
        document.querySelector("#in_shop").addEventListener('change', (e) => {
            e.preventDefault()
            let row = document.querySelector("#row_shop")
            if(document.querySelector("#in_shop").checked) {
                row.classList.remove('d-none')
            } else {
                row.classList.add('d-none')
            }
        })

        document.querySelector('#essieux').addEventListener("keyup", e => {
            e.preventDefault()
            if(e.target.value.length > 1) {
                $.ajax({
                    url: '/api/calcul/estimate/essieux',
                    data: {"essieux": e.target.value},
                    success: data => {
                        document.querySelector('[data-estimate]').innerHTML = data.format
                    }
                })
            } else {
                document.querySelector('[data-estimate]').innerHTML = '00:00:00'
            }
        })

        document.querySelector("#type_train").addEventListener('change', e => {
            e.preventDefault()
            let field = document.querySelector('[data-wagon]')
            field.classList.add('d-none')

            if(e.target.value === 'automotrice') {
                field.classList.add('d-none')
            } else {
                field.classList.remove('d-none')
            }
        })

        document.querySelector('#type_marchandise').addEventListener('change', e => {
            e.preventDefault()
            let field = document.querySelector('[data-marchandise]')

            if(e.target.value == 'voiture' || e.target.value == 'automotrice' || e.target.value == 'bus') {
                field.classList.add('d-none')
            } else {
                field.classList.remove('d-none')
            }
        })
    </script>
@endpush
