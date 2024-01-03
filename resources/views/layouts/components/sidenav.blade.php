<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu">
    <div class="nav">
      <div class="sb-sidenav-menu-heading">Core</div>
      <a class="nav-link" href="{{ route('dashboard') }}">
        <div class="sb-nav-link-icon">
          <i class="fas fa-tachometer-alt"></i>
        </div>
        Dashboard
      </a>
      <div class="sb-sidenav-menu-heading">Interface</div>
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
         aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-columns"></i>
        </div>
        Data Master
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="{{ route('questionnaire.index') }}">Kuesioner</a>
          <a class="nav-link" href="{{ route('student.index') }}">Mahasiswa</a>
        </nav>
      </div>
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
         aria-expanded="false" aria-controls="collapsePages">
        <div class="sb-nav-link-icon">
          <i class="fas fa-book-open"></i>
        </div>
        Pages
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
             data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
            Authentication
            <div class="sb-sidenav-collapse-arrow">
              <i class="fas fa-angle-down"></i>
            </div>
          </a>
          <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
               data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="login.html">Login</a>
              <a class="nav-link" href="register.html">Register</a>
              <a class="nav-link" href="password.html">Forgot Password</a>
            </nav>
          </div>
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
             data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
            Error
            <div class="sb-sidenav-collapse-arrow">
              <i class="fas fa-angle-down"></i>
            </div>
          </a>
          <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
               data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="401.html">401 Page</a>
              <a class="nav-link" href="404.html">404 Page</a>
              <a class="nav-link" href="500.html">500 Page</a>
            </nav>
          </div>
        </nav>
      </div>
      <div class="sb-sidenav-menu-heading">Addons</div>
      <a class="nav-link" href="charts.html">
        <div class="sb-nav-link-icon">
          <i class="fas fa-chart-area"></i>
        </div>
        Charts
      </a>
      <a class="nav-link" href="tables.html">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
        Tables
      </a>
    </div>
  </div>
  <div class="sb-sidenav-footer">
    <div class="small">Logged in as:</div>
    {{Auth::user()->roles->first()->name}}
  </div>
</nav>
