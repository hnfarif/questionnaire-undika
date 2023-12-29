@extends('layouts.layout-dashboard')
@push('scripts')
@vite([
'resources/js/questionnaire.js',
'resources/sass/questionnaire.scss'
])
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
    @if (Auth::user()->roles->first()->name === 'KAPRODI') <button type="button" class="btn btn-primary"
      data-bs-toggle="modal" data-bs-target="#modal-add">
      <i class="fa-solid fa-plus"></i> Tambah Kuesioner
    </button>
    @endif
  </div>

  <div class="card mb-4">
    <div class="card-header d-flex">
      <span><i class="fas fa-table me-1"></i>
        Daftar Kuesioner
      </span>
      <div class="ms-auto d-flex">
        <label class="me-3 align-self-center">Semester:</label>
        <select class="form-select" name="semester" id="select-semester">
          <option value="{{$semester->smt_active}}" selected>{{$semester->smt_active}} (Aktif)</option>
          <option value="{{$semester->smt_previous}}">{{$semester->smt_previous}}</option>
        </select>
      </div>
    </div>
    <div class="card-body">
      <div class="container-fluid">
        <div class="table-responsive">
          <table id="table-questionnaire" class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Semester</th>
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
  </div>
</div>

@include('questionnaire.components.index.modal-add')
@include('questionnaire.components.index.modal-update')
@endsection