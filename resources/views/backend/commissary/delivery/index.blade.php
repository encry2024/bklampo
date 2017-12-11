@extends ('backend.layouts.app')

@section ('title', 'Commissary Delivery')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>Commissary Delivery</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Delivery List</h3>

            <div class="box-tools pull-right">
                @include('backend.commissary.delivery.includes.partials.delivery-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>ITEM</th>
                        <th>QUANTITY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                        <th>DATE</th>
                        <th>BRANCH</th>
                        <th>STATUS</th>
                        <th>TYPE</th>
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
                ajax: '{!! route('admin.commissary.delivery.get') !!}',
                columns: [
                    { data: 9 },
                    { data: 1 },
                    { data: 2 },
                    { data: 10 },
                    { data: 3 },
                    { data: 8 },
                    { data: 6 },
                    { data: 7 },
                    { data: 11}
                ],
                order: [5, 'asc']
            });
        });
    </script>
@endsection
