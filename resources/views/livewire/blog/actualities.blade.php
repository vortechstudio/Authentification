<div class="d-flex flex-column my-3">
    @foreach($blogs as $blog)
        <div class="d-flex flex-column align-items-start mb-2 border border-left-0 border-top-0 border-right-0 border-2 border-grey-400">
            <span class="fs-6 text-muted">{{ $blog->published_at->format("d/m/Y à H:i") }} par {{ $blog->author }}</span>
            <div class="d-flex align-items-center flex-grow-1">
                <span class="bullet bullet-dot bg-grey-600 me-3"></span>
                <a href="https://{{ config('app.domain') }}/news/{{ $blog->published_at->format('Y') }}/{{ $blog->published_at->format('m') }}/{{ $blog->slug }}" class="fw-bolder text-dark">{{ $blog->title }}</a>
            </div>
        </div>
    @endforeach
</div>
