<!doctype html>
<html>
<head>
    <title>project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
@include('layouts.nav')

<div class="container" style="margin-top: 20px">
    <div class="form-group">
        <label for="UserName" class="col-sm-2 control-label"> Name </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Name" id="UserName" name="name" value="Max">
        </div>
    </div>
    <div>
        <label class="col-sm-2 control-label"> Statistik Optionen </label>
        <div class="border" style="margin-left: 15px">
            <div>
                <label class="checkbox-inline"><input type="checkbox" value=""> Test 1   </label>
            </div>
            <div>
                <label class="checkbox-inline"><input type="checkbox" value=""> Test 2  </label>
            </div>
            <div>
                <label class="checkbox-inline"><input type="checkbox" value=""> Test 3  </label>
            </div>
        </div>
        <br>
        <div class="border" style="margin-left: 15px">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                <label class="form-check-label" for="inlineCheckbox1"> Test 1</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                <label class="form-check-label" for="inlineCheckbox2"> Test 2</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" >
                <label class="form-check-label" for="inlineCheckbox3"> Test 3</label>
            </div>
        </div>
        <div class="form-group" style="margin-top: 20px">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><span class="glyphicon-floppy-disk"> Save </span></button>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
</body>
</html>
