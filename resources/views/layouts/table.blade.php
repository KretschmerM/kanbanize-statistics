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
            @foreach ($headers as $header)
            <th> {{ $header['name'] }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody style="color: black">
        @foreach ($statistic as $date => $columns)
        <tr>
            <td> {{ $date }}</td>
            @foreach ($columns as $column)
            <td> {{ $column['count'] }}</td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
