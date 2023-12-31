<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('admin.dashboard') }}">
            <img alt="Logo" src="{{ asset('/storage/logos/logo.png') }}" class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('/storage/logos/logo_small.png') }}" class="h-20px app-sidebar-logo-minimize" />
        </a>
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-double-left fs-2 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <x-layout.menu-item
                    route-name="admin.dashboard"
                    icon="fa-solid fa-laptop"
                    title="Tableau de Bord" />

                @foreach(config('menu_head') as $name => $element)
                    @if($element['route'] == request()->route()->named($element['route']) || $element['route'] == request()->route()->named($element['route'].".*"))
                        @if(count($element["children"]) != 0)
                            <x-layout.menu-item
                                sector="true"
                                title="{{ $element['name'] }}" />
                        @endif

                        @foreach($element['children'] as $child)
                            <x-layout.menu-item
                                icon="fa-solid {{ $child['icon'] }}"
                                :route-name="$child['route']"
                                :title="$child['name']" />
                        @endforeach
                    @endif
                @endforeach


            </div>
        </div>
    </div>
</div>
