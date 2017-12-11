@extends ('backend.layouts.app')

@section ('title', 'Branch')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>Branch</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Branch List</h3>

            <div class="box-tools pull-right">
                @include('backend.branch.includes.partials.branch-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive col-lg-12">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>NAME</th>
                        <th>ADDRESS</th>
                        <th>CONTACT</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
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
                ajax: '{!! route('admin.branch.get') !!}',
                columns: [
                    { data: 1 },
                    { data: 2 },
                    { data: 3 },
                    { data: 4 }
                ]
            });
        });
    </script>
@endsection
