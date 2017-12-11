@extends ('backend.layouts.app')

@section ('title', 'Request | Create Response')

@section('after-styles')
    {{ Html::style('https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css') }}
@endsection

@section('page-header')
    <h1>
       Request  <small>Create Response</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => ['admin.request.update', $msg], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'patch']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Create Response</h3>

                <div class="box-tools pull-right">

                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">                    
                    {{ Form::label('title', 'Request Title', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-4">
                        {{ Form::text('title', $msg->title, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                    </div>
                </div>         

                <div class="form-group">                    
                    {{ Form::label('name', 'Request Message', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-9">
                        {{ Form::textarea('name', $msg->message, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '6']) }}
                    </div>
                </div>    

                <hr>


                <div class="form-group">                    
                    {{ Form::label('response', 'Response Message', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-9">
                        {{ Form::textarea('response', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '6', 'autofocus' => 'autofocus']) }}
                    </div>
                </div> 

                <div class="form-group">                    
                    {{ Form::label('status', 'Status', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-4">
                        {{ Form::select('status', ['Accept' => 'Accept', 'Decline' => 'Decline'], null, ['class' => 'form-control']) }}
                    </div>
                </div> 
                
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.request.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit('Respond', ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection
