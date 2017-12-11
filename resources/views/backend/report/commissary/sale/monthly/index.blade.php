@extends ('backend.layouts.app')

@section ('title', 'Monthly Sale Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
    <style type="text/css">
        .maroon{
            color: #fff;
            background: rgb(118,0,0);
        }
        .text-center{
            text-align: center;
        }
    </style>
@endsection

@section('page-header')
    <h1>Commissary Monthly Report</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Report List</h3>

            <div class="box-tools pull-right">

            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-lg-10">
                    {{ Form::open(['route' => 'admin.report.commissary.monthly.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                        <div class="form-group">
                            {{ Form::label('date', 'Date', ['class' => 'col-lg-1 control-label']) }}

                            <div class="col-lg-3">
                                {{ Form::text('date', date('Y-m-d'), ['class' => 'form-control date', 'maxlength' => '191', 
                                    'required' => 'required']) }}
                            </div><!--col-lg-10-->

                            <div class="col-lg-2">
                                {{ Form::submit('Get Record', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div><!--form control-->

                    {{ Form::close() }}  
                </div>
                
                <div class="col-lg-2">
                    <button class="btn btn-warning btn-sm" onClick="$('#daily_log_table').tableExport({type:'excel',escape:'false'});"><i class="fa fa-bars"></i> Export Table Data</button>
                </div>
            </div>

            <table class="table table-responsive table-bordered">
                <thead>
                    <th>PRODUCT</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>                    
                    <th>TOTAL</th>
                </thead>
                <tbody>
                    @if(count($commissary))
                    @foreach($commissary as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            @if(count($inventory[$item->name]))
                            {{ $inventory[$item->name] }}
                            @else
                            0
                            @endif
                        </td>
                        <td>
                            @if(count($inventory[$item->name]))
                            {{ number_format($inventory[$item->name] * $item->price, 2) }}
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan=2>&nbsp;</td>
                        <td style="text-align:right"><b>GRAND TOTAL</b></td>
                        <td>
                            <?php 
                                $total = 0;
                                foreach($commissary as $item){
                                    $total = $total + ((int)$inventory[$item->name] * $item->price);
                                }

                                echo number_format($total, 2);
                            ?>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan=2>no record.</td>
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

<script type="text/javascript">
    $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' });
    $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' });
</script>
@endsection
