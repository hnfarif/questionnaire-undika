<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu">
    <div class="nav py-3">
      @if(Auth::user()->roles->first()->name === 'MAHASISWA')
      <a class="nav-link" href="{{ route('student.questionnaire') }}">
        <div class="sb-nav-link-icon">
          <i class="fas fa-chart-area"></i>
        </div>
        Kuesioner
      </a>
      @else
      <a class="nav-link" href="{{ route('dashboard') }}">
        <div class="sb-nav-link-icon">
          <i class="fas fa-tachometer-alt"></i>
        </div>
        Dashboard
      </a>
      <div class="sb-sidenav-menu-heading">Data Master</div>
      <a class="nav-link"
        href="{{ auth()->user()->roles->first()->name == 'KAPRODI' ? route('questionnaire.index') : route('questionnaire.pimpinan') }}">
        <div class="sb-nav-link-icon">
          <i class="fas fa-chart-area"></i>
        </div>
        Kuesioner
      </a>
      @endif
    </div>
  </div>
  <div class="sb-sidenav-footer">
    <div class="small">Logged in as:</div>
    {{Auth::user()->roles->first()->name}}
  </div>
</nav>