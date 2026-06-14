<div class="inner-content login">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col">
                <div class="p-5 vh-100">
                    <div class="content-login p-5">

                        <div class="nav-top">
                            <a href="{{ url('/') }}"><img src="{{ asset('images/icons/back.svg') }}"
                                    alt="Back"></a>
                        </div>
                        <div class="content-center">
                            <h1 class="text-white mb-3">Module</h1>
                            <h3 class="text-white fs-5 mb-3">SAP</h3>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xxl-3">
                <div class="bg-white vh-100 p-5">
                    <div class="login-header d-flex gap-5 justify-content-center align-items-center py-5">
                        <h3 class="fw-bold mb-0">Login</h3>
                        <span><img src="{{ asset('./images/logo-login.png') }}" alt="" height="50px"></span>
                    </div>
                    <div class="form-wrapper">
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
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
                                <input class="form-check-input @error('ingat') is-invalid @enderror" wire:model='ingat'
                                    type="checkbox" value="1" id="ingat">
                                <label class="form-check-label" for="ingat">
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
