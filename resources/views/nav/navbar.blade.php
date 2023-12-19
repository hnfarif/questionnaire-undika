<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
  <li class="nav-item dropdown">
    <a
      class="nav-link dropdown-toggle"
      id="navbarDropdown"
      href="#"
      role="button"
      data-bs-toggle="dropdown"
      aria-expanded="false">
      {{ Auth::user()->employee->name ?? Auth::user()->student->name }}<i class="ms-2 fas fa-user fa-fw"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
      <li>
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </li>
</ul>
