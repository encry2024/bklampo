@extends('frontend.layouts.app')

@section('content')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">MONTHLY SALE FOR {{ strtoupper($date) }}</div>

                <div class="panel-body">

                    <h3><small>TOTAL SALE:</small> {{ number_format($orders->sum('payable'), 2) }}</h3>

                    <table class="table table-bordered">
                        <thead>
                            <th>TRANSACTION NO.</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <th>TOTAL</th>
                        </thead>
                        <tbody>
                            @if(count($orders))
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->transaction_no }}</td>
                                    <td>{{ $order->created_at->format('F d, Y') }}</td>
                                    <td>{{ $order->created_at->format('h:i A') }}</td>
                                    <td>{{ $order->payable }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=3>No record to display.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-xs-12 -->

    </div><!-- row -->
@endsection