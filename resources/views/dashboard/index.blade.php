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
  <div class="d-flex flex-wrap align-items-center mb-3 gap-2">
    <label>
      <select id="select-questionnaire" class="form-select form-select-sm" data-placeholder="Tambahkan kuesioner"
        style="max-width: 240px">
        <option disabled selected value="0">Pilih kuesioner</option>
        @foreach($questionnaires as $questionnaire)
        <option value="{{ $questionnaire->id }}">{{ $questionnaire->title }}</option>
        @endforeach
      </select>
    </label>
    <label>
      <select id="select-category" class="form-select form-select-sm" data-placeholder="Tambahkan kuesioner"
        style="max-width: 240px">
        <option disabled selected value="0">Pilih kategori</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </label>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title text-center">Jumlah Mahasiswa Sudah Mengisi</div>
              <h5 class="h1 text-center" id="stat-number-of-submissions"> - </h5>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title text-center">Jumlah Mahasiswa</div>
              <h5 class="h1 text-center" id="stat-number-of-students"> - </h5>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title text-center">Semester</div>
              <h5 class="h1 text-center" id="stat-semester"> - </h5>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6" id="mean">
          <h5 class="text-center">Mean</h5>
          <canvas id="canvas-mean"></canvas>
        </div>
        <div class="col-12 col-md-6" id="mode">
          <h5 class="text-center">Mode</h5>
          <canvas id="canvas-mode"></canvas>
        </div>
        <div class="col-12 col-md-6" id="median">
          <h5 class="text-center">Median</h5>
          <canvas id="canvas-median"></canvas>
        </div>
        <div class="col-12 col-md-6" id="variance">
          <h5 class="text-center">Variance</h5>
          <canvas id="canvas-variance"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
