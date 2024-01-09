@extends('layouts.layout-dashboard')
@push('scripts')
@vite([
'resources/js/questionnaire-lead.js',
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
  </div>

  <div class="card mb-4">
    <div class="card-header d-flex">
      <span><i class="fas fa-table me-1"></i>
        Pilih Prodi
      </span>
    </div>
    <div class="card-body">
      <div class="container-fluid">
        <div class="table-responsive">
          <table id="table-questionnaire" class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($studyPrograms as $stuPro)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$stuPro->name}}</td>
                <td>
                  <a class="btn btn-primary"
                    href="{{route('questionnaire.index', ['studyProgramId' => $stuPro->id])}}">Lihat</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection