<div class="mb-10" wire:ignore>
    <form action="" wire:submit.prevent="update">
        <x-form.textarea
            name="page_content"
            type="ckeditor"
            no-label="true"
            placeholder="Contenue de la page" />
        <x-form.button />
    </form>
</div>
