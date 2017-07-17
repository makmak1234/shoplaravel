<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
        <form method="POST" action="/store_color">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="title" value="">
            <button type="send">Готово</button>
        </form>
    </body>
</html>
