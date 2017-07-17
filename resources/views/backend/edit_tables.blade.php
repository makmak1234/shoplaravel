<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
      {{-- {{$curclrs}} --}}
        <form method="POST" action="/store_edit_tables">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="title" value="{{ $good->title }}">
            <select type="text" class="form-control" name="descriptions" value="" required
            >
              @foreach ($descrs as $descr)
                <?php $selected = '' ?>
                @if ($good->descriptions_id == $descr->id)
                  <?php $selected = 'selected' ?>
                @endif
                <option value="{{ $descr->id }}" {{ $selected }}>{{ $descr->title }}</option>
              @endforeach
            </select>
            <p>
              @foreach ($sizes as $size)
                <?php $checked= '' ?>
                <?php 
                  if (in_array($size->id, $curszs)){
                    $checked = 'checked';
                  }
                ?>
                <input type="checkbox" name="size[]" value="{{ $size->id }}" {{ $checked }}>{{ $size->title }}
                  @foreach ($colors as $color)
                    <?php $checked = '' ?>
                    @if (isset($curclrs[$size->id]))
                      @if (in_array($color->id, $curclrs[$size->id]))
                        <?php $checked = 'checked' ?>
                      @endif
                    @endif
                    {{$color->id}}<input type="checkbox" name="color[{{ $size->id }}][]" value="{{ $color->id }}" {{ $checked }}>{{ $color->title }} 
                    {{-- <Br> --}}
                  @endforeach
                <Br>
              @endforeach
            </p>

            <p>
              @foreach ($good->size as $s)
                <ii style="color: red">{{ $s->title }}</ii>
                {{-- {{ $s->pivot->id}} --}}
                <?php $goodsSizes = App\GoodsSizes::where('id', $s->pivot->id)->get(); ?>
                @foreach ($goodsSizes as $goodSize)
                  @foreach ($goodSize->color as $col)
                    <i style="color: green">{{ $col->title }}</i>
                  @endforeach                                           
                @endforeach
                <br>
              @endforeach
            </p>

            <input type="hidden" name="id" value="{{ $good->id }}">
            <button type="send">Готово</button>
        </form>
    </body>
</html>