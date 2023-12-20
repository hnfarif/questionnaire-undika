@extends('layouts.layout-dashboard')
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
                <i class="fa-solid fa-plus"></i> Tambah Kuesioner
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

    @include('questionnaire.components.index.modal-add')
    @include('questionnaire.components.index.modal-update')
@endsection
