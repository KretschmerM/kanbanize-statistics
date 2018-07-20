<!doctype html>
<html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">


<style>
    .panel-heading {
        color: white;
        background-color: #2e3436;
        text-align: center;
    }
</style>
<style>
    .table {
        color: white;
    }
</style>

<head>
    <title>project</title>
</head>
<body>
@include('layouts.nav')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" >
                <div class="panel-heading " style="height: 31px">
                    <a> Bug Statistik Tabelle </a>
                    <span class="float-md-right">
                        <a href="/generate/50" class="btn btn-sm btn-info">
                            <span class="fas fa-sync-alt"></span></a>
                        <a class="btn btn-sm btn-info" href="/settings/1" style="margin-right: 5px"><span class="fas fa-cog"></span></a>
                     </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped border">
                        <thead>
                        <tr style="background-color: #0069d9">
                            <th> Datum </th>
                            @foreach ($headers as $header)
                            <th> {{ $header['name'] }} </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @foreach ($statistic as $date => $columns)
                        <tr>
                            <td> {{ $date }} </td>
                            @foreach ($columns as $column)
                            <td> {{ $column['count'] }} </td>
                            @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br> <br> <br>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Bug Statistik Graph
                    <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/2" style="margin-right: 5px"><span class="fas fa-cog"></span></a>
                     </span>
                </div>
                <div class="panel-body border">
                    <div id="temps_div">
                        @linechart('Temps', 'temps_div')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Test
                </div>
                <div class="panel-body border">
                    <br>
                    <h1> Test </h1>
                </div>
            </div>
        </div>
    </div>
    <br> <br> <br>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Test
                </div>
                <div class="panel-body border">
                    <br>
                    <h1> Test </h1>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Test
                </div>
                <div class="panel-body border">
                    <br>
                    <h1> Test </h1>
                </div>
            </div>
        </div>
    </div>
</div>

 @include('layouts.footer')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


</body>

</html>


