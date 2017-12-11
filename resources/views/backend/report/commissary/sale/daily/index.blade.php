@extends ('backend.layouts.app')

@section ('title', 'Commissary Daily Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>Commissary Daily Report</h1>
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
                {{ Form::open(['route' => 'admin.report.commissary.daily.sale.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label>From</label>
                            <input class="form-control" type="text" name="from" id="from" readonly required value="<?php echo $from ?>">                            
                        </div>

                        <div class="form-group col-lg-2">
                            <label>To</label>
                            <input class="form-control" type="text" name="to" id="to" readonly required value="<?php echo $to ?>">                            
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
                            <button class="btn btn-primary" type="submit" style="margin-top: 25px"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>

                {{ Form::close() }}  
            </div>

           <table class="table table-responsive table-bordered" id="daily_log_table">
                <thead>
                    <th></th>
                    <th colspan="9">Daily Sales Report - per store (DSR)</th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td colspan="9">DURATION DATE:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        @if(count($reports['fruit']))
                            @foreach($reports['fruit']->branches as $branch)
                            <td>{{ $branch->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @endforeach
                        @endif
                        <td rowspan="2">TOTAL SALES OF MON</td>
                        <td rowspan="2">TOTAL SALES OF TUE</td>
                        <td rowspan="2">TOTAL SALES OF WED</td>
                        <td rowspan="2">TOTAL SALES OF THU</td>
                        <td rowspan="2">GRAND TOTAL</td>
                    </tr>
                    <tr>
                        <td>ITEM</td>
                        @if(count($reports['fruit']))
                            @foreach($reports['fruit']->branches as $branch)
                            <td>MON</td>
                            <td>TUE</td>
                            <td>WED</td>
                            <td>THU</td>
                            <td>TOTAL</td>
                            @endforeach
                        @endif
                    </tr>

                    @if(count($reports))
                        @foreach($reports as $report)
                        <tr>
                            <td colspan="11" style="color:red">{{ $report->category }}</td>
                        </tr>
                            <?php 
                                $controller = app('App\Http\Controllers\Backend\Report\Commissary\Sale\ReportController');
                                $branches   = count($report->branches);
                                $ingredients= $branches > 0 ? count($report->branches[0]->items) : 0;

                                if($ingredients)
                                {
                                    for($i = 0; $i < $ingredients; $i++)
                                    {
                                        $mon    = 0;
                                        $tue    = 0;
                                        $wed    = 0;
                                        $thu    = 0;
                                        $total  = 0;

                                        echo '<tr>';
                                        echo '<td>'.$report->branches[0]->items[$i]->name.'</td>';

                                        for($j = 0; $j < $branches; $j++)
                                        {
                                            $days = $controller->getItem($reports, strtolower($report->category), $j, $i);

                                            $mon += $days->mon;
                                            $tue += $days->tue;
                                            $wed += $days->wed;
                                            $thu += $days->thu;
                                            $total += $days->total;

                                            echo '<td>'.$days->mon.'</td>';
                                            echo '<td>'.$days->tue.'</td>';
                                            echo '<td>'.$days->wed.'</td>';
                                            echo '<td>'.$days->thu.'</td>';
                                            echo '<td>'.$days->total.'</td>';
                                        }

                                        echo '<td>'.$mon.'</td>';
                                        echo '<td>'.$tue.'</td>';
                                        echo '<td>'.$wed.'</td>';
                                        echo '<td>'.$thu.'</td>';
                                        echo '<td>'.$total.'</td>';

                                        echo '</tr>';
                                    }
                                }

                                
                                
                            ?>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="11">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="7">Preferred By:</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="7">Date:</td>
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
    {{ Html::script('js/timepicker.js') }} 
    <script> 
        $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' }); 
        $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' }); 
    </script> 
@endsection