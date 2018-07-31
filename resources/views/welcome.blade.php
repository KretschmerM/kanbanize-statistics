<!doctype html>
<html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
      integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
      integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
      integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">


<style>
    .panel-heading {
        color: white;
        background-color: #2e3436;
        text-align: center;
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
            <div class="panel panel-default">
                <div class="panel-heading " style="height: 31px">
                    <a> Statistik </a>
                    <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/1"><span
                                class="fas fa-cog"></span></a>
                     </span>
                </div>

            </div>
        </div>
    </div>
    <br> <br> <br>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 31px">
                    Statistik
                    <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/2"><span
                                class="fas fa-cog"></span></a>
                     </span>
                </div>
                <div class="panel-body border">



                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 31px">
                    Statistik
                    <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/3"><span
                                class="fas fa-cog"></span></a>
                     </span>
                </div>
                <div class="panel-body border">
                    <div id="test_div">
                        @linechart('hi', 'test_div')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br> <br> <br>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 31px">
                    Statistik
                    <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/4"><span
                                class="fas fa-cog"></span></a>
                     </span>
                </div>
                <div class="panel-body border">
                    <div id="chart-div">
                        @piechart('Test', 'chart-div')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 31px">
                    Statistik
                    <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/5"><span
                                class="fas fa-cog"></span></a>
                     </span>
                </div>
                <div class="panel-body border">
                    <br>
                    <h1>  </h1>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>


</body>

</html>


