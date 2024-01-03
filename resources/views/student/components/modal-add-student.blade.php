<div
  class="modal modal-lg fade"
  id="modal-add"
  tabindex="-1"
  aria-labelledby="modal-add"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="title-modal-add">Add new question</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="input-email" class="form-label">Email</label>
          <input type="email" class="form-control" id="input-email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="input-password" class="form-label">Password</label>
          <input type="email" class="form-control" id="input-password" aria-describedby="passwordHelp">
        </div>
        <div class="mb-3">
          <label for="input-nim" class="form-label">NIM</label>
          <input type="text" class="form-control" id="input-nim" aria-describedby="nimHelp">
        </div>
        <div class="mb-3">
          <label for="input-name" class="form-label">Nama</label>
          <input type="text" class="form-control" id="input-name" aria-describedby="nameHelp">
        </div>
        <div class="mb-3">
          <label for="select-study-program" class="form-label">Program Studi</label>
          <select type="text" class="form-select" id="select-study-program" aria-describedby="studyProgramHelpMePleaseIamDrowning">
            @foreach($studyPrograms as $studyProgram)
              <option value="{{ $studyProgram->id }}">{{ $studyProgram->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button id="btn-save" type="button" class="btn btn-primary">Tambahkan</button>
      </div>
    </div>
  </div>
</div>
