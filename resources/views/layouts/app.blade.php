<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'CMS Islamic Mind')</title>
    @include('partials.head')
    @stack('styles')
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    @include('partials.theme-script')

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            @include('partials.header')
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('partials.sidebar')
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    @include('sweetalert::alert')
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
