@extends('layouts.app')
@push('scripts')
  @vite([
    'resources/js/submission.js',
    'resources/sass/submission.scss'
  ])
@endpush
@section('content')
  <div class="container-fluid px-4">
    <div class="d-flex align-items-center gap-3">
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
        Uji Validitas
      </button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
        Uji Reliabilitas
      </button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
        Hitung
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Daftar Kuesioner
      </div>
      <div class="card-body">
        <table id="table-submission">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>NIM</th>
              @php
                $categoryCounters = [];
              @endphp

              @foreach($questions as $index => $question)
                @if (!isset($categoryCounters[$question->category->id]))
                  @php
                    $categoryCounters[$question->category->id] = 1;
                  @endphp
                @endif

                <th
                  data-is-question="true"
                  data-index="{{ $index }}"
                  data-category-id="{{ $question->category->id }}"
                  data-question-id="{{ $question->id }}"
                  data-question-category="{{ $question->category->name }}"
                  data-question-description="{{ $question->description }}"
                >
                  <button class="btn btn-light btn-question">
                    X<sub>{{ $question->category->id }}</sub>
                    <sub>{{ $categoryCounters[$question->category->id] }}</sub>
                  </button>
                </th>

                @php
                  $categoryCounters[$question->category->id]++;
                @endphp
              @endforeach
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <@include('submission.components.modal-detail')
@endsection
