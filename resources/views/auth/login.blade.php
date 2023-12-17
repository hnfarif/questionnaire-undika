<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <title>Login</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net"/>

  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"/>

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

  <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
</head>

<body>
  <div id="layout_authentication">
    <div id="layout_authentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                      <div class="form-floating">
                        <input
                          class="form-control @error('id') is-invalid @enderror"
                          id="id"
                          type="text"
                          placeholder="NIM / NIK"
                          name="id"
                          value="{{old('id')}}"
                        />
                        <label for="id">NIM / NIK</label>
                      </div>
                      @error('id')
                      <span class="invalid-feedback d-block" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <div class="form-floating">
                        <input
                          class="form-control @error('password') is-invalid @enderror"
                          id="password"
                          type="password"
                          placeholder="Enter your password"
                          name="password"
                        />
                        <label for="password">Password</label>
                      </div>
                      @error('password')
                      <span class="invalid-feedback d-block" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                      @enderror
                    </div>
                    <div class="form-check mb-3">
                      <input
                        class="form-check-input"
                        id="rememberMe"
                        type="checkbox"
                        value=""
                      />
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="py-4 bg-light mt-auto">
        <div class="container px-4">
          <div
            class="d-flex align-items-center justify-content-between small"
          >
            <div class="text-muted">Copyright &copy; Undika 2023</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  {{--    <div class="container mt-3">--}}
  {{--        <div class="row justify-content-center">--}}
  {{--            <div class="col-md-8">--}}
  {{--                <div class="card">--}}
  {{--                    <div class="card-header">{{ __('Login') }}</div>--}}

  {{--                    <div class="card-body">--}}
  {{--                        <form method="POST" action="{{ route('login') }}">--}}
  {{--                            @csrf--}}

  {{--                            <div class="row mb-3">--}}
  {{--                                <label for="id"--}}
  {{--                                    class="col-md-4 col-form-label text-md-end">{{ __('NIK / NIM') }}</label>--}}

  {{--                                <div class="col-md-6">--}}
  {{--                                    <input id="id" type="text"--}}
  {{--                                        class="form-control @error('id') is-invalid @enderror" name="id"--}}
  {{--                                        value="{{ old('id') }}" required autofocus>--}}

  {{--                                    @error('id')--}}
  {{--                                        <span class="invalid-feedback" role="alert">--}}
  {{--                                            <strong>{{ $message }}</strong>--}}
  {{--                                        </span>--}}
  {{--                                    @enderror--}}
  {{--                                </div>--}}
  {{--                            </div>--}}

  {{--                            <div class="row mb-3">--}}
  {{--                                <label for="password"--}}
  {{--                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

  {{--                                <div class="col-md-6">--}}
  {{--                                    <input id="password" type="password"--}}
  {{--                                        class="form-control @error('password') is-invalid @enderror" name="password"--}}
  {{--                                        required autocomplete="current-password">--}}

  {{--                                    @error('password')--}}
  {{--                                        <span class="invalid-feedback" role="alert">--}}
  {{--                                            <strong>{{ $message }}</strong>--}}
  {{--                                        </span>--}}
  {{--                                    @enderror--}}
  {{--                                </div>--}}
  {{--                            </div>--}}

  {{--                            <div class="row mb-3">--}}
  {{--                                <div class="col-md-6 offset-md-4">--}}
  {{--                                    <div class="form-check">--}}
  {{--                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"--}}
  {{--                                            {{ old('remember') ? 'checked' : '' }}>--}}

  {{--                                        <label class="form-check-label" for="remember">--}}
  {{--                                            {{ __('Remember Me') }}--}}
  {{--                                        </label>--}}
  {{--                                    </div>--}}
  {{--                                </div>--}}
  {{--                            </div>--}}

  {{--                            <div class="row mb-0">--}}
  {{--                                <div class="col-md-8 offset-md-4">--}}
  {{--                                    <button type="submit" class="btn btn-primary">--}}
  {{--                                        {{ __('Login') }}--}}
  {{--                                    </button>--}}

  {{--                                    @if (Route::has('password.request'))--}}
  {{--                                        <a class="btn btn-link" href="{{ route('password.request') }}">--}}
  {{--                                            {{ __('Forgot Your Password?') }}--}}
  {{--                                        </a>--}}
  {{--                                    @endif--}}
  {{--                                </div>--}}
  {{--                            </div>--}}
  {{--                        </form>--}}
  {{--                    </div>--}}
  {{--                </div>--}}
  {{--            </div>--}}
  {{--        </div>--}}
  {{--    </div>--}}
</body>
</html>
