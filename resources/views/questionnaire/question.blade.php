<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $questionnaire->title }}</title>
  @vite([
  'resources/sass/app.scss',
  'resources/sass/question.scss',
  'resources/js/app.js'
  ])
</head>

<body>
  <section class="container mt-3" style="max-width: 720px">
    <div class="card">
      <div class="card-body">
        <div>
          {{ Auth::user()->student->name }}
        </div>
        <div>
          {{ Auth::user()->student->nim }}
        </div>
      </div>
    </div>
  </section>
  <form class="container-sm p-3" style="max-width: 720px" method="POST"
    action="{{ route('submission.store', ['questionnaireId' => $questionnaire->id]) }}">
    @csrf
    @foreach($questions as $question)
    <div class="question card w-100 mb-3" style="width: 18rem;">
      <div class="card-body">
        <div class="description card-text mb-3">{!! $question->description !!}</div>
        <div class="answer">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question-id-{{ $question->id }}"
              id="radio-{{ $question->id }}-1" value="1">
            <label class="form-check-label" for="radio-{{ $question->id }}-1">
              Sangat tidak setuju
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question-id-{{ $question->id }}"
              id="radio-{{ $question->id }}-2" value="2">
            <label class="form-check-label" for="radio-{{ $question->id }}-2">
              Tidak setuju
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question-id-{{ $question->id }}"
              id="radio-{{ $question->id }}-3" value="3">
            <label class="form-check-label" for="radio-{{ $question->id }}-3">
              Netral
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question-id-{{ $question->id }}"
              id="radio-{{ $question->id }}-4" value="4">
            <label class="form-check-label" for="radio-{{ $question->id }}-4">
              Setuju
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question-id-{{ $question->id }}"
              id="radio-{{ $question->id }}-5" value="5">
            <label class="form-check-label" for="radio-{{ $question->id }}-5">
              Sangat setuju
            </label>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary btn-submit w-100">Submit</button>
  </form>
</body>

</html>