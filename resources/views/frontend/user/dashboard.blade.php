@extends('frontend.layouts.app')

@section('after-styles')

{{ Html::style('css/dashboard.css') }}

<style type="text/css">
    ul.list-group{
        list-style: none;
        padding: 0;
    }
    li.list-group-item a{
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
    }
</style>

@endsection

@section('content')
    <div class="row">

        <div class="col-xs-12">

            <div class="row">
                <div class="col-md-4 col-md-push-8">
                    <div class="panel panel-default">
                        
                        <div class="panel-heading">
                            <h5>Order List</h5>
                        </div><!--panel-heading-->

                        <div class="panel-body">
                            <input type="hidden" id="prod_id">
                            <input type="hidden" id="prod_name">
                            <input type="hidden" id="prod_price">
                            <input type="hidden" id="prod_size">
                            

                            <div class="row">
                                <div id="table-wrapper">
                                    <div id="table-scroll">
                                        <table class="table table-responsive" id="order_list">
                                            <thead>
                                                <th style="width:55%;text-align:left"><span class="text">ITEM</span></th>
                                                <th style="width:15%;text-align:left"><span class="text">QTY</span></th>
                                                <th style="width:30%;text-align:left"><span class="text">PRICE</span></th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-md-12">
                                <h4 class="col-md-8">TOTAL</h4>
                                <h4 class="col-md-4" id="total_amount">0.00</h4>
                            </div>

                            <div id="options">
                                <button class="btn btn-default" id="btn-clear">CLEAR</button>
                                <button class="btn btn-danger" id="btn-remove">REMOVE</button>
                                <button class="btn btn-success" id="btn-charge">CHARGE</button>
                            </div>

                        </div><!--panel-body-->

                    </div><!--panel-->
                </div><!--col-md-4-->

                <div class="col-md-8 col-md-pull-4">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>PRODUCT LIST</h4>
                                </div><!--panel-heading-->

                                <div class="panel-body">
                                    @if(count($products))
                                    @foreach($products as $product)

                                        <a class="product-box" id="{{ $product->id }}" data-code="{{ $product->code }}" onclick="product_click(this)">
                                            <div class="product-title">{{ $product->name }}</div>

                                            <div class="product-body">
                                                <img src="{{ url('img/product').'/'.$product->image }}">
                                            </div>
                                        </a>
                                        
                                    @endforeach
                                    @else
                                    <p>No Product.</p>
                                    @endif
                                </div><!--panel-body-->
                            </div><!--panel-->
                        </div><!--col-xs-12-->
                    </div><!--row-->
                </div>
            </div><!--row-->


        </div><!-- col-md-10 -->

    </div><!-- row -->

    <!-- Modal -->
    <div id="productModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="ingredient-title"></h4>
                </div>
                <div class="modal-body">
                    <table class="table" id="ingredient_list">
                        <thead>
                            <th>INGREDIENT NAME</th>
                            <th>STOCKS</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-8">
                            <h5>DRINK SIZE</h5>
                            <ul class="list-group col-lg-8" id="cup_sizes">
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="qty" value="1">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_addOrder">Add Order</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

    <!-- Modal -->
    <div id="saveModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="official_receipt" hidden>
                            <h5>OFFICIAL RECEIPT</h5>
                            <div id="printable">
                                <p>Transaction No: <span class="pull-right" id="transaction_no">#00000000</span></p>
                                <p>Date: <span class="pull-right">{{ date('m-d-Y') }}</span></p>
                                <p>Cashier: <span class="pull-right">{{ Auth::user()->name }}</span></p>
                                <hr>

                                <div style="min-height:150px">
                                    <table id="items">
                                        <thead>
                                            <th style="width:25%">Qty</th>
                                            <th>Item(s)</th>
                                            <th style="width:25%">Total</th>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                                <hr>
                                <p>Total Amount Due <span class="pull-right" id="print_total">0.00</span></p>
                                <p>Cash <span class="pull-right" id="print_cash">0.00</span></p>
                                <p>Change <span class="pull-right" id="print_change">0.00</span></p>
                            </div>
                        </div>

                        <div class="col-lg-12" id="payment">
                            <div class="form-group">
                                <label for="payable">Total Payable</label>
                                <input type="input" class="form-control" id="payable" value='0.00' readonly>
                            </div>
                            <div class="form-group">
                                <label for="cash">Cash</label>
                                <input type="input" class="form-control" id="cash" value='0.00' onkeyup="change()" onfocus="this.value = ''" onblur="isFocus()" pattern="[0-9]">
                            </div>
                            <div class="form-group">
                                <label for="change">Change</label>
                                <input type="input" class="form-control" id="change" value='0.00' readonly>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="notify" style="color:red" class="pull-left"></span>
                    <button type="button" class="btn btn-success" id="btn_submit">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
@endsection

@section('after-scripts')
    <script type="text/javascript">
        var order     = [];
        var order_list= [];
        var total_amt = 0;
        var flag      = false;

        function getIngredients(id){
            $.ajax({
                type: 'get',
                url : '{{ url("dashboard") }}/' + id + '/product',
                success: function(data){
                    console.log(data);
                    var hasNoStock  = 0;
                    var product     = data['product'];
                    var prod_sizes  = data['product_size'];
                    var body        = $('#ingredient_list tbody');

                    $(body).find('tr').remove();
                    $('#cup_sizes').find('li').remove();        

                    for(var i = 0; i < prod_sizes.length; i++){
                        var size        = prod_sizes[i]['size'];
                        var price       = prod_sizes[i]['price'];
                        var ingredients = prod_sizes[i]['ingredients'];
                        var size_list   =  '<li class="list-group-item" onclick="product_size(this)">';
                            size_list   += '<a href="#" data-size="' + size + '">' + size + '<span class="pull-right">';
                            size_list   += price;
                            size_list   += '</span></a></li>';


                        for(var j = 0; j < ingredients.length; j++){
                            var name     = '';
                            var stock    = ingredients[j]['stock'];
                            var crit     = ingredients[j]['reorder_level'];
                            var quantity = ingredients[j]['quanity'];

                            if(ingredients[j]['supplier'] == 'Other')
                            {
                                name = ingredients[j]['other']['name'];
                            }
                            else if(ingredients[j]['supplier'] == 'Commissary Product')
                            {
                                name = ingredients[j]['commissary_product']['name'];
                            }
                            else
                            {
                                name = ingredients[j]['commissary_inventory']['name'];
                            }

                            var row      =  '<tr' + (stock == 0 || crit > stock ? ' style="background:red;color:white"': '') + ' id="' + name + '">';
                                row      += '<td>' + name + '</td>';
                                row      += '<td>' + stock + '</td>';
                                row      += '</tr>';

                            if(stock == 0)
                                hasNoStock++;

                            var exist = $(body).find('tr#' + name);

                            //check for same ingredient name
                            if(exist.length == 0)
                                $(body).append(row);
                        }

                        $('#cup_sizes').append(size_list);
                        product_size($('#cup_sizes').find('li')[0]);
                    }

                    if(hasNoStock){
                        $('#btn_addOrder').attr('disabled', 'disabled');
                    } else {
                        $('#btn_addOrder').removeAttr('disabled');
                    }

                    
                    $('#productModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                },
                error: function(data){
                    console.log('error');
                }
            });
        }        

        function product_click(e){
            var id   = $(e).attr('id');
            var code = $(e).attr('data-code');
            var name = $(e).find('.product-title').text();
            
            order[0] = id;
            order[1] = code;

            $('#ingredient-title').html(code);
            getIngredients(id);
        }

        function product_size(e){
            $('li.list-group-item').removeClass('product-active');
            $(e).addClass('product-active');
        }

        $('a').on('dragstart', function(){
            return false;
        });

        $('#btn_addOrder').on('click', function(){
            var product = {};
            var html    = '';
            var code_sz = '';
            var qty     = '';

            order[2] = $('.product-active').find('span').text();
            order[3] = $('#qty').val();
            order[4] = $('.product-active').find('a').attr('data-size');
            
            product['id']   = order[0];
            product['code'] = order[1];
            product['price']= order[2];
            product['qty']  = order[3];
            product['size'] = order[4];

            //
            //append product to orderlist
            //
            order_list.push(product);
            
            //
            // check product size and increase price
           //
            if(product.size == 'Large' || product.size == 'Medium')
            {
                product.price   = (parseFloat(product.price)).toFixed(2);
                code_sz         = product.code  + ' ' + product.size;
                qty             = product.qty;

                product.price   = parseFloat(product.qty * product.price).toFixed(2);
            }
            else 
            {
                code_sz         = product.code;
                qty             = product.qty;
                product.price   = (product.qty * product.price).toFixed(2);
            }

            //
            // add table row
            //
            html  = '<tr data-id="' + product.id + '" data-size="' + product.size + '" onclick="toggleActive(this)">';
            html  = html + '<td>' + code_sz + '</td><td>' + qty + '</td><td>' + product.price + '</td></tr>';

            $('#total_amount').text(recompute());

            $('#qty').val(1);

            $('#order_list tbody').append(html);

            $('#productModal').modal('hide');
        });

        function removeItem(id, size){
            index = order_list.findIndex(x => x.id == id && x.size == size);

            if(index != -1){
                order_list.splice(index, 1);
                $('#total_amount').text(recompute());
                $('tr.selected').remove();
                swal("Removed!", "Item has been removed!", "success");
           }
        }

        function toggleActive(e){
            var has = $(e).hasClass('selected');
            
            if(has){
                $(e).removeClass('selected');
            } else {
                $(e).addClass('selected');
            }
        }

        $('#btn-remove').on('click', function(){
            if($('#order_list tbody tr.selected').length > 0)
            {
                // 
                // alert
                // 
                swal(
                    {
                      title: "Are you sure?",
                      text: "You want to remove item from order list?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Remove Item",
                      closeOnConfirm: false
                    },
                    function(){
                        var rows = $('tr.selected');

                        for(var i = 0; i < rows.length; i++)
                        {
                            var id   = parseInt($(rows[i]).attr('data-id'));
                            var size = $(rows[i]).attr('data-size');

                            removeItem(id, size);
                        }
                    }
                );
                // 
                // end alert
                // 
            }
        });

        $('#btn-clear').on('click', function(){
            if($('#order_list tbody tr').length > 0)
            {
                // 
                // alert
                // 
                swal(
                    {
                      title: "Are you sure?",
                      text: "You want to remove all item from order list?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Remove All",
                      closeOnConfirm: false
                    },
                    function(){
                        clearAll();
                        swal("Removed!", "All item has been removed!", "success");
                    }
                );
                // 
                // end alert
                // 
            }
        });

        $('#btn-charge').on('click', function() {
            $('#payable').val(recompute());

            if($('#order_list tbody tr').length > 0){
                $('#saveModal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                // $('#saveModal').find('.modal-dialog').css({'width': '80%','height':'80%'});
                // $('#saveModal').find('.modal-dialog').find('.modal-content').css('height','80%');
            }
            
        });

        $('#btn_submit').on('click', function(){
            var cash   = parseFloat($('#cash').val());
            var change = parseFloat($('#change').val());
            var payable= parseFloat($('#payable').val());

            if(cash >= payable)
            {
               $('#btn_submit').attr('readonly','');

                $.ajax({
                    url: '{{  url("sale/save") }}',
                    type: 'POST',
                    data: {
                        orders : JSON.stringify(order_list),
                        cash   : cash,
                        change : change,
                        payable: payable
                    },
                    success: function(data){
                        if(data[0] == 'success')
                        {
                            var list = '';
                            flag = true;
                            $('#notify').text('')
                            $('#items tbody').find('tr').remove();

                            for(var i = 0; i < order_list.length; i++)
                            {
                                var code = order_list[i]['code'];
                                var qty  = order_list[i]['qty'];
                                var price= order_list[i]['price'];
                                var size = order_list[i]['size'];
                                list     += '<tr>';

                                if(qty > 1)
                                {
                                    list += '<td>' + qty + '</td>';
                                    list += '<td>' + code + ' ' + (size == 'Small' ? '': size) + ' @ ' + (price / qty) + '</td>';
                                }
                                else
                                {
                                    list += '<td>' + qty + '</td>';
                                    list += '<td>' + code + ' ' + (size == 'Small' ? '': size) + '</td>';
                                }

                                list += '<td>' + price + '</td>';
                                list += '</tr>';
                            }


                            $('#transaction_no').text('#' + data[1]);
                            $('#print_total').text(parseInt(payable).toFixed(2));
                            $('#print_cash').text(parseInt(cash).toFixed(2));
                            $('#print_change').text(parseInt(change).toFixed(2));
                            $('#items tbody').append(list);
                            $('#payment').hide();
                            $('#official_receipt').show();
                            $('#btn_print').css('visibility', 'visible');
                            window.print();
                        }
                        else
                        {
                            swal('Order not save!','', 'error');
                            $('#btn_print').css('visibility', 'hidden');
                        }
                        $('#btn_submit').removeAttr('readonly');
                    },
                    error: function(data){
                        swal("Error Saving!", '', 'error');
                    }
                }); 
            } 
            else 
            {
                $('#notify').text('Input Cash Amount.')
            }//end statement            
        });

        

        $('#saveModal').on('hidden.bs.modal', function(){
            if(flag)
            {
                swal('Order has been saved!','', 'success');
                clearAll();
            }

            $('#payable').val('0.00');
            $('#cash').val('0.00');
            $('#change').val('0.00');
            $('#official_receipt').hide();
            $('#payment').show();
        });

        function recompute(){
            total_amt = 0;
            for(var i = 0; i < order_list.length; i++)
            {
                total_amt += parseFloat(order_list[i].price);
            }

            return total_amt.toFixed(2);
        }

        function clearAll(){
            flag = false;
            total_amt = 0;
            order_list.splice(0, order_list.length);
            $('#order_list tbody tr').remove();
            $('#total_amount').text('0.00');
            $('#customer_table').val('1');
        }

        function change(){
            var payable = recompute();
            var cash    = $('#cash').val();
            var change  = cash - payable;

            if(change < 0 || change == undefined || isNaN(change)){
                change = 0;
            }

            $('#change').val(change.toFixed(2));
        }

        function isFocus(){
            var cash = parseInt($('#cash').val());
            var val  = 0;

            if(cash > 0){
                val = cash;
            }

            $('#cash').val(val.toFixed(2));
        }
    </script>
@endsection