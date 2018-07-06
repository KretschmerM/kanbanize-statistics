<!doctype html>
<html>

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
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

</head>
<body>
@include('layouts.nav')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" >
                <div class="panel-heading " style="height: 31px">
                    <a> Bug Statistik </a>
                    <span class="float-md-right">
                        <a href="/generate/50" class="btn btn-sm btn-info">
                            <span class="fas fa-sync-alt"></span></a>
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

</body>

</html>


