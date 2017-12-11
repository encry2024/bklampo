@extends ('backend.layouts.app')

@section ('title', 'Sales Report')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style('https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css') }}
@endsection

@section('page-header')
    <h1>Sales Report</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Report List</h3>

            <div class="box-tools pull-right">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>TRANSACTION NO</th>
                        <th>QUANTITY/SIZE</th>
                        <th>TOTAL PRICE</th>
                        <th>SOLD DATE</th>
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
    {{ Html::script("https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js") }}
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js") }}
    {{ Html::script("https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js")}}
    {{ Html::script("https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js") }}
    {{ Html::script("https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js") }}
    <script>
        $(function() {
            $('#users-table').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                processing: false,
                serverSide: false,
                ajax: '{!! route('admin.report.pos.sale.get') !!}',
                columns: [
                    { data: 1 },
                    { data: 3 },
                    { data: 4 },
                    { data: 2 },
                    { data: 5 }
                ],
                order: [1, 'asc']
            });
        });
    </script>
@endsection
