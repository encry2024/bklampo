@extends ('backend.layouts.app')

@section ('title', 'Report Sales | View')

@section('page-header')
    <h1>
        Report Sales
        <small>View</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Transaction Details</h3>
        </div><!-- /.box-header -->

        <div class="box-body">

            <h4><small>Transaction No:</small> {{ $order->transaction_no }}</h4>

            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <th>ITEM</th>
                        <th>QUANTITY/SIZE</th>
                        <th>TOTAL</th>
                    </thead>
                    <tbody>
                        @foreach($order->order_list as $list)
                        <tr>
                            <td>{{ $list->product->name }}</td>
                            <td>{{ $list->quantity.' '.$list->product_size->size }}</td>
                            <td>{{ $list->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4><small>Total Price: </small>{{ number_format($order->order_list->sum('price'), 2) }}</h4>
            </div>

        </div><!-- /.box-body -->        
    </div><!--box-->

    <div class="box-info box">
        <div class="box-body">
            <a href="{{ route('admin.report.pos.sale.index') }}" class="btn btn-warning">BACK</a>
        </div>
    </div>
   
@endsection