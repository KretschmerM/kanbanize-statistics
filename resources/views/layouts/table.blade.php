<style>
    .table {
        color: white;
    }
</style>

<div class="col-md-6" style="margin-top: 20px">
    <div class="panel panel-default">
        <div class="panel-heading " style="height: 31px">
            <a> {{ $options['data']['name'] }} </a>
            <form class="float-md-right" action="/settings/{{ $option['settingId'] }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button class="btn btn-sm btn-info" type="submit"><span class="fas fa-minus-circle"></span></button>
            </form>
            <div style="margin-right: 5px" class="float-md-right">
                <a class="btn btn-sm btn-info" href="/settings/{{ $option['settingId'] }}"><span
                        class="fas fa-cog"></span></a>
                     </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped border">
                <thead>
                <tr style="background-color: #0069d9">
                    <th> Datum</th>
                    <th> Open</th>
                    <th> Doing</th>
                    <th> Done</th>

                </tr>
                </thead>
                <tbody style="color: black">
                @foreach ($data as $date => $value)

                <tr>
                    <td> {{ $date }}</td>
                    <td> {{ $value['open'] }}</td>
                    <td> {{ $value['doing'] }}</td>
                    <td> {{ $value['done'] }}</td>
                </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
