{{-- <div class="inner-content login vh-100">

    <div class="container-fluid g-0">

        <div class="row g-0 justify-content-center">

            <div class="nav-wrapper p-5">

            </div>
        </div><!--/.row-->

        <div class="row g-0 justify-content-center h-100">

            <div class="col-lg-5 col-md-10 my-auto">

                <div class="bg-white p-5 mx-4 rounded-5">

                    <div class="login-header d-flex flex-column justify-content-center align-items-center mb-3">
                        <p class="mb-0 fs-5">Welcome To</p>
                        <h3 class="fw-bold mb-0 text-center">Document System</h3>
                    </div>

                    <div class="form-wrapper">

                        <form action="#" method="POST" wire:submit.prevent='login'>

                            <div class="mb-3 form-floating">
                                <input type="email" wire:model='email'
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email">
                                <label for="floatingInput">Email address</label>
                            </div>

                            <div class="input-group mb-3" x-data="{ show: true, hide: false }">
                                <div class="form-floating">
                                    <input :type="show ? 'password' : 'text'" wire:model='password'
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Password" aria-label="Password" aria-describedby="show-password" />
                                    <label for="floatingInput">Password</label>
                                </div>
                                <a type="button" class="input-group-text" id="show-password">
                                    <img @click.prevent="show = false, hide = true" x-show='show'
                                        src="{{ asset('./images/icons/view.png') }}" alt="show password">
                                    <img x-cloak @click.prevent="show = true, hide = false" x-show='hide'
                                        src="{{ asset('./images/icons/hide.png') }}" alt="show password">
                                </a>
                            </div>

                            <!-- <div class="form-check mb-3">
                                <input class="form-check-input @error('ingat') is-invalid @enderror" wire:model='ingat' type="checkbox" value="" id="ingat">
                                <label class="form-check-label" for="ingat">
                                    Ingat Saya
                                </label>
                            </div> -->

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-success bg-green btn-lg">Login</button>
                            </div>

                            <div class="ket">
                                <p class="text-center mb-0"></p>
                            </div>

                        </form>

                    </div><!-- /.form-wrapper -->

                </div>

            </div>

        </div><!-- /.row -->

    </div><!-- /.container-fluid -->

</div><!-- /.login --> --}}

<div class="inner-content login">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col">
                <div class="p-5 vh-100">
                    <div class="content-login p-5">

                        <div class="nav-top">
                            <a href="/"><img src="{{ asset('images/icons/back.svg') }}" alt="Back"></a>
                        </div>
                        <div class="content-center">
                            <h1 class="text-white mb-3">Module</h1>
                            <h3 class="text-white fs-5 mb-3">Document System</h3>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xxl-3">
                <div class="bg-white vh-100 p-5">
                    <div class="login-header d-flex gap-5 justify-content-center align-items-center py-5">
                        <h3 class="fw-bold mb-0">Login</h3>
                        <span class="text-end">
                            <img src="{{ asset('images/logo-login.png') }}" alt="" width="50%">
                        </span>
                    </div>
                    <div class="form-wrapper">
                        <form method="POST" wire:submit.prevent="login">
                            <div class="mb-3 form-floating">
                                <input type="email" wire:model='email'
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email">
                                <label for="email">Email address</label>
                            </div>
                            <div class="input-group mb-3" x-data="{ show: true, hide: false }">
                                <div class="form-floating">
                                    <input :type="show ? 'password' : 'text'" wire:model='password'
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Password" aria-label="Password" id="password"
                                        aria-describedby="show-password" />
                                    <label for="password">Password</label>
                                </div>

                                <a type="button" class="input-group-text" id="show-password">
                                    <img @click.prevent="show = false, hide = true" x-show='show'
                                        src="{{ asset('./images/icons/view.png') }}" alt="show password">
                                    <img x-cloak @click.prevent="show = true, hide = false" x-show='hide'
                                        src="{{ asset('./images/icons/hide.png') }}" alt="show password">
                                </a>

                            </div>
                            <div class="form-check mb-5">
                                <input class="form-check-input @error('remember') is-invalid @enderror"
                                    wire:model='remember' type="checkbox" value="1" id="remember">
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
