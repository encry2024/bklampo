@extends ('backend.layouts.app')

@section ('title', 'POS Product Management | View')

@section('page-header')
    <h1>
        POS Product Management
        <small>View</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Product (<small>{{ $product->name }}</small>)</h3>

            <div class="box-tools pull-right">
                @include('backend.product.includes.partials.product-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">

            <div role="tabpanel">
                @if(count($product->product_size))
                @foreach($product->product_size as $product)
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>{{ strtoupper($product->size) }}</h4>
                            <h4>Price : {{ $product->price }} PHP</h4>
                            <h4>Cost : {{ $product->cost }} PHP</h4>

                            <table class="table table-responsive table-bordered">
                                <thead>
                                    <th>INGREDIENT</th>
                                    <th>QUANTITY/UNIT TYPE</th>
                                    <th>CATEGORY</th>
                                </thead>
                                <tbody>
                                    @foreach($product->ingredients as $ingredient)
                                    <tr>
                                        <td>
                                        <?php 
                                            if($ingredient->supplier == 'Commissary Product')
                                            {
                                                echo $ingredient->commissary_product->name;
                                            }
                                            elseif($ingredient->supplier == 'Commissary Raw Material')
                                            {
                                                echo $ingredient->commissary_inventory->name;
                                            }
                                            else
                                            {
                                                echo $ingredient->other->name;
                                            }
                                        ?>
                                        </td>
                                        <td>
                                        {{ 
                                            $ingredient->pivot->quantity.' '.
                                            $ingredient->unit_type.
                                            ($ingredient->pivot->quantity > 1 ? 's':'')
                                        }}
                                        </td>
                                        <td>{{ $ingredient->category->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                @endforeach
                @endif
            </div><!--tab panel-->

        </div><!-- /.box-body -->
    </div><!--box-->
@endsection