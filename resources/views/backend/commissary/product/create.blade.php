@extends ('backend.layouts.app')

@section ('title', 'Commissary Product Management | Add Product')

@section('after-styles')
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>
        Commissary Product Management <small>Add Product</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.commissary.product.store', 'class' => 'form-horizontal', 'Product' => 'form', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Product</h3>

                <div class="box-tools pull-right">
                    @include('backend.commissary.product.includes.partials.product-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', 'Product Name', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-5">
                        {{ Form::text('name', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Product Name']) }}
                    </div><!--col-lg-10-->

                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('price', 'Price', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-5">
                        {{ Form::text('price', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required' ]) }}
                    </div><!--col-lg-10-->

                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('category', 'Product Category', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-5">
                        {{ Form::select('category', $categories ,old('category'), ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required']) }}
                    </div><!--col-lg-10-->

                </div>

                <div class="form-group">
                    {{ Form::label('list', 'Ingredients', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::select('list', $selections ,old('list'), ['class' => 'form-control', 'id' => 'list']) }}
                    </div><!--col-lg-10-->

                    {{ Form::label('quantity', 'Quantity', ['class' => 'col-lg-1 control-label']) }}

                    <div class="col-lg-1">
                        {{ Form::text('quantity', old('quantity', 0), ['class' => 'form-control', 'id' => 'quantity']) }}
                    </div><!--col-lg-10-->

                    <div class="col-lg-2">
                        <a href="#" class="btn btn-primary" onclick="addIngredient()">ADD</a>
                    </div>

                    {{ Form::hidden('ingredients', '', ['id' => 'ingredients']) }}
                </div>

                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-1">
                        <table class="table table-bordered">
                            <thead>
                                <th>&nbsp;</th>
                                <th>Name</th>
                                <th>Qty</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.product.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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
        var ingredients = {!! $ingredients !!};

        $('form').submit(function(e){
            var ing  ='';
            var rows = $('tbody').find('tr');
            var obj  = [];

            for(var i = 0; i < rows.length; i++)
            {
                var cols = $(rows[i]).find('td');
                var id   = $(cols[0]).text();
                var name = $(cols[1]).text();
                var qty  = $(cols[2]).text();

                obj.push({id: id, name: name, quantity: qty});
            }

            $('#ingredients').val(JSON.stringify(obj));

            ing = $('#ingredients').val();

            if(ing == '[]')
                e.preventDefault();
        });

        function addIngredient(){
            var selected    = $('#list').val();
            var ing         = findIngredients(selected);
            var name        = ing[0]['name'];
            var id          = ing[0]['id'];
            var qty         = $('#quantity').val();
            var row         = '<tr id="' + id +'"><td>' + id + '</td><td>' + name +'</td><td>' + qty +'</td></tr>';
            
            if(!exist(id))
                $('table tbody').append(row);
        }

        function exist(id){
            return $('tr#'+id).length;
        }

        function findIngredients(id){
            return $.grep(ingredients, function(n, i){
              return n.id == id;
            });
        };
    </script>
@endsection
