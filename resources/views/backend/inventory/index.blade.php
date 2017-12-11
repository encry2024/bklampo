@extends ('backend.layouts.app')

@section ('title', 'POS Inventory Management')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>POS Inventory Management</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Stock List</h3>

            <div class="box-tools pull-right">
                @include('backend.inventory.includes.partials.inventory-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>NAME</th>
                        <th>STOCKS</th>
                        <th>CRITICAL LEVEL</th>
                        <th>CATEGORY</th>
                        <th>SUPPLIER</th>
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
                ajax: '{!! route('admin.inventory.get') !!}',
                columns: [
                    { data: 8 },
                    { data: 9 },
                    { data: 3 },
                    { data: 7 },
                    { data: 5 },
                    { data: 10 }
                ],
                order: [1, 'asc']
            });
        });
    </script>
@endsection
