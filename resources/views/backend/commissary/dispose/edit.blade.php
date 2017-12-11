@extends ('backend.layouts.app')

@section ('title', 'Product Management | Edit')

@section('after-styles')
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>
        Product Management
        <small>Edit</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($product, ['route' => ['admin.product.update', $product], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-product', 'enctype' => 'multipart/form-data']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Product</h3>

                <div class="box-tools pull-right">
                    @include('backend.commissary.product.includes.partials.product-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.access.roles.name'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::hidden('id', old('id')) }}
                        {{ Form::text('name', $product->name, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'readonly' => 'true']) }}
                        
                    </div><!--col-lg-10-->


                    {{ Form::label('price_m', 'Price Medium', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::text('price_m', substr($product->price, 0, strpos($product->price, ",")), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div><!--col-lg-10-->

                    
                    
                    
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('code', 'Product Code', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('code', old('code'), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div>
                    {{ Form::label('price_l', 'Price Large', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::text('price_l', substr($product->price, (strpos($product->price, ",") + 1)), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('category', 'Product Category', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('category', [
                                'JUICE' => 'JUICE',
                                'LYCHEE JUICE' => 'LYCHEE JUICE',
                                'SHAKES' => 'SHAKES',
                                'DESSERT' => 'DESSERT'
                            ] ,old('category'), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div><!--col-lg-10-->

                    {{ Form::label('image', 'Product Image', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::file('image', old('image'), ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('ingredient_list', 'Ingredient List', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('ingredient_list', $ingredients,old('ingredient_list'), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div>

                    <div class="col-lg-4">
                        <a class="btn btn-primary" href="#" id="btn_add">Add Ingredient</a>
                    </div>
                    
                    {{ Form::hidden('ingredients', $product->inventories->pluck('id')->implode(","), ['id' => 'ingredients']) }}
                </div>
                <hr>
                <div class="form-group">
                    <div class="col-lg-4 col-lg-offset-2">
                        <table class="table table-responsive table-bordered" id="tbl_ingredients">
                            <thead>
                                <th>INGREDIENT LIST</th>
                            </thead>
                            <tbody>
                                @foreach($product->inventories as $ingredient)
                                <tr id='{{ $ingredient->id }}'>
                                    <td>
                                        {{ $ingredient->name }} 
                                        <a href="#" class="pull-right" onclick="remove(this)">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>

            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.product.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
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
        var ingredients = [{{$product->inventories->pluck('id')->implode(",")}}];
        var index       = {{ count($product->inventories) }};

        var obj = [<?php 
                        foreach($ingredients as $ingredient)
                        {
                            echo '"'.$ingredient.'",';
                        }
                    ?>
                  ];

        $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' });
        $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' });

        $('#btn_add').on('click', function(){
            var html    = '';
            var ing     = parseInt($('#ingredient_list').val());

            if(index == 0 ){
                if(ing != 0){
                    $('#tbl_ingredients tbody').find('tr').remove();
                    
                    addRow(ing);
                }
            } else {
                addRow(ing);
            }
        });

        function addRow(val){
            if(!exist(val)){
                ingredients[index] = val;

                var text = $('#ingredient_list').find('option[value='+ val +']').text();
                var row  = '<tr id="'+ val +'"><td><span>' + text + '</span>';
                    row  += '<a href="#" class="pull-right" onclick="remove(this)">Remove</a></td>';
                    row  += '</tr>';

                $('#ingredients').val(ingredients);
                $('#tbl_ingredients tbody').append(row);

                index++;
            }
        }

        function exist(val){
            return $('#tbl_ingredients tbody').find('tr#' + val).length;
        }

        function remove(e){
            $(e).closest('tr').remove();
            var rem_id      = $(e).closest('tr').attr('id');
            var rem_index   = ingredients.indexOf(parseInt(rem_id));

            ingredients.splice(rem_index, 1);
            index--;

            $('#ingredients').val(ingredients);

            var count = $('#tbl_ingredients tbody').find('tr').length;

            if(count == 0){
                $('#tbl_ingredients tbody').append('<tr><td>No Ingredient.</td></tr>');
            }

        }
    </script>
@endsection
