<style>
    .table {
        color: white;
    }
</style>

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading " style="height: 31px">
            <a> {{ $options['data']['name'] }} </a>
            <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/{{ $option['settingId'] }}"><span
                                class="fas fa-cog"></span></a>
                     </span>
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
