<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        <title>@yield('title', 'CMS Islamic Mind')</title>
        @include('partials.head')
        @stack('styles')
		<style>
			[x-cloak] { display: none !important; }
		</style>
		<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		@include('partials.theme-script')
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">

			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				@include('sweetalert::alert')
                @yield('content')
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->

        @include('partials.scripts')
        @stack('scripts')
	</body>
	<!--end::Body-->
</html>