@extends ('backend.layouts.app')

@section ('title', 'Commissary Daily Delivery Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
    {{ Html::style('/css/daterangepicker.css') }}

    <style type="text/css">
        table{
            font-size: 9pt;
        }
        th{
            width: 11.11%;
        }
        td{
            font-weight: bold;
        }
    </style>
@endsection

@section('page-header')
    <h1>Commissary Daily Delivery Report</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Report List</h3>

            <div class="box-tools pull-right">
                <div class="col-lg-2">
                    <button class="btn btn-warning btn-sm" onClick="$('#daily_log_table').tableExport({type:'excel',escape:'false'});"><i class="fa fa-bars"></i> Export Table Data</button>
                </div>
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="col-lg-12">
                {{ Form::open(['route' => 'admin.report.commissary.daily.delivery.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>From</label>
                            <input class="form-control" type="text" name="from" id="from" readonly required>                            
                        </div>

                        <div class="form-group col-lg-2">
                            <label>To</label>
                            <input class="form-control" type="text" name="to" id="to" readonly required>                            
                        </div>

                        <div class="form-group col-lg-2">
                            <label>&nbsp;</label>

                            <div class="input-group">
                                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                <span>
                                    <i class="fa fa-calendar"></i> Select Date
                                </span>
                                <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" style="margin-top: 25px"><i class="fa fa-calendar"></i> Search Date</button>
                        </div>
                    </div>

                {{ Form::close() }}  
            </div>
            

           <table class="table table-responsive table-bordered" id="daily_log_table">
                <thead>
                    <th colspan="10">Duration Date</th>
                </thead>
                <tbody>
                    <tr>
                        <td>ITEM</td>
                        <td>UNIT</td>
                        <td>MON</td>
                        <td>TUE</td>
                        <td>WED</td>
                        <td>THURS</td>
                        <td>FRI</td>
                        <td>SAT</td>
                        <td>SUN</td>
                        <td>TOTAL</td>
                    </tr>
                    @if(count($reports))
                        <?php $grand_total = 0;  ?>

                        @foreach($reports as $report)
                            @if(count($report->items))
                            <tr>
                                <td colspan="10" style="color:red">{{ $report->category }}</td>
                            </tr>

                            @foreach($report->items as $item)
                            <?php $subtotal = 0; ?>
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->mon))
                                        {
                                            $total = $item->days->mon->sum('quantity') * $item->days->mon->last()->price; 
                                        }

                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->tue))
                                        {
                                            $total = $item->days->tue->sum('quantity') * $item->days->tue->last()->price; 
                                        }
                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->wed))
                                        {
                                            $total = $item->days->wed->sum('quantity') * $item->days->wed->last()->price; 
                                        }
                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->thurs))
                                        {
                                            $total = $item->days->thurs->sum('quantity') * $item->days->thurs->last()->price; 
                                        }
                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->fri))
                                        {
                                            $total = $item->days->fri->sum('quantity') * $item->days->fri->last()->price; 
                                        }
                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->sat))
                                        {
                                            $total = $item->days->sat->sum('quantity') * $item->days->sat->last()->price; 
                                        }
                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        if(count($item->days->sun))
                                        {
                                            $total = $item->days->sun->sum('quantity') * $item->days->sun->last()->price; 
                                        }
                                        $subtotal = $subtotal + $total;
                                        $grand_total = $grand_total + $subtotal;

                                        echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            @endforeach

                            @endif
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>SUMMARY OF PURCHASE ORDER</b></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>Particular</td>
                        <td>Amount</td>
                    </tr>
                    @if(count($reports))
                        <?php $grand_total = 0 ?>

                        @foreach($reports as $report)
                            <?php 
                                $sub_total  = 0;
                                $date       = '';
                            ?>

                                <?php 

                                    if(count($report->items))
                                    {
                                        $amounts = [0,0,0,0,0,0,0];
                                        $dates   = [null,null,null,null,null,null,null];


                                        foreach($report->items as $item)
                                        {
                                            $temps  = [];
                                            $temps2 = [];

                                            $temps[0] = count($item->days->mon) ? $item->days->mon->sum('quantity') * $item->days->mon->last()->price : 0;
                                            $temps[1] = count($item->days->tue) ? $item->days->tue->sum('quantity') * $item->days->tue->last()->price : 0;
                                            $temps[2] = count($item->days->wed) ? $item->days->wed->sum('quantity') * $item->days->wed->last()->price : 0;
                                            $temps[3] = count($item->days->thurs) ? $item->days->thurs->sum('quantity') * $item->days->thurs->last()->price : 0;
                                            $temps[4] = count($item->days->fri) ? $item->days->fri->sum('quantity') * $item->days->fri->last()->price : 0;
                                            $temps[5] = count($item->days->sat) ? $item->days->sat->sum('quantity') * $item->days->sat->last()->price : 0;
                                            $temps[6] = count($item->days->sun) ? $item->days->sun->sum('quantity') * $item->days->sun->last()->price : 0;

                                            $temps2[0] = count($item->days->mon) ? $item->days->mon->first()->received : 'empty';
                                            $temps2[1] = count($item->days->tue) ? $item->days->tue->first()->received : 'empty';
                                            $temps2[2] = count($item->days->wed) ? $item->days->wed->first()->received : 'empty';
                                            $temps2[3] = count($item->days->thurs) ? $item->days->thurs->first()->received : 'empty';
                                            $temps2[4] = count($item->days->fri) ? $item->days->fri->first()->received : 'empty';
                                            $temps2[5] = count($item->days->sat) ? $item->days->sat->first()->received : 'empty';
                                            $temps2[6] = count($item->days->sun) ? $item->days->sun->first()->received : 'empty';

                                            for($i = 0; $i < count($temps); $i++)
                                            {
                                                $amounts[$i] = $amounts[$i] + $temps[$i];
                                            }

                                            for($i = 0; $i < count($temps2); $i++)
                                            {
                                                if($temps2[$i] != 'empty')
                                                {
                                                    $dates[$i] = $temps2[$i];
                                                }
                                            }
                                        }

                                        for($i = 0; $i < count($amounts); $i++)
                                        {
                                            if($amounts[$i] > 0)
                                            {
                                                echo '<tr>';
                                                echo '<td>'.$dates[$i].'</td>';
                                                echo '<td>'.$report->category.'</td>';
                                                echo '<td>'.number_format($amounts[$i], 2).'</td>';
                                                echo '</tr>';

                                                $grand_total = $grand_total + $amounts[$i];
                                            }
                                        }
                                    }

                                ?>

                        @endforeach

                        <tr>
                            <td></td>
                            <td><b>Grand Total Receipts:</b></td>
                            <td>{{ number_format($grand_total, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="10"></td>
                    </tr>
                    <tr>
                        <td colspan="2">Preferred By:</td>
                        <td>Acknowledge By:</td>
                    </tr>
                    <tr>
                        <td colspan="2">Date:</td>
                        <td>Date:</td>
                    </tr>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!--box-->


@endsection

@section('after-scripts')
    {{ Html::script('js/tableExport.js')}}
    {{ Html::script('js/jquery.base64.js')}}
    {{ Html::script('https://code.jquery.com/ui/1.11.3/jquery-ui.min.js') }}
    {{ Html::script('/js/moment.min.js') }}
    {{ Html::script('/js/daterangepicker.js') }}
    <script>
        $('#daterange-btn').daterangepicker(
            {
            ranges   : {
                'This Week'   : [moment().startOf('week'), moment().endOf('week')],
                'Last 2 Weeks': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
            },
            function (start, end) {
                $('#from').val(start.format('YYYY-MM-DD'));
                $('#to').val(end.format('YYYY-MM-DD'));

            }
        )
    </script>
@endsection
