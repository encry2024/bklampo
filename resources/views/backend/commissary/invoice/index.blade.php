@extends ('backend.layouts.app')

@section ('title', 'Sales Invoice')

@section('after-styles')
<style type="text/css">
    tr.title td{
        background: #9bcae4;
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
                {{ Form::open(['route' => 'admin.commissary.invoice.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label>DATE</label>
                            <input class="form-control" type="text" name="date" id="datepicker" required value="{{ $date }}">                
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" style="margin-top: 25px"><i class="fa fa-calendar"></i> Search Date</button>
                        </div>
                    </div>

                {{ Form::close() }}  
            </div>

            <table class="table table-bordered table-stripped" id="daily_log_table">
                <thead>
                    <th style="text-align:center" colspan="4">Delivery Report</th>
                </thead>
                <tbody>
                    <tr>
                        <td>From:</td>
                        <td>{{ app_name() }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Address</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Phone No#</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr class="title">
                        <td><b>DATE</b></td>
                        <td><b>YOUR NO#</b></td>
                        <td><b>OUR NO#</b></td>
                        <td><b>SALES PERSON</b></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="title">
                        <td>&nbsp;</td>
                        <td>QUANTITY</td>
                        <td>PRODUCT NO.</td>
                        <td>DESCRIPTION</td>
                    </tr>

                    @if(count($datas))
                        @foreach($datas as $data)
                        <tr>
                            <td>&nbsp;</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->inventory_id }}</td>
                            <td>{{ $data->inventory->name }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No Record in list.</td>
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
@endsection