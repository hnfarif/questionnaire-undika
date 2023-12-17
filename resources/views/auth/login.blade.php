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
  @vite([
    'resources/sass/app.scss',
    'resources/sass/login.scss',
    'resources/js/app.js',
    'resources/js/login.js'
    ])
</head>

<body>
  <div id="layout-authentication">
    <div id="layout-authentication-content">
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
                          id="input-username"
                          type="text"
                          placeholder="NIM / NIK"
                          name="id"
                          value="{{old('id')}}"
                        />
                        <label for="input-username">NIM / NIK</label>
                      </div>
                      @error('id')
                      <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <div class="form-floating position-relative">
                        <input
                          class="form-control @error('password') is-invalid @enderror"
                          id="input-password"
                          type="password"
                          placeholder="Enter your password"
                          name="password"
                        />
                        <label for="input-password">Password</label>
                        <button
                          id="btn-password-visibility"
                          type="button"
                          class="button-show-hide">
                          <i class="fa-solid fa-eye-slash"></i>
                        </button>
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
</body>
</html>
