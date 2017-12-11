@extends ('backend.layouts.app')

@section ('title', 'Order Form')

@section('after-styles')
<style type="text/css">
    tr.title td{
        background: #9bcae4;
        font-weight: bold;
    }
</style>
@endsection

@section('page-header')
    <h1>Sales Invoice</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                
            </h3>

            <div class="box-tools pull-right">
                <div class="col-lg-2">
                    <button class="btn btn-warning btn-sm" onClick="$('#daily_log_table').tableExport({type:'excel',escape:'false'});"><i class="fa fa-bars"></i> Export Table Data</button>
                </div>
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="col-lg-12">
                {{ Form::open(['route' => 'admin.commissary.order_form.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>From</label>
                            <input class="form-control" type="text" name="from" id="from" readonly required value="{{ $monday }}">                            
                        </div>

                        <div class="form-group col-lg-2">
                            <label>To</label>
                            <input class="form-control" type="text" name="to" id="to" readonly required value="{{ $friday }}">                            
                        </div>

                        <div class="form-group col-lg-2">
                            <label>&nbsp;</label>

                            <div class="input-group">
                                <button type="button" class="btn btn-default pull-right" id="daterange-btn2">
                                <span>
                                    <i class="fa fa-calendar"></i> Select Date
                                </span>
                                <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" style="margin-top: 25px"><i class="fa fa-calendar"></i> Search Date</button>
                        </div>
                    </div>

                {{ Form::close() }} 
            </div>

            <table class="table table-bordered table-stripped" id="daily_log_table">
                <thead>
                    <th style="text-align:center" colspan="8">Order Form</th>
                </thead>
                <tbody>
                    @if(count($records))
                        <tr class="title">
                            <td>NAME</td>
                            <td>CRITICAL</td>
                            <td>UNIT</td>
                            @foreach($records[0]['dates'] as $date)
                            <td>{{ $date }}</td>
                            @endforeach
                        </tr>

                        @foreach($records[0]['items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['critical'] }}</td>
                            <td>{{ $item['unit_type'] }}</td>
                            <td>{{ $item['quantities'][0] }}</td>
                            <td>{{ $item['quantities'][1] }}</td>
                            <td>{{ $item['quantities'][2] }}</td>
                            <td>{{ $item['quantities'][3] }}</td>
                            <td>{{ $item['quantities'][4] }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="8">&nbsp;</td>
                        </tr>

                        <tr class="title">
                            <td>NAME</td>
                            <td>CRITICAL</td>
                            <td>UNIT</td>
                            @foreach($records[0]['dates'] as $date)
                            <td>{{ $date }}</td>
                            @endforeach
                        </tr>

                        @foreach($records[1]['items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['critical'] }}</td>
                            <td>{{ $item['unit_type'] }}</td>
                            <td>{{ $item['quantities'][0] }}</td>
                            <td>{{ $item['quantities'][1] }}</td>
                            <td>{{ $item['quantities'][2] }}</td>
                            <td>{{ $item['quantities'][3] }}</td>
                            <td>{{ $item['quantities'][4] }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="8">&nbsp;</td>
                        </tr>

                        <tr class="title">
                            <td>NAME</td>
                            <td>CRITICAL</td>
                            <td>UNIT</td>
                            @foreach($records[0]['dates'] as $date)
                            <td>{{ $date }}</td>
                            @endforeach
                        </tr>

                        @foreach($records[2]['items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['critical'] }}</td>
                            <td>{{ $item['unit_type'] }}</td>
                            <td>{{ $item['quantities'][0] }}</td>
                            <td>{{ $item['quantities'][1] }}</td>
                            <td>{{ $item['quantities'][2] }}</td>
                            <td>{{ $item['quantities'][3] }}</td>
                            <td>{{ $item['quantities'][4] }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{ Html::script('js/tableExport.js')}}
    {{ Html::script('js/jquery.base64.js')}}

    <script type="text/javascript">
        $('#daterange-btn2').daterangepicker(
                {
                    ranges   : {
                        'This Week'   : [moment().add(1, 'week').startOf('week').subtract(6,'day'), moment().endOf('week').subtract(1, 'day')],
                        'Last 2 Weeks': [moment().subtract(1, 'week').startOf('week').add(1, 'day'), moment().subtract(1, 'week').endOf('week').subtract(1, 'day')],
                        'Last 3 Weeks': [moment().subtract(2, 'week').startOf('week').add(1, 'day'), moment().subtract(2, 'week').endOf('week').subtract(1, 'day')],
                        'Last 4 Weeks': [moment().subtract(3, 'week').startOf('week').add(1, 'day'), moment().subtract(3, 'week').endOf('week').subtract(1, 'day')],
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                    },
                    function (start, end) {
                        $('#from').val(start.format('YYYY-MM-DD'));
                        $('#to').val(end.format('YYYY-MM-DD'));

                }
            );
    </script>
@endsection