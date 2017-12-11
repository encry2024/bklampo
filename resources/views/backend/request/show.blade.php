@extends ('backend.layouts.app')

@section ('title', 'Request')

@section('page-header')
    <h1>Request <small>View</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>

            <div class="box-tools pull-right">
            
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-horizontal">
                <div class="form-group">
                    {{ Form::label('title', 'Title', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4">
                        {{ Form::text('title', $msg->title, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                    </div>

                    <div class="col-lg-4 col-lg-offset-2">
                        <h4>Request Status: 
                        @if(count($msg->response))
                            @if($msg->response->status == 'Accept')
                            <span class="label label-success">Accepted</span>
                            @else
                            <span class="label label-danger">Declined</span>
                            @endif
                        @else
                            <span class="label label-default">Pending</span>
                        @endif 
                        </h4>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('message', 'Message', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-9">
                        {{ Form::textarea('message', $msg->message, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '6']) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-2">
                        <h4>REQUEST INGREDIENTS</h4>                    
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>NAME</th>
                                <th>QUANTITY</th>
                                <th>UNIT TYPE</th>
                            </thead>
                            <tbody>
                            @if(count($msg->request_details))
                                @foreach($msg->request_details as $detail)
                                    <tr>
                                        <td>
                                            <?php
                                                if($detail->ingredient->supplier == 'Other')
                                                {
                                                    echo $detail->ingredient->other->name;
                                                }
                                                elseif($detail->ingredient->supplier == 'Commissary Product')
                                                {
                                                    echo $detail->ingredient->commissary_product->name;
                                                }
                                                else
                                                {
                                                    echo $detail->ingredient->commissary_inventory->name;
                                                }
                                            ?>
                                            </td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->unit_type }}</td>
                                    </tr>
                                @endforeach
                            @endif 
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('message', '&nbsp;', ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-4">
                        @if(count($msg->response) == 0)
                        <a href="{{ route('admin.request.edit', $msg->id) }}" class="btn btn-primary"><i class="fa fa-reply"></i> Create Response</a>
                        @endif
                    </div>
                </div>
            </div>
            
        </div><!-- /.box-body -->
    </div><!--box-->


@endsection
