<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AIMS @hasSection('title')
            - @yield('title')
        @endif
    </title>
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
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}"> --}}

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Font Library -->
    <!--<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">-->


    <!-- Fontawesome Icons -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    <link id="fontawesome-css" href="{{ asset('assets/libs/fontawesome-6.4.0/css/all.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap Library-->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">-->
    <link id="boostrap-css" href="{{ asset('assets/libs/bootstrap-5.3.0/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">


    <!-- Css File -->
    <link id="animate-css" href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <link id="custom-css" href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />

    <!-- Alpinejs Library -->
    @stack('plugin-alpine')
    <script defer src="{{ asset('assets/libs/alpinejs/dist/cdn.min.js') }}"></script>
    <!--<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>-->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->

    <title>Adaro Admin</title>

    @livewireStyles
    @stack('styles')

</head>

<body x-data>

    {{ $slot }}

    <!-- Javascript Libraries -->
    <script src="{{ asset('assets/libs/popper/dist/umd/popper.min.js') }}"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>-->
    <script src="{{ asset('assets/libs/bootstrap-5.3.0/js/bootstrap.bundle.min.js') }}"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>-->
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>-->
    <script type="text/javasccript" src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />

    <script>
        window.addEventListener('swal', function(e) {
            Swal.fire(e.detail);
        });
    </script>

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

    @livewireScripts
    @stack('scripts')

</body>

</html>
