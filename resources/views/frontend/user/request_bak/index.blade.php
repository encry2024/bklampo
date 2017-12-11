@extends('frontend.layouts.app')
@section('after-styles')

{{ Html::style('css/dashboard.css') }}

@endsection

@section('content')
    <div class="row">

        <div class="col-xs-12">

          
          <div class="panel panel-default">
              <div class="panel-heading">REQUEST LIST</div>

              <div class="panel-body">
                  <table class="table table-bordered">
                    <thead>
                      <th>TITLE</th>
                      <th>MESSAGE</th>
                      <th>DATE</th>
                      <th>TIME</th>
                      <th>&nbsp;</th>
                    </thead>
                    <tbody>
                      @if(count($requests))
                        @foreach($requests as $request)
                        <tr>
                          <td>{{ $request->title }}</td>
                          <td>{{ $request->message }}</td>
                          <td><i class="fa fa-calendar"></i> {{ $request->created_at->format('F d, Y') }}</td>
                          <td><i class="fa fa-clock-o"></i> {{ $request->created_at->format('h:i:s A') }}</td>
                          <td>
                            @if(count($request->response))
                            <a href="{{ route('frontend.user.request.show', $request) }}" class="btn-primary btn btn-xs"><i class="fa fa-eye"></i> View</a>
                            @else
                            <label class="label label-default">Pending</label>                         
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      @else
                      <tr>
                        <td colspan="4">No records in list</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
              </div>
          </div>


        </div><!-- col-md-10 -->

    </div>
    <!-- end modal -->
@endsection
