<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Font Library -->
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

        <!-- Fontawesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">

    <!-- Css File -->
    <link id="custom-css" href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <link id="custom-css" href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />

        @yield('include_css')
        @livewireStyles

        <style>
            .btn-basic-green {
                background: #00552F !important;
            }
            table tbody tr.selected{
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
    <body x-data>

        {{ $slot }}

        <!-- Javascript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
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

            window.addEventListener('swal',function(e) {
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

        @livewireScripts

        <script>
            document.addEventListener('alpine:init', () => {

                Alpine.store('isSidebar', {
                    open: true,

                    toggle() {
                        this.open = ! this.open
                    },

                    setSidebar(state){
                      this.open = state
                    }
                })
            })
          </script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
        <x-livewire-alert::scripts />
        <x-livewire-alert::flash />

        @stack('scripts')



    </body>
</html>
