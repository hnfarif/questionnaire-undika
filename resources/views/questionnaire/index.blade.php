@extends('layouts.app')
@push('scripts')
  @vite(['resources/js/questionnaire.js'])
@endpush
@section('content')
  <div class="container-fluid px-4">
    <div class="d-flex align-items-center">
      <div class="flex-grow-1">
        <h1 class="mt-4">
          Kuesioner
        </h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">
            Kuesioner
          </li>
        </ol>
      </div>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
        Tambah Kuesioner
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Daftar Kuesioner
      </div>
      <div class="card-body">
        <table id="table-questionnaire">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="modal fade modal-lg" id="modal-add" tabindex="-1" aria-labelledby="modal-add" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-add">
            Form Tambah Kuesioner
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="title" id="input-title">
            <label for="input-title">Judul Kuesioner</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control" name="description" id="input-description"></textarea>
            <label for="input-description">Keterangan Kuesioner</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control flatpickr flatpickr-input active" readonly name="startDate"
                   id="input-start-date">
            <label for="input-start-date">Tanggal Mulai</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control flatpickr flatpickr-input active" readonly name="endDate"
                   id="input-end-date">
            <label for="input-end-date">Tanggal Akhir</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button id="btn-add" type="button" class="btn btn-primary">Tambah</button>
        </div>
      </div>
    </div>
  </div>
@endsection
