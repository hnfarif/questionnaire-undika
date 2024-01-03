@extends('layouts.layout-dashboard')
@push('scripts')
  <script>
    window.categories = @json($categories);
    window.questionnaires = @json($questionnaires);
  </script>
  @vite([
    'resources/sass/dashboard.scss',
    'resources/js/dashboard.js'
  ])
@endpush
@section('content')
  <div class="container px-4">
    <div class="d-flex align-items-center">
      <div class="flex-grow-1">
        <h1 class="mt-4">
          Dashboard
        </h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">
            Home
          </li>
        </ol>
      </div>
    </div>
    <div class="row g-3 mb-3">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title text-center">Jumlah Mahasiswa Sudah Mengisi</div>
            <h5 class="h1 text-center">{{ $numberOfSubmissions }}</h5>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title text-center">Jumlah Mahasiswa</div>
            <h5 class="h1 text-center">{{ $numberOfSubmissions }}</h5>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title text-center">Periode Saat Ini</div>
            <h5 class="h1 text-center">-</h5>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title text-center">Status Kuisioner</div>
            <h5 class="h1 text-center">Aktif</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-wrap align-items-center mb-3 gap-2">
          <label>
            <select
              id="select-questionnaires"
              class="form-select form-select-sm"
              data-placeholder="Tambahkan kuesioner">
              <option disabled value="0">Tambahkan kuesioner</option>
              @foreach($questionnaires as $questionnaire)
                <option value="{{ $questionnaire->id }}">{{ $questionnaire->title }}</option>
              @endforeach
            </select>
          </label>
          <div id="selected-questionnaires-container" class="d-flex gap-2"></div>
        </div>
        <canvas id="canvas-questionnaire-r"></canvas>
      </div>
    </div>
  </div>
@endsection
