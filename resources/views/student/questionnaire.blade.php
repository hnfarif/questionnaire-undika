@extends('layouts.layout-dashboard')
@section('content')
<div class="container">
  <div class="d-flex align-items-center">
    <div class="flex-grow-1">
      <h1 class="mt-4">
        Kuesioner
      </h1>
    </div>
  </div>
  @php
  $isEmpty=true
  @endphp
  <table id="table-questionnaire" class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Semester</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($questionnaires as $index=> $questionnaire)
      @if(!$questionnaire['hasSubmission'])
      @php
      $isEmpty=false
      @endphp
      <tr class="{{ !$questionnaire['hasSubmission'] ? 'bg-success' : ''}}">
        <td>{{ $index + 1 }}</td>
        <th>{{ $questionnaire->title }}</th>
        <th>{{ $questionnaire->start_date }}</th>
        <th>{{ $questionnaire->end_date }}</th>
        <th>{{ $questionnaire->semester }}</th>
        <th>
          <a class="btn btn-sm btn-primary"
            href="{{route('question.index',['questionnaireId' => $questionnaire->id])}}">
            Jawab
          </a>
        </th>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
  @if($isEmpty)
  <div class="text-center">Tidak ada kuesioner</div>
  @endif
</div>
@endsection