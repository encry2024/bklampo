@extends ('backend.layouts.app')

@section ('title', 'Category')

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>Category</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Category List</h3>

            <div class="box-tools pull-right">
                @include('backend.category.includes.partials.category-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive col-lg-4">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>CATEGORY NAME</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($categories))
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td><?php echo $category->delete_button; ?></td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td>No Category</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->


@endsection