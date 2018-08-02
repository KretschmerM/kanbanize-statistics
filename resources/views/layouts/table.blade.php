<style>
    .table {
        color: white;
    }
</style>

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
            <td> {{ $date }} </td>
            <td> {{ $value['open'] }} </td>
            <td> {{ $value['doing'] }} </td>
            <td> {{ $value['done'] }} </td>
        </tr>

        @endforeach
        </tbody>
    </table>
</div>
