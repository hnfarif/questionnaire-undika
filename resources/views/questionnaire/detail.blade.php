@extends('layouts.layout-dashboard')
@push('scripts')
<script>
  const questionnaire = eval({!! json_encode($questionnaire) !!})
</script>
@vite([
'resources/sass/detail-questionnaire.scss',
'resources/js/detail-questionnaire.js'
])
@endpush
@section('content')
<div class="container-fluid px-4" id="body-section" data-role="{{Auth::user()->roles->first()->name}}">
  <div class="d-flex align-items-center">
    <div class="flex-grow-1">
      <h1 class="mt-4">
        {{ $questionnaire->title }}
      </h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
          <a href="{{ route('questionnaire.index') }}">Kuesioner</a>
        </li>
        <li class="breadcrumb-item active">
          Detail
        </li>
      </ol>
      <div class="card mb-4">
        <div class="card-header">
          Deskripsi
        </div>
        <div class="card-body">
          {{ $questionnaire->description }}
        </div>
      </div>
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-header d-flex">
      <div class="my-auto">
        <i class="fas fa-table me-1"></i>
        Daftar Pertanyaan
      </div>
      <div class="d-flex gap-3 ms-auto">
        @if($questionnaire->status == 'DRAFT' && Auth::user()->roles->first()->name === 'KAPRODI')
        <form method="POST" action="{{ route('questionnaire.submit', [$questionnaire->id]) }}">
          @csrf
          {{ method_field('PATCH') }}
          <button class="btn btn-success">Submit</button>
        </form>
        @elseif($questionnaire->status == 'SUBMITTED' && Auth::user()->roles->first()->name === 'KAPRODI')
        <button class="btn btn-success" disabled>Submitted</button>
        @endif
        @if($questionnaire->status == 'SUBMITTED' && Auth::user()->roles->first()->name === 'DEKAN')
        <form method="POST" action="{{ route('questionnaire.reject', [$questionnaire->id]) }}">
          @csrf
          {{ method_field('PATCH') }}
          <button class="btn btn-danger">Reject</button>
        </form>
        <form method="POST" action="{{ route('questionnaire.approve', [$questionnaire->id]) }}">
          @csrf
          {{ method_field('PATCH') }}
          <button class="btn btn-warning">Approve</button>
        </form>
        @elseif($questionnaire->status == 'DRAFT' && Auth::user()->roles->first()->name === 'DEKAN')
        <div>
          <span class="badge bg-info">DRAFT</span>
        </div>
        @endif
        @if($questionnaire->status == 'APPROVED')
        <span class="badge bg-success my-auto">APPROVED</span>
        @endif
      </div>
    </div>
    <div class="card-body">
      <div class="accordion" id="accordionPanelsStayOpenExample">
        @foreach($categories as $category)
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-{{ $category->id }}" aria-expanded="true"
              aria-controls="accordion-{{ $category->id }}">
              {{ $category->name }}
            </button>
          </h2>
          <div id="accordion-{{ $category->id }}" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="question-item form-group question-group mb-3">
              </div>
              @if(Auth::user()->roles->first()->name === "KAPRODI" && $questionnaire->status != 'APPROVED')
              <button data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}" type="button"
                class="btn btn-primary btn-sm btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Pertanyaan
              </button>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@include('questionnaire.components.detail.modal-add')
@include('questionnaire.components.detail.modal-update')
@endsection