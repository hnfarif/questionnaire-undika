@extends('layouts.layout-dashboard')
@push('scripts')
  @vite([
  'resources/js/student.js',
  'resources/sass/student.scss'
  ])
@endpush
@section('content')
  <div class="container-fluid px-4">
    <div class="d-flex align-items-center gap-3">
      <div class="flex-grow-1">
        <h1 class="mt-4">
          Mahasiswa
        </h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">
            Mahasiswa
          </li>
        </ol>
      </div>
      <button class="btn btn-primary">Tambah Mahasiswa</button>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Daftar Mahasiswa
      </div>
      <div class="card-body px-2">
        <div class="container-fluid">
          <div class="table-responsive">
            <table id="table-student" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Jenis Kelamin</th>
                  <th>Program Studi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
