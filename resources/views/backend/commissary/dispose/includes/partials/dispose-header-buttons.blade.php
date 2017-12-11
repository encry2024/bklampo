<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.commissary.dispose.index', 'All Disposed Items', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.commissary.dispose.create', 'Dispose Item', [], ['class' => 'btn btn-success btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Dispose Item <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.commissary.dispose.index', 'All Disposed Items') }}</li>
            <li>{{ link_to_route('admin.commissary.dispose.create', 'Dispose Item') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>