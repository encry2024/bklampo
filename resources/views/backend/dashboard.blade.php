@extends('backend.layouts.app')

@section('after-styles')
{{ Html::style('css/highcharts.css') }}
{{ Html::style('css/dashboard.css') }}
@endsection

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>{{ trans('strings.backend.dashboard.title') }}</small>
    </h1>
@endsection

@section('content')
    @roles([1, 2])
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">POS MONTHLY SALES</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <div id="posChart"></div>
        </div><!-- /.box-body -->
    </div><!--box box-success-->
    @endauth

    @roles([1,3])
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">COMMISSARY MONTHLY SALES</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <div id="commissaryChart"></div>
        </div><!-- /.box-body -->
    </div><!--box box-success-->
    @endauth

    @roles([1,2])
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Top Products for {{ date('F') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <ul class="list-group">
                    @if(count($tops))
                        @foreach($tops as $product)
                            <li class="list-group-item">
                                {{ $product->name }}   
                                <span class="label label-primary pull-right">
                                    {{ $product->count }}
                                </span>                             
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            No product to be list.                              
                        </li>
                    @endif
                </ul>
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    </div>

    <div class="col-lg-6">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Request</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if(count($requests))
                    @foreach($requests as $request)
                        <li class="list-group-item">
                            {{ $request->title }}&nbsp;
                            <a href="{{ route('admin.request.show', $request) }}" class="btn btn-xs btn-primary pull-right">View</a>
                        </li>
                    @endforeach
                    <li class="list-group-item" style="text-align: center">
                        <a href="{{ route('admin.request.index') }}">View All</a>
                    </li>
                @else
                <li class="list-group-item">No Request</li>
                @endif
            </div>
        </div>
    </div>
    @endauth
    
@endsection

@section('after-scripts')
{{ Html::script('js/highcharts.js') }}
<script type="text/javascript">
    var request_id = 0;
    var request_from = '';

    @roles([1,2])
    Highcharts.chart('posChart', {

        title: {
            text: ' '
        },

        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                @foreach($monthNames as $name)
                    '{{ $name }}',
                @endforeach
            ]
        },
        yAxis: {
            title: {
                text: 'Value'
            }
        },
        tooltip: {
            valueSuffix: ' PHP'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            lineWidth: 1,
                shadow: true,
        },

        series: [{
            name: 'SALES',
            data: [
                @foreach($months as $month)
                {{ $month }},
                @endforeach
            ]
        }]

    });
    @endauth

    @roles([1,3])
    Highcharts.chart('commissaryChart', {

        title: {
            text: ' '
        },

        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                @foreach($monthNames as $name)
                    '{{ $name }}',
                @endforeach
            ]
        },
        yAxis: {
            title: {
                text: 'Value'
            }
        },
        tooltip: {
            valueSuffix: ' PHP'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            lineWidth: 1,
                shadow: true,
        },

        series: [{
            name: 'SALES',
            data: [
                @foreach($commissaries as $commissary)
                {{ $commissary }},
                @endforeach
            ]
        }]

    });
    @endauth

    $('.highcharts-credits').hide();
</script>
@endsection