<nav class="navbar  navbar-dark container-fluid fixed-top bg-green m-0" style="height:60px">
    <div class="container-fluid">

        <!-- Start Toggle -->
        <div class=" d-flex align-items-center gap-3">
            <a @click.prevent="isSidebar = ! isSidebar" href="#" role="button" class="p-1 text-white">
                <i class="fa-solid fa-bars"></i>
            </a>
            <a href="{{ url('/') }}" class="logo text-white text-decoration-none d-sm-block d-none">AIMS @hasSection('title')
                    - @yield('title')
                @endif
            </a>
        </div>
        <!-- end Toggle -->
        <div class="d-flex text-danger d-sm-none d-block">
            @include('layouts.main-dashboard.dashboard-header-search')
        </div>

        <div>
            <div class="d-flex">
                <div class="m-1 d-none d-sm-block">
                    @include('layouts.main-dashboard.dashboard-header-search')
                </div>
                @if (Auth::user())
                    <div class="profile-menu d-flex justify-content-end align-items-center">
                        <div class="d-flex align-items-center gap-3 text-decoration-none position-relative">
                            {{-- <span class="profile-text text-white  d-sm-block d-none">{{ Auth::user()->name }}</span> --}}
                            <span class="prifile-image">
                                <img src="{{ asset('images/profile.png') }}" alt="Profile images"
                                    srcset="{{ asset('images/profile.png') }}">
                            </span>
                        </div>
                    </div>
                @else
                    <div class="profile-menu d-flex justify-content-end align-items-center">
                        <a href="{{ route('dashboard-login') }}" class="text-light">Login</a>
                    </div>
                @endif
            </div>



        </div>
    </div>
</nav>
