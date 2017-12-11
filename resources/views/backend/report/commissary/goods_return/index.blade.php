@extends ('backend.layouts.app')

@section ('title', 'Commissary Disposal Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>Commissary Disposal Report</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header witd-border">
            <h3 class="box-title">Report List</h3>

            <div class="box-tools pull-right">
                <div class="col-lg-2">
                    <button class="btn btn-warning btn-sm" onClick="$('#daily_log_table').tableExport({type:'excel',escape:'false'});"><i class="fa fa-bars"></i> Export Table Data</button>
                </div>
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-lg-10">
                    {{ Form::open(['route' => 'admin.report.commissary.goods_return.store', 'class' => 'form-horizontal', 'role' => 'form', 'metdod' => 'post']) }}

                        <div class="form-group">
                            {{ Form::label('date', 'Date', ['class' => 'col-lg-1 control-label']) }}

                            <div class="col-lg-3">
                                {{ Form::text('date', old('date', date('Y-m-d')), ['class' => 'form-control date', 
                                    'required' => 'required']) }}
                            </div>

                            <div class="col-lg-2">
                                {{ Form::submit('Get Record', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>

                    {{ Form::close() }}  
                </div>
            </div>

            <table class="table table-responsive table-bordered" id="daily_log_table">
                <thead>
                    <th style="color:red">DURATION DATE</th>
                </thead>
                <tr>
                    <td>DATE</td>
                    <td>DISPOSAL/RETURN ITEM</td>
                    <td>QUANTITY</td>
                    <td>COST</td>
                    <td>TOTAL COST</td>
                    <td>REASON</td>
                    <td>WITNESS</td>
                </tr>
                <tbody>
                    @if(count($disposals))
                        @foreach($disposals as $disposal)
                            <tr>
                                <td>{{ $disposal->date }}</td>
                                <td>{{ $disposal->inventory->name }}</td>
                                <td>{{ $disposal->quantity }}</td>
                                <td>{{ $disposal->cost }}</td>
                                <td>{{ $disposal->total_cost }}</td>
                                <td>{{ $disposal->reason }}</td>
                                <td>{{ $disposal->witness }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="8">&nbsp;</td>
                        </tr>
                        <tr style="color:red">
                            <td colspan="4"></td>
                            <td><b>GRAND TOTAL: </b></td>
                            <td colspan="2"><b>{{ number_format($disposals->sum('total_cost'), 2) }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td>Prepared by:</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!--box-->


@endsection

@section('after-scripts')
    {{ Html::script('js/tableExport.js')}}
    {{ Html::script('js/jquery.base64.js')}}
    {{ Html::script('https://code.jquery.com/ui/1.11.3/jquery-ui.min.js') }}
    {{ Html::script('js/timepicker.js') }}
    <script>
        $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' });
        $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' });
    </script>
@endsection
