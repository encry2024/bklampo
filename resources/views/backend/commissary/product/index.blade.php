@extends ('backend.layouts.app')

@section ('title', 'Commissary Product Management')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>Commissary Product Management</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Product List</h3>

            <div class="box-tools pull-right">
                @include('backend.commissary.product.includes.partials.product-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>NAME</th>
                        <th>PRODUCE</th>
                        <th>PRICE</th>
                        <th>COST</th>
                        <th>CATEGORY</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->


    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            @if(count($histories))
                <ul class='timeline'>
                @foreach($histories as $history)
                <li>
                    <i class="fa {{ $history->status == 'Add' ? ' fa-plus bg-green' : 'fa-minus bg-red' }}"></i> 
                    <div class="timeline-item">
                        <span class="time">
                            <i class="fa fa-clock-o"></i>
                            {{ $history->created_at->format('h:i:s A') }}
                        </span>

                        <span class="time">
                            <i class="fa fa-calendar-o"></i>
                            {{ $history->created_at->format('F d, Y') }}
                        </span>
                        {{ $history->description }}
                    </div>
                </li>
                @endforeach
                </ul>
            @else
            <h5>No record to display.</h5>
            @endif
        </div><!-- /.box-body -->
    </div>

@endsection

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}

     <script>
        $(function() {
            $('#users-table').DataTable({
                dom: 'Blfrtip',
                processing: false,
                serverSide: true,
                ajax: '{!! route('admin.commissary.product.get') !!}',
                columns: [
                    { data: 1 },
                    { data: 2 },
                    { data: 3 },
                    { data: 4 },
                    { data: 6 },
                    { data: 7 }
                ],
                order: [1, 'asc']
            });
        });
    </script>
@endsection
