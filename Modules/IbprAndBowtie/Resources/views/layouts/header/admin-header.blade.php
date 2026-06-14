<div class="container-fluid fixed-top bg-green">

    <div class="row collapse show d-flex align-items-center justify-content-between h-60px position-relative">

        <!-- Start Toggle -->
        <div class="col-3 d-flex align-items-center gap-3">
            <a @click.prevent="isSidebar = !isSidebar" href="#" role="button" class="p-1 text-white">
                <i class="fa-solid fa-bars"></i>
            </a>
            <span class="logo text-white">AIMS - Field Leadership</span>
        </div>
        <!-- end Toggle -->

        <!-- Start Search -->
        <div class="col">
            @livewire('header.header-search')
        </div>
        <!-- end Search -->

        <!-- start Profile -->
        <div class="col-3 justify-content-end">
            <div class="profile-menu d-flex justify-content-end align-items-center">
                <div class="d-flex align-items-center gap-3 text-decoration-none position-relative">
                    <span class="profile-text text-white">{{ ucfirst(auth()->user()->name) }}</span>
                    <span class="prifile-image">
                        <img src="{{ asset('images/profile.png') }}" alt="Profile images"
                            srcset="{{ asset('images/profile.png') }}">
                    </span>
                </div>
            </div>
        </div>

        <!-- end Profile -->

    </div>
</div><!-- /.container-fluid -->
