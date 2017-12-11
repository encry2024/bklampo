@extends ('backend.layouts.app')

@section ('title', 'Commissary Daily Delivery Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}

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
                            <input class="form-control" type="text" name="from" id="from" readonly required value="{{ $from }}">                            
                        </div>

                        <div class="form-group col-lg-2">
                            <label>To</label>
                            <input class="form-control" type="text" name="to" id="to" readonly required value="{{ $to }}">                            
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
                        <?php 
                            $mon_total = 0;
                            $tue_total = 0;
                            $wed_total = 0;
                            $thu_total = 0;
                            $fri_total = 0;
                            $sat_total = 0;
                            $sun_total = 0;
                        ?>

                        @foreach($reports as $report)
                            <tr>
                                <td colspan="10" style="color:red">{{ $report->category }}</td>
                            </tr>
                            @if(count($report->items))
                            

                            @foreach($report->items as $item)

                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['mon']))
                                                {
                                                    $price = $day['mon']->last()->price;
                                                }

                                                $total = $total + (($day['mon']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $mon_total = $total;

                                        echo number_format($mon_total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['tue']))
                                                {
                                                    $price = $day['tue']->last()->price;
                                                }

                                                $total = $total + (($day['tue']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $tue_total = $total;

                                        echo number_format($tue_total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['wed']))
                                                {
                                                    $price = $day['wed']->last()->price;
                                                }

                                                $total = $total + (($day['wed']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $wed_total = $total;

                                        echo number_format($wed_total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['thurs']))
                                                {
                                                    $price = $day['thurs']->last()->price;
                                                }

                                                $total = $total + (($day['thurs']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $thu_total = $total;

                                        echo number_format($thu_total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['fri']))
                                                {
                                                    $price = $day['fri']->last()->price;
                                                }

                                                $total = $total + (($day['fri']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $fri_total = $total;

                                        echo number_format($fri_total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['sat']))
                                                {
                                                    $price = $day['sat']->last()->price;
                                                }

                                                $total = $total + (($day['sat']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $sat_total = $total;

                                        echo number_format($sat_total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $total = 0;

                                        foreach($item->days as $day)
                                        {  

                                            if(count($day))
                                            {
                                                $price = 0;

                                                if(count($day['sun']))
                                                {
                                                    $price = $day['sun']->last()->price;
                                                }

                                                $total = $total + (($day['sun']->sum('quantity')) * $price);
                                            }                                   
                                        }

                                        $sun_total = $sun_total + $total;

                                        echo number_format($total, 2);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        $grand_total = 0;
                                        $grand_total = ($mon_total + $tue_total + $wed_total + $thu_total + $fri_total + $sat_total + $sun_total);

                                        echo number_format($grand_total, 2);
                                    ?>
                                </td>
                                
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10">No record was found.</td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
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
                        <?php 
                            $grand_total = 0;
                            $index       = 0;
                            $byCategory  = [];

                            foreach($reports as $report)
                            {
                                $byCategory[$report->category] = ['amounts' => 0, 'dates' => '', 'category' => ''];
                            }

                            foreach($reports as $report)
                            {
                                $per_report = 0;
                                $date       = '';

                                if(count($report->items))
                                {
                                    foreach($report->items as $item)
                                    {
                                        if(count($item->days))
                                        {
                                            foreach($item->days as $days)
                                            {
                                                foreach($days as $day)
                                                {
                                                    $total_per_day  = 0;
                                                    $quantity       = 0;
                                                    $price          = 0;

                                                    if(count($day))
                                                    {
                                                        $price    = $day->last()->price;
                                                        $quantity = $day->sum('quantity');
                                                        $date     = $day->first()->date;
                                                    }

                                                    $total_per_day = $quantity * $price;

                                                    $per_report = $per_report + $total_per_day;
                                                }
                                            }
                                        }
                                    }
                                }

                                $byCategory[$report->category]['amounts']  = $byCategory[$report->category]['amounts'] + $per_report;
                                $byCategory[$report->category]['dates']    = $date;
                                $byCategory[$report->category]['category'] = $report->category;
                            }

                            foreach($byCategory as $category)
                            {
                                if($category['dates'] != '')
                                {
                                    echo '<tr>';
                                    echo '<td>'.$category['dates'].'</td>';
                                    echo '<td>'.$category['category'].'</td>';
                                    echo '<td>'.number_format($category['amounts'], 2).'</td>';
                                    echo '</tr>';

                                    $grand_total = $grand_total + $category['amounts'];
                                }
                                
                            }

                        ?>

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
@endsection
