@extends('layouts.app')
@push('scripts')
  @vite(['resources/js/detail-questionnaire.js'])
@endpush
@section('content')
  <div class="container-fluid px-4">
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
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-header d-flex">
        <div class="my-auto">
          <i class="fas fa-table me-1"></i>
          Daftar Pertanyaan
        </div>
        <button class="btn btn-success ms-auto">Simpan Pertanyaan</button>
      </div>
      <div class="card-body">
        <div class="accordion" id="accordionPanelsStayOpenExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                      data-bs-target="#accordion-tangible" aria-expanded="true" aria-controls="accordion-tangible">
                Tangible
              </button>
            </h2>
            <div id="accordion-tangible" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <div class="tangible-question">
                  <div class="form-group question-group mb-3">

                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="tangibleQuestion1"
                          name="tangibleQuestion1" />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="tangibleQuestion1">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group question-group mb-3">

                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="tangibleQuestion2"
                          name="tangibleQuestion2" />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="tangibleQuestion2">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-target="tangible">
                  Tambah Pertanyaan
                </button>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                      data-bs-target="#accordion-reliability" aria-expanded="true"
                      aria-controls="accordion-reliability">
                Reliability
              </button>
            </h2>
            <div id="accordion-reliability" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <div class="reliability-question">
                  <div class="form-group question-group mb-3">
                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="reliabilityQuestion1"
                          name="reliabilityQuestion1"
                        />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="reliabilityQuestion1">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group question-group mb-3">

                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="reliabilityQuestion2"
                          name="reliabilityQuestion2" />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="reliabilityQuestion2">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-target="reliability">
                  Tambah Pertanyaan
                </button>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                      data-bs-target="#accordion-responsiveness" aria-expanded="true"
                      aria-controls="accordion-responsiveness">
                Responsiveness
              </button>
            </h2>
            <div id="accordion-responsiveness" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <div class="responsiveness-question">
                  <div class="form-group question-group mb-3">

                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="responsivenessQuestion1"
                          name="responsivenessQuestion1" />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="responsivenessQuestion1">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group question-group mb-3">

                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="responsivenessQuestion2"
                          name="responsivenessQuestion2"
                        />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="responsivenessQuestion2">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-target="responsiveness">
                  Tambah Pertanyaan
                </button>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                      data-bs-target="#accordion-empathy"
                      aria-expanded="true" aria-controls="accordion-empathy">
                Empathy
              </button>
            </h2>
            <div id="accordion-empathy" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <div class="empathy-question">
                  <div class="form-group question-group mb-3">
                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="empathyQuestion1"
                          name="empathyQuestion1" />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="empathyQuestion1">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group question-group mb-3">
                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="empathyQuestion2"
                          name="empathyQuestion2"
                        />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="empathyQuestion2">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-target="empathy">
                  Tambah Pertanyaan
                </button>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordion-assurance"
                aria-expanded="true"
                aria-controls="accordion-assurance">
                Assurance
              </button>
            </h2>
            <div id="accordion-assurance" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <div class="assurance-question">
                  <div class="form-group question-group mb-3">
                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="assuranceQuestion1"
                          name="assuranceQuestion1"
                        />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="assuranceQuestion1">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group question-group mb-3">
                    <div class="input-group gap-3">
                      <label class="flex-grow-1">
                        <input
                          type="text"
                          class="form-control"
                          value="Apakah kamu hooman?"
                          id="assuranceQuestion2"
                          name="assuranceQuestion2" />
                      </label>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-delete" data-target="assuranceQuestion2">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-target="assurance">
                  Tambah Pertanyaan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
