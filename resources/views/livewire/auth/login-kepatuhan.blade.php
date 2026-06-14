<div class="inner-content login vh-100">

    <div class="container-fluid g-0">

        <div class="row g-0 justify-content-center">

            <div class="nav-wrapper p-5">
                <a href="#" class="nav-back">
                    <img src="{{asset('./images/icons/back.png')}}" alt="back" />
                </a>
            </div>
        </div><!--/.row-->

        <div class="row g-0 justify-content-center h-100">

            <div class="col-lg-5 col-md-10 my-auto">

                <div class="bg-white p-5 mx-4 rounded-5">

                    <div class="login-header d-flex flex-column justify-content-center align-items-center mb-3">
                        <p class="mb-0 fs-5">Welcome To</p>
                        <h3 class="fw-bold mb-0 text-center">Kepatuhan Peraturan & Perijinan</h3>
                    </div>

                    <div class="form-wrapper">

                        <form action="#" method="POST" wire:submit.prevent='loginStore'>

                            <div class="mb-3 form-floating">
                                <input type="email" wire:model='email' class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" placeholder="Email">
                                <label for="floatingInput">Email address</label>
                            </div>

                            <div class="input-group mb-3" x-data="{show:true, hide:false}">
                                <div class="form-floating">
                                    <input 
                                        :type="show ? 'password' : 'text'"
                                        wire:model='password' 
                                        class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                        placeholder="Password" 
                                        aria-label="Password" 
                                        aria-describedby="show-password"
                                    />
                                    <label for="floatingInput">Password</label>
                                </div>                                
                                <a type="button" class="input-group-text" id="show-password">
                                    <img @click.prevent="show = false, hide = true" x-show='show' src="{{asset('./images/icons/view.png')}}" alt="show password">
                                    <img x-cloak @click.prevent="show = true, hide = false" x-show='hide' src="{{asset('./images/icons/hide.png')}}" alt="show password">
                                </a>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input @error('ingat') is-invalid @enderror" wire:model='ingat' type="checkbox" value="" id="ingat">
                                <label class="form-check-label" for="ingat">
                                    Ingat Saya
                                </label>
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-success bg-green btn-lg">Login</button>
                            </div>

                            <div class="ket">
                                <p class="text-center mb-0">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                            </div>

                        </form>

                    </div><!-- /.form-wrapper -->

                </div>

            </div>

        </div><!-- /.row -->

    </div><!-- /.container-fluid -->

</div><!-- /.login -->