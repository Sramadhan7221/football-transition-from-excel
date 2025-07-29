<!--begin::Menu-->
<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
    @foreach ($menus as $menu)
        @if ($menu->content)
            <x-sidebar.item-content
                :title="$menu->title"
            />
        @else
            <x-sidebar.item 
                :icon="$menu->icon" 
                :title="$menu->title" 
                :url="$menu->url" 
            />
        @endif
    @endforeach
</div>
<!--end::Menu-->