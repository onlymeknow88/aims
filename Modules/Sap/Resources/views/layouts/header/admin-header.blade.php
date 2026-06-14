<div class="container-fluid fixed-top bg-white shadow-sm">

    <div class="row collapse show d-flex align-items-center justify-content-between h-60px position-relative">
        <!-- Start Toggle -->
        <div class="col-3 d-flex align-items-center gap-2">

            <a @click.prevent="isSidebar = !isSidebar" href="#" role="button" class="p-1 text-white">
                <img src="{{ asset('images/icons/layout-sidebar.svg') }}" alt="open sidebar">
            </a>
            <a href="{{ url('/') }}" class="logo text-decoration-none d-sm-block d-none">AIMS - SAP</a>
        </div>
        <!-- end Toggle -->

        <!-- Start Search -->
        <div class="col">
            <livewire:sap::layouts.search />
        </div>
        <!-- end Search -->

        <!-- start Profile -->
        <div class="col-3 justify-content-end">
            <div class="profile-menu d-flex justify-content-end align-items-center">
                <div class="d-flex align-items-center gap-3 text-decoration-none position-relative">
                    <span class="profile-text d-sm-block d-none">
                        {{ ucfirst(auth()->user()->name) }}
                    </span>
                    <span class="profile-image">
                        <!--<img src="{{ asset('images/profile.png') }}" alt="Profile images" srcset="{{ asset('images/profile.png') }}">-->
                        <span class="text-profile">{{ substr(ucfirst(auth()->user()->name), 0, 1) }}</span>
                    </span>
                </div>
            </div>
        </div>
        <!-- end Profile -->

    </div>
</div><!-- /.container-fluid -->
