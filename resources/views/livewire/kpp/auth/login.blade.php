<div class="inner-content login">

    <div class="container-fluid g-0">

        <div class="row g-0">

            <div class="col">

                <div class="p-5 vh-100">

                    <div class="nav-wrapper p-5">
                        <a href="#" class="nav-back">
                            <img src="{{asset('./images/icons/back.png')}}" alt="back" />
                        </a>
                    </div>

                    <div class="content-login p-5">

                        <div class="row">

                            <div class="col-5">

                                <h1 class="text-white mb-3">Adaro Integrated Management Systems</h1>
                                <p class="text-white fs-5 mb-3">Inspeksi KPLH Systems consists of Main Modules, including:</p>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#" class="d-flex gap-3 align-items-center text-white py-2 fs-5">
                                            <span><img src="{{asset('./images/icons/check-login.png')}}" alt=""></span>
                                            <span>Fixed Asset Master Data</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex gap-3 align-items-center text-white py-2 fs-5">
                                            <span><img src="{{asset('./images/icons/check-login.png')}}" alt=""></span>
                                            <span>Fixed Asset Collection</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex gap-3 align-items-center text-white py-2 fs-5">
                                            <span><img src="{{asset('./images/icons/check-login.png')}}" alt=""></span>
                                            <span>Maintenance Order</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        

                    </div>

                </div>

            </div>

            <div class="col-3">

                <div class="bg-white vh-100 p-5">

                    <div class="login-header d-flex gap-5 justify-content-center align-items-center py-5">
                        <h3 class="fw-bold mb-0">Login</h3>
                        <span><img src="{{asset('./images/logo-login.png')}}" alt=""></span>
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

                            <div class="form-check mb-5">
                                <input class="form-check-input @error('remember') is-invalid @enderror" wire:model='remember' type="checkbox" value="" id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-success bg-green btn-lg">Login</button>
                            </div>

                        </form>

                    </div><!-- /.form-wrapper -->

                </div>

            </div>

        </div><!-- /.row -->

    </div><!-- /.container-fluid -->

</div><!-- /.login -->
