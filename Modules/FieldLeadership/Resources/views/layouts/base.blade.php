<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon/alamtri.png') }}">

    {{-- <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}"> --}}
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    {{-- <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}"> --}}
    <meta name="theme-color" content="#ffffff">

    <!-- Font Library -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Fontawesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome-6.4.0/css/all.min.css') }}" />

    <!-- Font Library -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Css File -->
    <link id="custom-css" href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <link id="custom-css" href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />

    <!-- Bootstrap Library-->
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-5.3.0/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">

    <!-- Css File -->
    <link id="custom-css" href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <link id="custom-css" href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />

    <!-- Alpinejs Library -->
    @stack('plugin-alpine')
    <script defer src="{{ asset('assets/libs/alpinejs/dist/cdn.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

    <title>Adaro Admin</title>

    @yield('include_css')
    @livewireStyles

    <style>
        .btn-basic-green {
            background: #00552F !important;
        }

        table tbody tr.selected {
            background-color: #C7FFE64D;
        }

        table tbody tr td.action img {
            transform: rotate(90deg);
        }

        table tbody tr td.action a:hover {
            background: transparent !important;
        }

        .collapse.sub-menu {
            padding: 10px 0 !important;
        }

        .collapse.sub-menu .item-sidebar a {
            padding: 10px 20px 10px 50px;
        }
    </style>

    @stack('styles')

</head>

<body x-data="{ isSidebar: false }">

    {{ $slot }}

    <!-- Javascript Libraries -->
    <script src="{{ asset('assets/libs/popper/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-5.3.0/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script type="text/javasccript" src="{{ asset('asset/js/scripts.js') }}"></script>

    <script>
        // custom sweetalert
        const newSwal = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-basic-green text-white me-2',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        });

        window.addEventListener('swal', function(e) {
            newSwal.fire(e.detail);
        });
        window.addEventListener('swal-loading', function() {
            Swal.showLoading();
        });
    </script>

    @if (session()->has('success'))
        <script>
            newSwal.fire({
                title: 'Success',
                icon: 'success',
                text: "{{ session()->get('success') }}",
            });
        </script>
    @endif

    @include('fieldleadership::layouts.partials.preview-modal')

    <script type="text/javascript">
        function previewBlobFile(id, fileName, type = 'document') {
            const modal = new bootstrap.Modal(document.getElementById('previewAttachmentModal'));
            const spinner = document.getElementById('preview-loading-spinner');
            const pdfContainer = document.getElementById('preview-pdf-container');
            const pdfIframe = document.getElementById('preview-pdf-iframe');
            const imgContainer = document.getElementById('preview-image-container');
            const imgElement = document.getElementById('preview-image-element');
            const officeContainer = document.getElementById('preview-office-container');
            const officeIframe = document.getElementById('preview-office-iframe');
            const fallbackContainer = document.getElementById('preview-fallback-container');
            const downloadBtn = document.getElementById('preview-download-btn');
            const titleSpan = document.getElementById('preview-file-name');

            // Set title and show loading/modal
            titleSpan.innerText = fileName;
            spinner.classList.remove('d-none');
            pdfContainer.classList.add('d-none');
            imgContainer.classList.add('d-none');
            officeContainer.classList.add('d-none');
            fallbackContainer.classList.add('d-none');

            modal.show();

            const routeUrl = "{{ route('field-leadership::files.sas-uri', ['id' => ':id']) }}".replace(':id', id) + '?type=' + type;

            fetch(routeUrl)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.error) throw new Error(data.error);

                    const url = data.url;
                    const ext = data.extension;

                    if (ext === 'pdf') {
                        const previewUrl = "{{ route('field-leadership::files.preview', ['id' => ':id']) }}".replace(':id', id) + '?type=' + type;
                        pdfIframe.src = previewUrl;
                        pdfContainer.classList.remove('d-none');
                    } else if (['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(ext)) {
                        const previewUrl = "{{ route('field-leadership::files.preview', ['id' => ':id']) }}".replace(':id', id) + '?type=' + type;
                        imgElement.src = previewUrl;
                        imgContainer.classList.remove('d-none');
                    } else if (['docx', 'doc', 'xlsx', 'xls', 'pptx', 'ppt'].includes(ext)) {
                        // Microsoft Office Online viewer
                        officeIframe.src = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(url);
                        officeContainer.classList.remove('d-none');
                    } else {
                        downloadBtn.href = url;
                        fallbackContainer.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    console.error('Failed to preview file:', err);
                    downloadBtn.href = '#';
                    fallbackContainer.classList.remove('d-none');
                })
                .finally(() => {
                    spinner.classList.add('d-none');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('previewAttachmentModal');
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    const pdfIframe = document.getElementById('preview-pdf-iframe');
                    const officeIframe = document.getElementById('preview-office-iframe');
                    const imgElement = document.getElementById('preview-image-element');

                    if (pdfIframe && pdfIframe.src && pdfIframe.src.startsWith('blob:')) {
                        URL.revokeObjectURL(pdfIframe.src);
                    }

                    if (pdfIframe) pdfIframe.src = '';
                    if (officeIframe) officeIframe.src = '';
                    if (imgElement) imgElement.src = '';
                });
            }
        });
    </script>

    @livewireScripts

    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />

    @stack('scripts')

</body>

</html>
