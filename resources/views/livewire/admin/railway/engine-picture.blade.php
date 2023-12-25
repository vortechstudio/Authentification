<div class="rounded-3 bg-white p-5">
    <div class="dropzone" id="uploadImage">
        <div class="dz-message needsclick">
            <i class="fa-solid fa-file-upload fs-3x text-primary"></i>
            <div class="ms-4">
                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Déplacer ou cliquer pour envoyer les images</h3>
                <span class="fs-7 fw-semibold text-gray-500">Taille Maximal: 5Mb</span>
            </div>
        </div>
    </div>
    @push("scripts")
        <script type="text/javascript">
            let dropzone = new Dropzone("#uploadImage", {
                paramName: "image",
                maxFilesize: 5,
                addRemoveLinks: true,
                url: '/api/engines/{{ $engine->id }}/upload'
            })
        </script>
    @endpush
</div>
