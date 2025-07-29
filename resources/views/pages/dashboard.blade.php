@extends('layouts.app')

@section('title', $title)

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                {{-- <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{ $title }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <x-breadcrumb 
                        :parents="$breadcrumb->parents"
                        :current="$breadcrumb->current"
                    />
                    <!--end::Breadcrumb-->
                </div> --}}
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xxl-6">
                        <!--begin::Engage widget 10-->
                        <div class="card card-flush">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between mt-9 pb-0">
                                <div class="mb-10">
                                    <!--begin::Title-->
                                    <div class="fs-2hx fw-bold text-gray-800 text-center">
                                        <span class="me-2">Welcome To Application... 
                                        </span>
                                    </div>
                                    <br />
                                    <!--begin::Form-->
                                    <form class="form" action="#" method="post">
                                        <!--begin::Input group-->
                                        <div class="fv-row py-5">
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="kt_dropzonejs_example_1">
                                                <!--begin::Message-->
                                                <div class="dz-message needsclick">
                                                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>
    
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                        <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->
                                        </div>
                                        <!--end::Input group-->
                                    </form>
                                    <!--end::Form-->
                                    <!--end::Title-->
                                    <!--begin::Action-->
                                    <div class="text-center">
                                        <button type="button" id="submit-all" class="btn btn-sm btn-dark fw-bold">
                                            <span class="indicator-label">
                                                Upload
                                            </span>
                                            <span class="indicator-progress">
                                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Engage widget 10-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->  
                <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                    <div class="col-6">
                        <div class="card card-flush">
                            <div class="card-body">
                                <div class="row d-flex align-items-center mx-4 g-5 mb-5">
                                    <img src="{{ url('') }}/storage/no_image.png" id="teamALogo" alt="" style="max-width: 100px;">
                                    <div class="fs-2 fw-bold text-gray-800 text-center" style="width: max-content;">
                                        <span class="me-2" id="teamAName">No Data To Load</span>
                                    </div>
                                </div>
                                <div class="border p-3 mb-5">
                                    <div class="fs-3 fw-bold text-gray-800 text-center mb-5">
                                        <span class="me-2">Transision Statistic</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2">Positive Transition</span>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2" id="teamAPosTrans">: 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2">Negative Transition</span>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2" id="teamANegTrans">: 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2">Turnover Leading into Shot</span>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2" id="teamATransIntoShot">: 0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hover-scroll-y">
                                    <div style="width: 800px;">
                                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="teamA">
                                            <thead>
                                                <tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th style="vertical-align: middle;">Time</th>
                                                    <th style="vertical-align: middle;">Action</th>
                                                    <th style="vertical-align: middle;">Action Time</th>
                                                    <th style="vertical-align: middle;">Zone</th>
                                                    <th style="vertical-align: middle; width: 200px;">Player</th>
                                                    <th style="vertical-align: middle; width: 200px;">Team</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-flush">
                            <div class="card-body">
                                <div class="row d-flex align-items-center mx-4 g-5 mb-5">
                                    <img src="{{ url('') }}/storage/no_image.png" id="teamBLogo" alt="" style="max-width: 100px;">
                                    <div class="fs-2 fw-bold text-gray-800 text-center" style="width: max-content;">
                                        <span class="me-2" id="teamBName">No Data To Load</span>
                                    </div>
                                </div>
                                <div class="border p-3 mb-5">
                                    <div class="fs-3 fw-bold text-gray-800 text-center mb-5">
                                        <span class="me-2">Transision Statistic</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2">Positive Transition</span>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2" id="teamBPosTrans">: 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2">Negative Transition</span>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2" id="teamBNegTrans">: 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2">Turnover Leading into Shot</span>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="fw-bold text-gray-800" style="width: max-content;">
                                                <span class="me-2" id="teamBTransIntoShot">: 0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hover-scroll-y">
                                    <div style="width: 800px;">
                                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="teamB">
                                            <thead>
                                                <tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th style="vertical-align: middle;">Time</th>
                                                    <th style="vertical-align: middle;">Action</th>
                                                    <th style="vertical-align: middle;">Action Time</th>
                                                    <th style="vertical-align: middle;">Zone</th>
                                                    <th style="vertical-align: middle; width: 200px;">Player</th>
                                                    <th style="vertical-align: middle; width: 200px;">Team</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    <!--begin::Footer-->
    @include('partials.footer')
    <!--end::Footer-->
@endsection
@push('styles')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endpush
@push('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!-- Buttons plugins -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- Optional: FileSaver untuk download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        $(document).ready(function () {
            let teamAName = "Data_Team_A";
            let teamBName = "Data_Team_B";
            const tableA = $('#teamA').DataTable({
                responsive: false,
                searching: false,
                dom: 'Bfrtip', // Menambahkan tombol export di atas tabel
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export ke Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: ':visible'
                        },
                        title: function() {
                            // Ambil nama tim dari elemen #teamAName
                            return 'Transition_' + $('#teamAName').text().trim().replace(/\s+/g, '_');
                        }
                    }
                ],
                columnDefs: [
                    { targets: 0, width: '8%' },    
                    { targets: 1, width: '20%' },   
                    { targets: 2, width: '8%' },   
                    { targets: 3, width: '5%' },    
                    { targets: 4, width: '40%' },    
                    { targets: 5, width: '19%' }   
                ]
            });

            const tableB = $('#teamB').DataTable({
                responsive: false,
                searching: false,
                dom: 'Bfrtip', // Menambahkan tombol export di atas tabel
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export ke Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: ':visible'
                        },
                        title: function() {
                            // Ambil nama tim dari elemen #teamAName
                            return 'Transition_' + $('#teamBName').text().trim().replace(/\s+/g, '_');
                        }
                    }
                ],
                columnDefs: [
                    { targets: 0, width: '8%' },    
                    { targets: 1, width: '20%' },   
                    { targets: 2, width: '8%' },   
                    { targets: 3, width: '5%' },    
                    { targets: 4, width: '40%' },    
                    { targets: 5, width: '19%' }    
                ]
            });

            // Inisialisasi Dropzone
            var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
                url: "{{ route('excel.upload') }}", // URL tujuan upload
                paramName: "excel_file", // Nama parameter file di request
                maxFiles: 10,
                maxFilesize: 10, // MB
                addRemoveLinks: true,
                autoProcessQueue: false, // Jangan langsung upload file
                init: function () {
                    var submitButton = document.querySelector("#submit-all"); // Pastikan ID-nya cocok
                    var dz = this;
    
                    submitButton.addEventListener("click", function (e) {
                        $("#submit-all")
                        .attr("data-kt-indicator", "on")
                        .attr("disabled", true);
                        e.preventDefault();
                        dz.processQueue(); // Proses file secara manual
                    });
    
                    dz.on("sending", function(file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");
                    });
    
                    dz.on("success", function(file, response) {

                        const [teamAKey, teamBKey] = Object.keys(response.data);
                        const teamAData = response.data[teamAKey].logs;
                        const teamBData = response.data[teamBKey].logs;
                        $("#teamALogo").attr('src', "{{ url('') }}/storage/"+teamAKey+".png");                    
                        $("#teamAName").text(teamAKey.toUpperCase());                    
                        $("#teamAPosTrans").text(response.data[teamAKey].attacking);                    
                        $("#teamANegTrans").text(response.data[teamAKey].defending);                    
                        $("#teamATransIntoShot").text(response.data[teamAKey].into_shot);                    
                        $("#teamBLogo").attr('src', "{{ url('') }}/storage/"+teamBKey+".png");                    
                        $("#teamBName").text(teamBKey.toUpperCase());                    
                        $("#teamBPosTrans").text(response.data[teamBKey].attacking);                    
                        $("#teamBNegTrans").text(response.data[teamBKey].defending);                    
                        $("#teamBTransIntoShot").text(response.data[teamBKey].into_shot);                    

                        // Bersihkan dan masukkan data baru ke masing-masing tabel
                        const formatRow = (item, index) => [
                            item.transition_time,
                            item.action,
                            item.action_time,
                            item.zone,
                            item.actor,
                            item.team
                        ];
                       
                        const rowsA = teamAData.map(formatRow);
                        const rowsB = teamBData.map(formatRow);
                        tableA.clear().rows.add(rowsA).draw();
                        tableB.clear().rows.add(rowsB).draw();

                        $("#submit-all")
                            .removeAttr("data-kt-indicator")
                            .attr("disabled", false);
                    });
    
                    dz.on("error", function(file, errorMessage) {
                        console.error("Upload gagal:", errorMessage);
                    });
    
                    dz.on("complete", function(file) {
                        // dz.removeFile(file); 
                    });
                }
            });
            
        });

    </script>
@endpush
