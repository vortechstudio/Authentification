<td colspan="3">
    <form action="" wire:submit.prevent="save">
        @csrf
        <x-form.input
            name="name"
            label="Désignation"
            :value="$setting->name"
            required="true" />

        <x-form.input
            name="value"
            label="Valeur"
            :value="$setting->value"
            required="true" />

        <x-form.button />
    </form>
</td>
