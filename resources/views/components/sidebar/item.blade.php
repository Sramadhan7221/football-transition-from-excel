@php
    $isActive = request()->url() === url($url);
@endphp

<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
        <span class="menu-icon">
            {!! $icon !!}
            {{-- <i class="ki-duotone ki-code fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i> --}}
        </span>
        <span class="menu-title">{{ $title }}</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->