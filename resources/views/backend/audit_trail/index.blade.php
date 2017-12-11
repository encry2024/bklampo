@extends ('backend.layouts.app')

@section ('title', 'Audit Trails')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>Audit Trails</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">List</h3>

            <div class="box-tools pull-right">
                @include('backend.stock.includes.partials.stock-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>USER</th>
                        <th>DESCRIPTION</th>
                        <th>DATE</th>
                        <th>TIME</th>
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
                serverSide: false,
                ajax: '{!! route('admin.audit_trail.get') !!}',
                columns: [
                    { data: 0 },
                    { data: 5 },
                    { data: 2 },
                    { data: 3 },
                    { data: 4 }
                ],
                order: [1, 'asc']
            });
        });
    </script>
@endsection
