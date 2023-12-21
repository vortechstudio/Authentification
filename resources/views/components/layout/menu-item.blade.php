@if(!$sector)
    <div class="menu-item {{ request()->routeIs($routeName) ? 'here show' : '' }}">
        <a href="{{ $routeName ? route($routeName) : ($url ?? "#") }}" class="menu-link" wire:navigate>
        <span class="menu-icon">
            @if($iconHtml)
                {!! $icon !!}
            @else
                <i class="{{ $icon }} fs-2"></i>
            @endif
        </span>
            <span class="menu-title">{{ $title }}</span>
        </a>
    </div>
@else
    <div class="menu-item pt-5">
        <div class="menu-content">
            <span class="menu-heading fw-bold text-uppercase fs-7">{{ $title }}</span>
        </div>
    </div>
@endif
