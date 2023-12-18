<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogViewer - Created by ARCANEDEV</title>
    <link rel="stylesheet" href="{{ asset('/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.bundle.css') }}">
</head>
<body id="kt_app_body"
      data-kt-app-layout="dark-sidebar"
      data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true"
      data-kt-app-sidebar-fixed="true"
      data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true"
      data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true"
      data-kt-app-toolbar-enabled="true"
      class="app-default">

<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @include("components.layouts.include.header")
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            @include('components.layouts.include.sidebar')
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="d-flex flex-column flex-column-fluid">
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        @include('components.layouts.include.toolbar')
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            @include("components.layouts.include.alert")
                            @yield("content")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
@yield('modals')
@yield('scripts')
</body>
</html>
