@extends ('backend.layouts.app')

@section ('title', 'POS Inventory Management | Add Inventory')

@section('after-styles')
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>
        POS Inventory Management <small>Add Inventory</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.inventory.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Inventory</h3>

                <div class="box-tools pull-right">
                    @include('backend.inventory.includes.partials.inventory-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">                    
                    {{ Form::label('supplier', 'Supplier', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-4">
                        {{ Form::select('supplier', ['Commissary Product' => 'Commissary Product', 'Commissary Raw Material' => 'Commissary Raw Material','Other' => 'Other'], old('commissaries'), ['class' => 'form-control', 'id' => 'supplier']) }}
                    </div>
                    
                </div>

                <div class="form-group">                    
                    {{ Form::label('inventory_id', 'Item Name', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-4" id="inventory_panel">
                        {{ Form::select('inventory_id', $products, old('inventory_id'), ['class' => 'form-control', 'required' => 'required', 'id' => 'inventory_id']) }}
                    </div>

                    {{ Form::label('reorder_level', 'Critical Level', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('reorder_level', 0, ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                    
                </div><!--form control-->               

                <div class="form-group">
                    {{ Form::label('unit_type', 'Unit Type', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        <select class="form-control" name="unit_type">
                            <option>Spoon</option>
                            <option>Scoop</option>
                            <option>Unit</option>
                            <option>Slice</option>
                            <option>Piece</option>
                            <option>Case</option>
                            <option>Gallon</option>
                            <option>Liter</option>
                            <option>Ounce</option>
                            <option>gram</option>
                            <option>Pack</option>
                            <option>Pound</option>
                            <option>Can</option>
                            <option>Case</option>
                            <option>Bottle</option>
                            <option>Plate</option>
                            <option>Tub</option>
                        </select>
                    </div>


                    {{ Form::label('category_id', 'Category', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div>
                </div>
                
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.inventory.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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
    {{ Html::script('js/timepicker.js') }}
    {{ Html::script('js/backend/access/users/script.js') }}
    <script type="text/javascript">
        var products = '{!! Form::select("inventory_id", $products, old("inventory_id"), ["class" => "form-control", "required" => "required"]) !!}';
        var raws     = '{!! Form::select("inventory_id", $raws, old("inventory_id"), ["class" => "form-control", "required" => "required"]) !!}';
        var others   = '{!! Form::text("inventory_id", old("inventory_id"), ["class" => "form-control", "required" => "required"]) !!}';

        $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' });
        $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' });

        $(document).ready(function(){

            @if(count($products) == 0 && count($raws) == 0)
            $('#supplier').val('Other');
            $('#inventory_panel').find('select').remove();
            $('#inventory_panel').append(others);
            @else
            $('#supplier').val('Commissary Raw Material');
            $('#inventory_panel').find('select').remove();
            $('#inventory_panel').append(raws);
            @endif

        });

        $('#supplier').on('change', function(){
            var val = $(this).val();

            $('#inventory_panel').find('select').remove();
            $('#inventory_panel').find('input').remove();

            if(val == 'Other')
            {
                $('#inventory_panel').append(others);
            }
            else if(val == 'Commissary Raw Material')
            {
                $('#inventory_panel').append(raws);
            }
            else
            {
                $('#inventory_panel').append(products);
            }
        });
    </script>
@endsection
