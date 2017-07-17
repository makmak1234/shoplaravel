<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>

        <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="thumbnail">
                      <img src="{{ asset('storage/' . $pict->path) }}" alt="...">
                      <div class="caption">
                          <p>{{ $pict->title }}</p>
                          <p>
                            {{-- <a href="edit_color/{{ $pict->id }}" class="btn btn-primary" role="button">Редактировать</a>  --}}

                             <form method="POST" action="/store_edit_pict" ENCTYPE="multipart/form-data">
                              {{ csrf_field() }}
                              <input type="file" class="form-control" name="pict" value="">
                              <input type="hidden" name="id" value="{{ $pict->id }}">
                              <button type="send">Готово</button>
                            </form>
                             
                          </p>
                      </div>
                  </div>
              </div>
      </div>
    </body>
</html>