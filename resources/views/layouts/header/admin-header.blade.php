<div class="container-fluid fixed-top bg-white shadow-sm">

    <div class="row collapse show d-flex align-items-center justify-content-between h-60px position-relative">

        <!-- Start Toggle -->
        <div class="col-3 d-flex align-items-center gap-2">
            <a @click.prevent="$store.isSidebar.toggle()" href="#" role="button" class="text-white toggle-sidebar">
                <img src="{{asset('images/icons/layout-sidebar.svg')}}" alt="open sidebar">
            </a>
            <a href="{{ url('/') }}" class="logo text-white text-decoration-none">AIMS @hasSection('title')
                    - @yield('title')
                @endif
            </a>
        </div>
        <!-- end Toggle -->

        <!-- Start Search -->
        <div class="col">
            @livewire('header.header-search')
        </div>
        <!-- end Search -->

        <!-- start Profile -->
        <div class="col-3 justify-content-end">
            @if (Auth::user())
                <div class="profile-menu d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center gap-3 text-decoration-none position-relative">
                        <span class="profile-text text-white">{{ Auth::user()->name }}</span>
                        <span class="prifile-image">
                            <img src="{{ asset('images/profile.png') }}" alt="Profile images"
                                srcset="{{ asset('images/profile.png') }}">
                        </span>
                    </div>
                </div>
            @else
            <div class="profile-menu d-flex justify-content-end align-items-center">
                <div class="d-flex align-items-center gap-3 text-decoration-none position-relative">
                  <span class="profile-text">Hendra Hermawan</span>
                  <span class="profile-image">
                    <!--<img src="{{asset('images/profile.png')}}" alt="Profile images" srcset="{{asset('images/profile.png')}}">-->
                    <span class="text-profile">HH</span>
                  </span>
                </div>
            </div>
            @endif
        </div>
        <!-- end Profile -->

    </div>
</div><!-- /.container-fluid -->
