<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading " style="height: 31px">
            <a> {{ $options['data']['name'] }} </a>
            <span class="float-md-right">
                        <a class="btn btn-sm btn-info" href="/settings/{{ $option['settingId'] }}"><span
                                class="fas fa-cog"></span></a>
                     </span>
        </div>
        <div id="lineChart_{{ $option['settingId'] }}">
            @linechart('lineChart_'.$option['settingId'], 'lineChart_'.$option['settingId'])
        </div>
    </div>
</div>

