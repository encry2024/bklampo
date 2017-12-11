@extends('frontend.layouts.app')

@section('after-styles')

{{ Html::style('css/dashboard.css') }}

@endsection

@section('content')
    <div class="row">

        <div class="col-xs-12">

          
          <div class="panel panel-default">
              <div class="panel-heading">CREATE REQUEST</div>

              <div class="panel-body">
                  
                 {{ Form::open(['route' => 'frontend.user.request.store', 'class' => 'form-horizontal', 'Product' => 'form', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

                 <div class="form-group">
                    {{ Form::label('title', 'Title', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('title', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus']) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('message', 'Message', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-9 col-offset-lg-1">
                        {{ Form::textarea('message', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'rows' => '6']) }}
                        {{ Form::hidden('requests', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'id' => 'requests']) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('ingredient_list', 'Ingredient List', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::select('ingredient_list', $ingredients, null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'id' => 'ingredient_list']) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('quantity', 'Quantity', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::number('quantity', '1', ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'id' => 'quantity' ]) }}
                    </div>
                </div>

                <div class="form-group">
                  {{ Form::label('unit_type', 'Unit Type', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('unit_type', 'Other', ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'id' => 'unit_type', 'readonly' => 'readonly' ]) }}
                    </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">&nbsp;</label>

                    <div class="col-lg-4">
                        <button type="button" class="btn btn-default" onclick="addItem();"><i class="fa fa-plus"></i> Add Request</button>
                        <span style="color:red" id="warning" hidden>Already in requet list.</span>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                  <div class="col-lg-6 col-lg-offset-2 table-responsive">
                    <h4>INGREDIENTS REQUEST</h4>
                    <table class="table table-bordered table-stripped table-hover" id="request_table">
                      <thead>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Unit Type</th>
                        <th>&nbsp;</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    <h5 id="info">No request list.</h5>
                  </div>
                </div>

                <hr>

                <div class="form-group">
                  <label class="col-lg-2 control-label">&nbsp;</label>

                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Submit Request</button>
                    </div>
                </div>

                 {{ Form::close() }}

              </div>
          </div>


        </div><!-- col-md-10 -->

    </div>
    <!-- end modal -->
@endsection

@section('after-scripts')

  <script type="text/javascript">
    var ingredients = {!! $ingredients !!};
    var requests    = [];
    var body        = $('#request_table tbody');

    getUnitType(1);

    $('#ingredient_list').on('change', function(){
      var ing       = $('#ingredient_list').val();
      
      getUnitType(ing);
    });

    $('form').on('submit', function(e)
      {
        createObject();

        $('#requests').val(JSON.stringify(requests));


        var requests_data = $('#requests').val();

        if(requests_data.length == 0)
        {
          e.preventDefault();
        }

      }
    );

    function createObject()
    {
      var rows = body.find('tr');

      for(var i = 0; i < rows.length; i++)
      {
        var cols = $(rows[i]).find('td');
        var id   = $(rows[i]).attr('id');
        var name = $(cols[0]).text();
        var qty  = $(cols[1]).text();
        var unit = $(cols[2]).text();

        requests.push({ id: id, name: name, quantity: qty, unit_type: unit });
      }
    }

    function addItem()
    {
      var tbody = '';
      var ing   = $('#ingredient_list').val();
      var qty   = $('#quantity').val();
      var unit  = $('#unit_type').val();

      $('#info').hide();

      if(!exist(ing))
      {
        tbody += '<tr id="' + ing + '">';
        tbody += '<td>' + ingredients[ing] + '</td>';
        tbody += '<td>' + qty + '</td>';
        tbody += '<td>' + unit + '</td>';
        tbody += '<td><button type="button" class="btn btn-xs btn-danger" onclick="remove(this)"><i class="fa fa-times"></i></button></td>';
        tbody += '</tr>';

        $('#warning').hide();
      }
      else
      {
        $('#warning').show();
      }

      body.append(tbody);
    }

    function exist(id)
    {
      var result = body.find('tr#'+id);
      if(result.length)
        return true;

      return false;
    }

    function remove(e)
    {
      $(e).closest('tr').remove();

      var result = body.find('tr');

      if(result.length == 0)
        $('#info').show();
    }

    function getUnitType(id)
    {
      $.ajax(
        {
          type: 'GET',
          url : '{{ URL::to("/request/unit_type") }}/' + id,
          success: function(data){
            $('#unit_type').val(data);
          }
        }
      );
    }

  </script>
  

@endsection