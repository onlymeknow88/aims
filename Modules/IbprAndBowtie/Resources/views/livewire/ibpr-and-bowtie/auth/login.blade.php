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
                            <h3 class="text-white fs-5 mb-3">Ibpr And Bowtie</h3>
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
                        <form method="POST" wire:submit.prevent="loginStore">
                            <div class="mb-3 form-floating">
                                <input type="email" wire:model='email'
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email">
                                <label for="email">Email address</label>
                            </div>
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input type="{{ $show_password ? 'text' : 'password' }}" wire:model='password'
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Password" aria-label="Password" id="password"
                                        aria-describedby="show-password" />
                                    <label for="password">Password</label>
                                </div>

                                @if ($show_password)
                                    <a type="button" class="input-group-text" id="show-password"
                                        wire:click="toggleShowPassword(false)">
                                        <img src="{{ asset('./images/icons/hide.png') }}" alt="show password">
                                    </a>
                                @else
                                    <a type="button" class="input-group-text" id="show-password"
                                        wire:click="toggleShowPassword(true)">
                                        <img src="{{ asset('./images/icons/view.png') }}" alt="show password">
                                    </a>
                                @endif

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
