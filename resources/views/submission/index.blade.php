@extends('layouts.layout-dashboard')
@push('scripts')
<script>
  window.categories = @json($categories);
    window.questions = @json($questions);
    window.rxy = @json($rxy);
    window.r = @json($r);
</script>
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
        {{ $questionnaire->title }}
      </h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
          <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
          Submission
        </li>
      </ol>
    </div>
    <button id="btn-analytics-descriptive" type="button" class="btn btn-primary">
      Analisis Deskriptif
    </button>
    <button id="btn-validity" type="button" class="btn btn-primary">
      Uji Validitas
    </button>
    <button id="btn-reliability" type="button" class="btn btn-primary">
      Uji Reliabilitas
    </button>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Daftar Kuesioner
    </div>
    <div class="card-body px-2">
      <label for="select-category">
        <select id="select-category" style="max-width: 160px;" class="form-select form-select-sm mb-3">
          @foreach($categories as $index => $category)
          <option {{ $index===0 ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </label>
      <div class="container-fluid">
        <div class="table-responsive">
          <table id="table-submission" class="table">
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

                <th data-is-question="true" data-index="{{ $index +3 }}"
                  data-category-id="{{ $question->category->id }}" data-question-id="{{ $question->id }}"
                  data-question-category="{{ $question->category->name }}"
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
              @php
              $shouldRVisible = [];
              @endphp
              <tr>
                <th colspan="3" style="text-align: right">Hasil Validitas</th>
                @foreach($questions as $index => $question)
                <th>
                  <span data-r-value={{ $rValue }} data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="{{ $rxy[$question->id] > $rValue ? 'Valid' : 'Tidak Valid'}}">
                    {{ number_format($rxy[$question->id], 3) }}
                  </span>
                </th>
                @endforeach
              </tr>
              <tr>
                <th colspan="3" style="text-align: right">Hasil Reliabilitas</th>
                @foreach($questions as $question)
                <th>
                  @if(!isset($shouldRVisible[$question->category_id]))
                  <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="{{ $r[$question->category_id] > 0.60 ? 'Reliable' : 'Tidak Reliable'}}">
                    {{ number_format($r[$question->category_id], 3) }}
                  </span>
                  @endif
                </th>
                @php
                $shouldRVisible[$question->category_id] = true;
                @endphp
                @endforeach
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@include('submission.components.modal-detail')
@include('submission.components.modal-analytics-descriptive')
@include('submission.components.modal-validity')
@include('submission.components.modal-reliability')
@endsection
