@extends ('backend.layouts.app')

@section ('title', 'Commissary Product Management | View')

@section('page-header')
    <h1>
        Commissary Product Management
        <small>View</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">PRODUCT<small>({{ $product->name }})</small></h3>

            <div class="box-tools pull-right">
                @include('backend.commissary.product.includes.partials.product-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">

            <div role="tabpanel">
                <div class="col-lg-6">
                    <table class="table table-bordered">
                        <thead>
                            <th>INGREDIENT NAME</th>
                            <th>QUANTITY</th>
                        </thead>
                        <tbody>
                            @if(count($product))
                                @foreach($product->ingredients as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $ingredient->pivot->quantity }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>                
            </div><!--tab panel-->

        </div><!-- /.box-body -->
    </div><!--box-->
@endsection