<div class="container-fluid fixed-top bg-green">

    <div class="row collapse show d-flex align-items-center justify-content-between h-60px position-relative">

        <!-- Start Toggle -->
        <div class="col-3 d-flex align-items-center gap-3">
            <img src="{{asset('./images/logo.png')}}" alt="logo" />
        </div>
        <!-- end Toggle -->

        <!-- Start Search -->
        <div class="col">
        </div>
        <!-- end Search -->

        <!-- start Profile -->
        <div class="col-3 justify-content-end">
            <div class="profile-menu dropdown d-flex justify-content-end align-items-center">
                <a class="link dropdown-toggle d-flex align-items-center gap-3 text-decoration-none position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="profile-text text-white">Hendra Hermawan</span>
                  <span class="prifile-image">
                    <img src="{{asset('images/profile.png')}}" alt="Profile images" srcset="{{asset('images/profile.png')}}">
                  </span>
                </a>

                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
        <!-- end Profile -->

    </div>
</div><!-- /.container-fluid -->
