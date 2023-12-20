@extends('layouts.layout-dashboard')
@push('scripts')
  @vite([
    'resources/js/dashboard.js'
  ])
@endpush
@section('content')
  <div class="container">
    <canvas id="chartJSContainer" width="600" height="400"></canvas>
  </div>
@endsection
