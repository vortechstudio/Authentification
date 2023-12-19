<div class="container-fluid">
    <div class="d-flex flex-row align-items-center">
        <div class="w-50 bgi-size-contain bgi-position-center" style="background-image: url('{{ $bloc['background'] }}')"></div>
        <div class="w-50">
            <div class="d-flex flex-column">
                <x-base.underline
                    :title="$bloc['title']" />
                {!! $bloc['content'] !!}
            </div>
        </div>
    </div>
</div>
