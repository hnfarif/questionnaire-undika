<div class="modal fade modal-lg" id="modal-add" tabindex="-1" aria-labelledby="modal-add" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal-add">
          Form Tambah Kuesioner
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="title" id="input-title">
          <label for="input-title">Judul Kuesioner</label>
        </div>
        <div class="form-floating mb-3">
          <textarea class="form-control" name="description" id="input-description"></textarea>
          <label for="input-description">Keterangan Kuesioner</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control flatpickr flatpickr-input active" readonly name="startDate"
            id="input-start-date">
          <label for="input-start-date">Tanggal Mulai</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control flatpickr flatpickr-input active" readonly name="endDate"
            id="input-end-date">
          <label for="input-end-date">Tanggal Akhir</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button id="btn-add" type="button" class="btn btn-primary">Tambah</button>
      </div>
    </div>
  </div>
</div>