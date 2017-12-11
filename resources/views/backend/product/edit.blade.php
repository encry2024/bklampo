@extends ('backend.layouts.app')

@section ('title', 'POS Product Management | Add Product')

@section('after-styles')
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>
        POS Product Management <small>Add Product</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => ['admin.product.update', $product], 'class' => 'form-horizontal', 'Product' => 'form', 'method' => 'patch', 'enctype' => 'multipart/form-data']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Product</h3>

                <div class="box-tools pull-right">
                    @include('backend.Product.includes.partials.product-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', 'Product Name', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('name', $product->name, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Product Name']) }}
                    </div><!--col-lg-10-->

                    {{ Form::label('code', 'Product Code', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('code', $product->code, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
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
                            ] , $product->category, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div><!--col-lg-10-->

                    {{ Form::label('image', 'Product Image', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::file('image', null, ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('product_size', 'Product Size', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('product_size', 
                            [
                                'Small'  => 'Small',
                                'Medium' => 'Medium',
                                'Large'  => 'Large'
                            ], old('product_size'), 
                            [
                                'class' => 'form-control select2', 
                                'required' => 'required'
                            ]) 
                        }}

                        {{ Form::hidden('product_ingredients', '', ['id' => 'product_ingredients']) }}
                    </div>

                    <div class="col-lg-2">
                        <a class="btn btn-primary" href="#" id="btn_add_size">Add Size</a>
                    </div>
                </div>

                <div id="panel_sizes">
                    
                    @if(count($product->product_size))
                        @foreach($product->product_size as $item)
                        <div class="panel_product">
                            <hr>
                            <div class="form-group">
                                <h4 class="col-lg-10 col-lg-offset-1">
                                    <small>Product Size:</small>
                                    {{ $item->size }}
                                </h4>

                                <div class="col-lg-1">
                                    <a href="#" class="btn btn-xs btn-danger pull-right" onclick="removeTable(this)">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>

                                <div class="col-lg-12">
                                    {{ Form::label("price", "Price", ["class" => "col-lg-2 control-label"]) }}

                                    <div class="form-group col-lg-3" style="margin-left:0">
                                        {{ Form::text("price", $item->price, ["class" => "form-control"]) }}
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    {{ Form::label("ingredient_list", "Ingredient", ["class" => "col-lg-2 control-label"]) }}

                                    <div class="col-lg-3">
                                        {{ 
                                            Form::select("ingredient_list", 
                                            $selections, old("ingredient_list"), 
                                            [
                                                "class" => "form-control select2", 
                                                "onchange" => "fetchUnitType(this)"
                                            ]) 
                                        }}
                                    </div>

                                    {{ 
                                        Form::label("ingredient_quantity", 
                                        "Piece", 
                                        [
                                            "class" => "col-lg-1 control-label", 
                                            "id" => "unit_type"
                                        ]) 
                                    }}

                                    <div class="col-lg-2">
                                        {{ Form::number("ingredient_quantity", 1, ["class" => "form-control"]) }}
                                    </div>

                                    <div class="col-lg-2">
                                        <a class="btn btn-primary" href="#" onclick="add_ingredient(this)">Add Ingredient</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-7 col-lg-offset-1">
                                    <table class="table table-bordered" id="table_product" data-id="{{ $item->size }}">
                                        <thead>
                                            <th>ID</th>
                                            <th>INGREDIENT</th>
                                            <th>Quantity</th>
                                            <th style="width:20%">&nbsp;</th>
                                        </thead>
                                        <tbody>
                                        @if(count($item->ingredients))
                                            @foreach($item->ingredients as $ingredient)
                                            <tr id="{{ $ingredient->id }}">
                                                <td>{{ $ingredient->id }}</td>
                                                <td><?php 
                                                    if($ingredient->supplier == 'Other'){
                                                        echo $ingredient->other->name;
                                                    } elseif($ingredient->supplier == 'Commissary Product') {
                                                        echo $ingredient->commissary_product->name;
                                                    } else {
                                                        echo $ingredient->commissary_inventory->name;
                                                    }

                                                ?></td>
                                                <td>{{ $ingredient->pivot->quantity }}</td>
                                                <td><a href="#" class="btn btn-xs btn-danger" onclick="removeRow(this)">Remove</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div><!--box-->

        <div class="box box-info">
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
        var index       = 0;
        var ingredients = {!! json_encode($ingredients) !!};
        var obj = [
                    <?php 

                        foreach($selections as $ingredient)
                        {
                            echo '"'.$ingredient.'",';
                        }

                    ?>
                  ];

        $('form').on('submit', function(e){
            //filter table returns table with existing rows
            var products = filterTable();

            if(products.length > 0){
                var objs = [];

                for(var i = 0; i < products.length; i++){
                    var table = $(products[i]).find('table');
                    var body  = $(table).find('tbody');
                    var rows  = $(body).find('tr');
                    var size  = $(table).attr('data-id');
                    var price = $(products[i]).find('input#price').val();
                    var ingredient   = [];

                    for(var j = 0; j < rows.length; j++){
                        var cols = $(rows[j]).find('td');
                        var id   = $(cols[0]).text();
                        var name = $(cols[1]).text();
                        var qty  = $(cols[2]).text();

                        ingredient.push({ id: id, name: name, quantity: qty });

                    }

                    objs.push({size: size, price: price, ingredient });
                }

                $('#product_ingredients').val(JSON.stringify(objs));
            } else {
                e.preventDefault();
            }
        });


        $('#btn_add_size').on('click', function(){
            var count = 0;
            var size = $('#product_size').val();

            var products = $('body').find('.panel_product');

            //
            // find table size
            //
            for(var i = 0; i < products.length; i++)
            {
                var exist_size = $(products[i]).find('table').attr('data-id');
                
                if(exist_size == size)
                {
                    count++;
                }

            }

            if(count == 0)
            {
                var html =  '<div class="panel_product">'
                    html += '<hr>';
                    html += '<div class="form-group">';
                    html += '<h4 class="col-lg-10 col-lg-offset-1"><small>Product Size:</small> ' + size + '</h4>';
                    html += '<div class="col-lg-1">';
                    html += '<a href="#" class="btn btn-xs btn-danger pull-right" onclick="removeTable(this)"><i class="fa fa-times"></i></a>';
                    html += '</div>';
                    html += '<div class="col-lg-12">';
                    html += '{{ Form::label("price", "Price", ["class" => "col-lg-2 control-label"]) }}';
                    html += '<div class="form-group col-lg-3" style="margin-left:0">';
                    html += '{{ Form::text("price", 0, ["class" => "form-control"]) }}';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-lg-12">';
                    html += '{{ Form::label("ingredient_list", "Ingredient", ["class" => "col-lg-2 control-label"]) }}';
                    html += '<div class="col-lg-3">'
                    html += '{{ Form::select("ingredient_list", $selections, old("ingredient_list"), ["class" => "form-control select2", "onchange" => "fetchUnitType(this)"]) }}';
                    html += '</div>';
                    html += '{{ Form::label("ingredient_quantity", "Piece", ["class" => "col-lg-1 control-label", "id" => "unit_type"]) }}';
                    html += '<div class="col-lg-2">'
                    html += '{{ Form::number("ingredient_quantity", 1, ["class" => "form-control"]) }}';
                    html += '</div>';
                    html += '<div class="col-lg-2">';
                    html += '<a class="btn btn-primary" href="#" onclick="add_ingredient(this)">Add Ingredient</a>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<div class="col-lg-7 col-lg-offset-1">'
                    html += '<table class="table table-bordered" id="table_product" data-id="'+ size +'" >';
                    html += '<thead>';
                    html += '<th>ID</th>';
                    html += '<th>Unit Type</th>';
                    html += '<th>Quantity</th>';
                    html += '<th style="width:20%">&nbsp;</th>';
                    html += '</thead>';
                    html += '<tbody>';
                    html += '</tbody>';
                    html += '</table>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                $('#panel_sizes').append(html);

                var products = $('body').find('.panel_product');
                var index    = $(products).length - 1;

                scrollTo($(products[index]).offset().top);
            }
        });

        function add_ingredient(e){
            var div     = $(e).closest('.panel_product');
            var select  = $(div).find('select');
            var id      = $(select).val();
            var obj     = findIngredients(id)[0];
            var qty     = $(div).find('input#ingredient_quantity').val();

            if(!existIngredient(div, obj['id']))
            {
                var row     = '<tr id="' + obj['id'] + '">';
                    row     += '<td>' + obj['id'] + '</td>';
                    row     += '<td>' + (obj['supplier'] == 'Others' ? obj['other']['name'] : obj['commissary']['name']) + '</td>';
                    row     += '<td>' + qty + '</td>';
                    row     += '<td><a href="#" class="btn btn-xs btn-danger" onclick="removeRow(this)">Remove</td>';
                    row     += '</tr>';

                $(div).find('table').find('tbody').append(row);
                $(div).find('input#ingredient_quantity').val(1);

                scrollTo($(div).find('table').offset().top);
            }
        }

        function removeTable(e)
        {
            $(e).closest('.panel_product').remove();
        }

        function existIngredient(element, val){
            var body = $(element).find('tbody');
            var row  = $(body).find('tr#'+val);

            return row.length;
        }

        function removeRow(e){
            var body = $(e).closest('tbody');
            $(e).closest('tr').remove();
            scrollTo($(body).offset().top);
        }

        function findIngredients(id){
            return $.grep(ingredients, function(n, i){
              return n.id == id;
            });
        };

        function filterTable(){
            var products = $('body').find('.panel_product');

            //check table if has row
            for(var i = 0; i < products.length; i++){
                var rows = $(products[i]).find('tr');

                if(rows.length == 1){
                    $(products[i]).remove();
                }
            }

            return $('body').find('.panel_product');
        }

        function scrollTo(height){
            $('html, body').animate({
                scrollTop: height
            }, 500);
        }

        function fetchUnitType(e){
            var id = $(e).val();

            $.ajax({
                url: "{!! URL::to('admin/pos/product/unit_type') !!}/" + id,
                type : 'GET',
                success: function(data){
                    var panel = $(e).closest('.panel_product');
                    var label = $(panel).find('label#unit_type');

                    $(label).text(data);
                }
            })
        }
    </script>
@endsection
