@extends ('backend.layouts.app')

@section ('title', 'Commissary Disposal Form | Dispose Item')

@section('after-styles')
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>
        Commissary Disposal Form <small>Dispose Item</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.commissary.dispose.store', 'class' => 'form-horizontal', 'Product' => 'form', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Dispose Item</h3>

                <div class="box-tools pull-right">
                    @include('backend.commissary.dispose.includes.partials.dispose-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">

                <div class="form-group">
                    {{ Form::label('item_type', 'Item Type', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('item_type', ['Product' => 'Product', 'Raw Material' => 'Raw Material'], old('item_type'), ['class' => 'form-control date', 'id' => 'item_type', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('inventory_id', 'Item Name', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4" id="item_panel">
                        {{ Form::select('inventory_id', count($products) ? $products : $inventories, old('inventory_id'), ['class' => 'form-control date', 'maxlength' => '191', 'required' => 'required']) }}
                    </div>

                    {{ Form::label('date', 'Date', ['class' => 'col-lg-1 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('date', old('date', date('Y-m-d')), ['class' => 'form-control date', 'maxlength' => '191', 
                            'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('quantity', 'Quantity', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::number('quantity', old('quantity', 0), ['class' => 'form-control', 'maxlength' => '191', 
                            'required' => 'required']) }}
                    </div>

                    {{ Form::label('witness', 'Witness', ['class' => 'col-lg-1 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('witness', old('witness'), ['class' => 'form-control', 'maxlength' => '191', 
                            'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('branch_id', 'Branch', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('branch_id', $branches, old('branch_id'), ['class' => 'form-control date', 'maxlength' => '191', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('reason', 'Reason', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-9">
                        {{ Form::textarea('reason', old('reason'), ['class' => 'form-control', 'maxlength' => '191', 
                            'required' => 'required', 'rows' => '4']) }}
                    </div>
                </div>

            </div>
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.commissary.dispose.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('https://code.jquery.com/ui/1.11.3/jquery-ui.min.js') }}
    {{ Html::script('js/backend/access/users/script.js') }}
    {{ Html::script('js/timepicker.js') }}
    <script>
        var products    = '{!! Form::select("inventory_id", $products, old("inventory_id"), ["class" => "form-control", "required" => "required"]) !!}';
        var inventories = '{!! Form::select("inventory_id", $inventories, old("inventory_id"), ["class" => "form-control", "required" => "required"]) !!}';

        $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' });
        $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' });

        $('#item_type').on('change', function(){
            if($(this).val() == 'Product')
            {
                $('#item_panel').find('select').remove();
                $('#item_panel').append(products);
            }
            else
            {
                $('#item_panel').find('select').remove();
                $('#item_panel').append(inventories);
            }
        });

    </script>
@endsection
