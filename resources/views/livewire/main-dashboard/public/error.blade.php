<div>
    @section('title')
        Halaman tidak ditemukan
    @endsection

    <div class="inner-dashboard px-3">

        <div class="row">

            <div class="col-lg-9 col-md-12">
                <div class="show">
                    <div class="flex-center">
                        <p class="fas fa-unlink fa-5x text-danger text-center"></p>
                        <p>
                        <h1 class="text-secondary text-center">Halaman tidak ditemukan</h1>
                        </p>
                    </div>

                </div>
            </div><!-- /.col main content -->

            <div class="col-lg-3 col-md-12 sidebar-right">
                @livewire('main-dashboard.public.sidebar.sidebar-right')
            </div><!-- /.col sidebar -->
        </div><!-- /.row -->

    </div><!-- /.inner-dashboard -->

    @once
        @push('styles')
            <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
            <style>
                .inner-dashboard {
                    height: 700px
                }

                .flex-center {
                    height: 500px;
                    background: transparent;
                    color: black;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    resize: vertical;
                }

                .flex-center p {
                    margin: 0;
                    padding: 20px;
                    text-align: center;
                    width: 90%;
                }
            </style>
        @endpush
    @endonce
