<div class="modal fade modal-lg" id="modal-analytics-descriptive" tabindex="-1"
  aria-labelledby="modal-analytics-descriptive" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal-analytics-descriptive">
          Analisis Deskriptif <span id="title-category"></span>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="select-category-analysis-descriptive">
          <select id="select-category-analysis-descriptive" style="max-width: 160px;"
            class="form-select form-select-sm mb-3">
            @foreach($categories as $index => $category)
            <option {{ $index===0 ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </label>
        <canvas id="canvas-analytics-descriptive"></canvas>
      </div>
    </div>
  </div>
</div>