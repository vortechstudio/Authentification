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
                    icon="<span class='iconify fs-2' data-icon='mdi:monitor-dashboard'></span>"
                    icon-html="true"
                    title="Tableau de Bord" />

                <x-layout.menu-item
                    sector="true"
                    title="Social & Blog" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='fluent-mdl2:articles'></span>"
                    icon-html="true"
                    route-name="admin.social.articles"
                    title="Articles" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='fluent-mdl2:page-list'></span>"
                    icon-html="true"
                    route-name="admin.social.pages"
                    title="Pages" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='subway:cercle-6'></span>"
                    route-name="admin.social.cercles"
                    icon-html="true"
                    title="Cercles" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='eos-icons:service-plan-outlined'></span>"
                    route-name="admin.social.services"
                    icon-html="true"
                    title="Services" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='mdi:event-star'></span>"
                    icon-html="true"
                    title="Evènements" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='fluent:person-feedback-20-regular'></span>"
                    icon-html="true"
                    title="Poste Sociales" />

                <x-layout.menu-item
                    sector="true"
                    title="Wiki" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='arcticons:wikihow'></span>"
                    icon-html="true"
                    title="Wiki" />


                <x-layout.menu-item
                    sector="true"
                    title="Railway Manager" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='emojione-monotone:light-rail'></span>"
                    icon-html="true"
                    title="Matériels Roulants" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='fluent-emoji-high-contrast:station'></span>"
                    icon-html="true"
                    title="Gares & Hubs" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='ooui:map-trail'></span>"
                    icon-html="true"
                    title="Lignes" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='material-symbols-light:rewarded-ads-outline'></span>"
                    icon-html="true"
                    title="Badges & Récompenses" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='teenyicons:contract-outline'></span>"
                    icon-html="true"
                    title="Service de location" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='pepicons-print:bank-circle'></span>"
                    icon-html="true"
                    title="Service Bancaire" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='lets-icons:setting-vert'></span>"
                    icon-html="true"
                    title="Configurations" />

                <x-layout.menu-item
                    sector="true"
                    title="Administration" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='gravity-ui:signal'></span>"
                    icon-html="true"
                    title="Pulse" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='lets-icons:view-horizont-duotone'></span>"
                    icon-html="true"
                    title="Horizon" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='ant-design:schedule-outlined'></span>"
                    icon-html="true"
                    title="Totem" />

                <x-layout.menu-item
                    icon="<span class='iconify fs-2' data-icon='ant-design:schedule-outlined'></span>"
                    route-name="log"
                    icon-html="true"
                    title="Log Système" />

            </div>
        </div>
    </div>
</div>
