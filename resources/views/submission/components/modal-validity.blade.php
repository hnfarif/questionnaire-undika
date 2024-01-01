<div class="modal fade modal-lg" id="modal-validity" tabindex="-1" aria-labelledby="modal-validity" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal-validity">
          Uji Validitas <span id="title-category"></span>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="select-category-validity">
          <select id="select-category-validity" style="max-width: 160px;" class="form-select form-select-sm mb-3">
            @foreach($categories as $index => $category)
            <option {{ $index===0 ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </label>
        <canvas id="canvas-validity"></canvas>
      </div>
    </div>
  </div>
</div>