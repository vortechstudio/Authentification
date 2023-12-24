<div>
    <form action="" class="rounded-3 bg-white p-5" x-on:submit="$wire.editCategory">
        <x-form.input
            name="name"
            value="{{ $category->name }}"
            is-model="true"
            model="category"
            label="Désignation" />

        <x-form.select
            name="cercle_id"
            label="Appartient au cercle"
            is-model="true"
            model="category"
            :options="\App\Models\Social\Cercle::selector()" />

        <x-form.button />
    </form>
</div>
