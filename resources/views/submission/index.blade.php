@extends('layouts.layout-dashboard')
@push('scripts')
@vite([
'resources/js/submission.js',
'resources/sass/submission.scss'
])
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
      <select id="select-category" class="ms-3" style="max-width: 120px;">
        @foreach($categories as $index => $category)
        <option {{ $index===0 ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      <div class="table-responsive">
        <table id="table-submission">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>NIM</th>
              @php
              $questionCounters = [];
              @endphp

              @foreach($questions as $index=> $question)
              @if (!isset($questionCounters[$question->category->id]))
              @php
              $questionCounters[$question->category->id] = 1;
              @endphp
              @endif

              <th data-is-question="true" data-index="{{ $index +3 }}" data-category-id="{{ $question->category->id }}"
                data-question-id="{{ $question->id }}" data-question-category="{{ $question->category->name }}"
                data-question-description="{{ $question->description }}">
                <button class="btn btn-light btn-question text-nowrap">
                  X<sub>{{ $question->category->id }}</sub>
                  <sub>{{ $questionCounters[$question->category->id] }}</sub>
                </button>
              </th>

              @php
              $questionCounters[$question->category->id]++;
              $index++;
              @endphp
              @endforeach
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" style="text-align: right">R<sub>x</sub><sub>y</sub></th>
              @foreach($questions as $index=> $question)
              <th>{{ number_format($rxy[$question->id],
                2) }}</th>
              @endforeach
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

@include('submission.components.modal-detail')
@endsection