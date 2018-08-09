<div class="col-md-6" style="margin-top: 20px">
    <div class="panel panel-default">
        <div class="panel-heading " style="height: 31px">
            <a> {{ $options['data']['name'] }} </a>
            <form class="float-md-right" action="/settings/{{ $option['settingId'] }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button class="btn btn-sm btn-info" type="submit"><i class="fas fa-minus-circle"></i></button>
            </form>
            <div style="margin-right: 5px" class="float-md-right">
                <a class="btn btn-sm btn-info" href="/settings/{{ $option['settingId'] }}"><span
                        class="fas fa-cog"></span></a>
                     </div>
        </div>
        <div class="panel-body border">
            <div id="lineChart_{{ $option['settingId'] }}">
                @linechart('lineChart_'.$option['settingId'], 'lineChart_'.$option['settingId'])
            </div>
        </div>
    </div>
</div>

