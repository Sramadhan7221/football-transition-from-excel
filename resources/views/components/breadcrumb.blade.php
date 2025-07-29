<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
    @foreach ($parents as $item)
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ $item['url'] }}" class="text-muted text-hover-primary">{{ $item['title'] }}</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
    @endforeach
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">{{ $current }}</li>
    <!--end::Item-->
</ul>