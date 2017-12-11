@extends('frontend.layouts.app')
@section('after-styles')

{{ Html::style('css/dashboard.css') }}

@endsection

@section('content')
    <div class="row">

        <div class="col-xs-12">

          
          <div class="panel panel-default">
              <div class="panel-heading">REQUEST <small>(View)</small></div>

              <div class="panel-body">
                 
                <div class="col-lg-12">

                  <h4>
                    {{ $request->title }}

                    @if(count($request->response))
                    <span class="pull-right">Request Status:
                      <label class="label label-{{ $request->response->status == 'Accept' ? 'success':'danger' }}"> {{ $request->response->status }}</label>
                    </span>
                    @endif
                  </h4>

                  <hr>
                  <br>
                  <p>{{ $request->message }}</p>
                  <br>
                  <br>

                  
                  <table class="table table-bordered table-stripped">
                    <thead>
                      <th>NAME</th>
                      <th>QUANTITY</th>
                      <th>UNIT TYPE</th>
                    </thead>
                    <tbody>
                      @if(count($request->request_details))
                        @foreach($request->request_details as $detail)
                          <tr>
                            <td>{{ $detail->ingredient->supplier =='Others' ? $detail->ingredient->other->name : $detail->ingredient->commissary->name  }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ $detail->unit_type }}</td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                  
                  </table>

                  <br>
                  <br>

                  <h5>Requested By: {{ $request->user->full_name }}</h5>
                  <h5>Date Requested: {{ $request->created_at->format('F d, Y') }}</h5>
                  <h5>Time Requested: {{ $request->created_at->format('h:i:s A') }}</h5>
                  <br>

                </div>

              </div>
          </div>


          <a href="{{ route('frontend.user.request.index') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>

          <br>
          <br>

        </div><!-- col-md-10 -->

    </div>
    <!-- end modal -->
@endsection
