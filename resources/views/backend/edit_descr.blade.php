<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
        <form method="POST" action="/store_edit_descr">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="title" value="{{ $descr->title }}">
            <input type="hidden" name="id" value="{{ $descr->id }}">
            <button type="send">Готово</button>
        </form>
    </body>
</html>