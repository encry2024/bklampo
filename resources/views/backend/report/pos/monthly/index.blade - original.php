@extends ('backend.layouts.app')

@section ('title', 'Monthly Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
    <style type="text/css">
        .maroon{
            color: #fff;
            background: rgb(118,0,0);
        }
        .text-center{
            text-align: center;
        }
    </style>
@endsection

@section('page-header')
    <h1>Monthly Report</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Report List For <b>{{ $filter_date }}</b></h3>

            <div class="box-tools pull-right">

            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-lg-10">
                    {{ Form::open(['route' => 'admin.report.pos.monthly.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                        <div class="form-group">
                            {{ Form::label('date', 'Date', ['class' => 'col-lg-1 control-label']) }}

                            <div class="col-lg-3">
                                {{ Form::text('date', date('Y-m-d'), ['class' => 'form-control date', 'maxlength' => '191', 
                                    'required' => 'required']) }}
                            </div><!--col-lg-10-->

                            <div class="col-lg-2">
                                {{ Form::submit('Get Record', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div><!--form control-->

                    {{ Form::close() }}  
                </div>
                
                <div class="col-lg-2">
                    <button class="btn btn-warning btn-sm" onClick="$('#Monthly_log_table').tableExport({type:'excel',escape:'false'});"><i class="fa fa-bars"></i> Export Table Data</button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="Monthly_log_table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th colspan="4" style="text-align: right">Branch</th>
                            <th colspan='10'></th>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th colspan="4" style="text-align: right">Barista</th>
                            <th colspan='10' style="text-align: right"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>&nbsp;</td>
                            @for($i = 0; $i <= 11; $i++)
                                <td>{{ $times[$i] }}</td>
                            @endfor
                        </tr>
                        @if(count($juices))
                        <tr>
                            <td colspan="15" class="maroon text-center">JUICE</td>
                        </tr>
                        <tr>
                            <td>Medium</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $juices[$i]->size->medium }}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td>Large</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $juices[$i]->size->large }}</td>
                            @endfor
                        </tr>
                        @endif

                        @if(count($lychee_juices))
                        <tr>
                            <td colspan="15" class="maroon text-center">LYCHEE JUICE</td>
                        </tr>
                        <tr>
                            <td>Medium</td>
                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $lychee_juices[$i]->size->medium }}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td>Large</td>
                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $lychee_juices[$i]->size->large }}</td>
                            @endfor
                        </tr>
                        @endif

                        <tr>
                            <td colspan="15" class="maroon text-center">SHAKES</td>
                        </tr>

                        <tr>
                            <td>Banana</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $banana[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $buko[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Carrot</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $carrot[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Corn</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $corn[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Cucumber</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $cucumber[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>G Manggo</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $manggo_green[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Lychee</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $lychee[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Manggo</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $manggo[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Melon</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $melon[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Pandan</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $pandan[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Avocado</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $avocado[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Strawberry</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $strawberry[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td colspan="15" class="maroon text-center">DESSERTS</td>
                        </tr>

                        <tr>
                            <td>BB Halo2x</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $halo2x[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Corn</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $buko_corn[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Lyc</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $buko_lyc[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Pdn</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $buko_pdn[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td colspan="15" class="maroon text-center">EXTRAS</td>
                        </tr>

                        <tr>
                            <td>Milk</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $milk[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Syrup</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $syrup[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Meat</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $buko_meat[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Fruit</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $fruit[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Fruit Premium</td>

                            @for($i = 0; $i <= 11; $i++)
                            <td>{{ $premium_fruit[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td colspan="15">&nbsp;</td>
                        </tr>

                        <!-- 

                                table second

                         -->
                         <tr>
                            <td>&nbsp;</td>
                            <td colspan="4" style="text-align: right">Branch</td>
                            <td colspan='10'></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4" style="text-align: right">Barista</td>
                            <td colspan='10' style="text-align: right"></td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                            @for($i = 12; $i <= 23; $i++)
                                <td>{{ $times[$i] }}</td>
                            @endfor
                        </tr>
                        @if(count($juices))
                        <tr>
                            <td colspan="15" class="maroon text-center">JUICE</td>
                        </tr>
                        <tr>
                            <td>Medium</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $juices[$i]->size->medium }}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td>Large</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $juices[$i]->size->large }}</td>
                            @endfor
                        </tr>
                        @endif

                        @if(count($lychee_juices))
                        <tr>
                            <td colspan="15" class="maroon text-center">LYCHEE JUICE</td>
                        </tr>
                        <tr>
                            <td>Medium</td>
                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $lychee_juices[$i]->size->medium }}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td>Large</td>
                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $lychee_juices[$i]->size->large }}</td>
                            @endfor
                        </tr>
                        @endif

                        <tr>
                            <td colspan="15" class="maroon text-center">SHAKES</td>
                        </tr>

                        <tr>
                            <td>Banana</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $banana[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $buko[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Carrot</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $carrot[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Corn</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $corn[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Cucumber</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $cucumber[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>G Manggo</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $manggo_green[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Lychee</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $lychee[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Manggo</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $manggo[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Melon</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $melon[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Pandan</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $pandan[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Avocado</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $avocado[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Strawberry</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $strawberry[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td colspan="15" class="maroon text-center">DESSERTS</td>
                        </tr>

                        <tr>
                            <td>BB Halo2x</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $halo2x[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Corn</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $buko_corn[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Lyc</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $buko_lyc[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td>Buko Pdn</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $buko_pdn[$i]->count }}</td>
                            @endfor
                        </tr>

                        <tr>
                            <td colspan="15" class="maroon text-center">EXTRAS</td>
                        </tr>

                        <tr>
                            <td>Milk</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $milk[$i]->count }}</td>
                            @endfor 
                        </tr>

                        <tr>
                            <td>Syrup</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $syrup[$i]->count }}</td>
                            @endfor 
                        </tr>

                        <tr>
                            <td>Buko Meat</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $buko_meat[$i]->count }}</td>
                            @endfor 
                        </tr>

                        <tr>
                            <td>Fruit</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $fruit[$i]->count }}</td>
                            @endfor 
                        </tr>

                        <tr>
                            <td>Fruit Premium</td>

                            @for($i = 12; $i <= 23; $i++)
                            <td>{{ $premium_fruit[$i]->count }}</td>
                            @endfor 
                        </tr>
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->


@endsection

@section('after-scripts')

{{ Html::script('js/tableExport.js')}}
{{ Html::script('js/jquery.base64.js')}}
{{ Html::script('https://code.jquery.com/ui/1.11.3/jquery-ui.min.js') }}
{{ Html::script('js/timepicker.js') }}

<script type="text/javascript">
    $('.date').datepicker({ 'dateFormat' : 'yy-mm-dd' });
    $('.time').timepicker({ 'timeFormat': 'HH:mm:ss' });
</script>
@endsection
