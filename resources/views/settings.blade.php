<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <title>project</title>
 </head>
<body>
@include('layouts.nav')
<div>
    <h1 align="center" style="margin-top: 8px"> Statistic Options </h1>
    <form method="post" action="/settings">
        {{ csrf_field() }}
        <div class="container" style="margin-top: 20px">
            <div class="form-group">
                <label for="UserName" class="col-sm-2 control-label"> Name </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Name" id="UserName" name="name" value="{{ $fetchTableData['data']['name'] }}">
                </div>
            </div>
            <div class="container">
                <div class="form-group">
                    <div class="panel-heading" style="margin-top: 10px">
                        <a> Open </a>
                    </div>
                    <select class="custom-select" multiple="multiple" name="open[]" id="open">
                        @foreach($names as $name)
                        @if (in_array($name->nameIntern, $fetchTableData['data']['open']))
                        <option value="{{ $name->nameIntern }}" selected>{{$name->name}}</option>
                        @else
                        <option value="{{$name->nameIntern}}">{{$name->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="panel-heading" style="margin-top: 10px">
                        <a> Doing </a>
                    </div>
                    <select class="custom-select" multiple="multiple" name="doing[]" id="doing">
                        @foreach($names as $name)
                        @if (in_array($name->nameIntern, $fetchTableData['data']['doing']))
                        <option value="{{ $name->nameIntern }}" selected>{{$name->name}}</option>
                        @else
                        <option value="{{$name->nameIntern}}">{{$name->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="panel-heading" style="margin-top: 10px">
                        <a> Done </a>
                    </div>
                    <select class="custom-select" multiple="multiple" name="done[]" id="done">
                        @foreach($names as $name)
                        @if (in_array($name->nameIntern, $fetchTableData['data']['done']))
                        <option value="{{ $name->nameIntern }}" selected>{{$name->name}}</option>
                        @else
                        <option value="{{$name->nameIntern}}">{{$name->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="panel-heading" style="margin-top: 10px">
                        <a> Zeitraum </a>
                    </div>
                    <select class="custom-select" multiple="multiple" name="time[]" id="time">
                        <option value="Live"> Live </option>
                        <option value="Woche"> Woche </option>
                        <option value="Monat"> Monat </option>
                        <option value="Jahr"> Jahr </option>
                    </select>
                </div>
                <div style="margin-top: 20px">
                    <button type="submit" class="btn btn-primary"> Save </button>
                </div>
            </div>
        </div>

    </form>
</div>
@include('layouts.footer')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>
