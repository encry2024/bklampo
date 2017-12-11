@extends ('backend.layouts.app')
@section ('title', 'Request')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>Request</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Request List</h3>

            <div class="box-tools pull-right">
            
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>TITLE</th>
                        <th>MESSAGE</th>
                        <th>DATE</th>
                        <th>TIME</th>
                        <th>FROM</th>
                        <th>STATUS</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->


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
                ajax: '{!! route('admin.request.get') !!}',
                columns: [
                    { data: 1 },
                    { data: 2 },
                    { data: 6 },
                    { data: 7 },
                    { data: 8 },
                    { data: 9 },
                    { data: 10 }
                ]
            });
        });
    </script>
@endsection
