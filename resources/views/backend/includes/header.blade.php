<header class="main-header">

    <a href="{{ route('frontend.index') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
           {{ substr(app_name(), 0, 1) }}
        </span>

        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            {{ app_name() }}
        </span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('labels.general.toggle_navigation') }}</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown notifications-menu" onclick='notifications()'>
                    <?php
                        $notifications = \App\Models\Notification\Notification::orderBy('date', 'desc')->take(5)->get();
                    ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-default" id="notification_head">
                            {{ count($notifications->where('status', 'new')) }}
                        </span>
                    </a>

                    <ul class="dropdown-menu" id="notification_menu">
                        @if(count($notifications))
                            @foreach($notifications as $notification)
                            <li class="header">
                                @if($notification->status == 'new')
                                <span class="label label-danger">New</span>
                                @else
                                <span class="label label-default">Read</span>
                                @endif
                                &nbsp;{{ $notification->description }}
                                <small class="pull-right">{{ $notification->date }}</small>
                            </li>
                            @endforeach
                        @else
                        <li class="header">
                            {{ trans_choice('strings.backend.general.you_have.notifications', 0) }}
                        </li>
                        @endif
                        <li class="footer">
                            {{ link_to(route("admin.notification.index"), trans('strings.backend.general.see_all.notifications')) }}
                        </li>
                    </ul>
                </li><!-- /.notifications-menu -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ access()->user()->picture }}" class="user-image" alt="User Avatar"/>
                        <span class="hidden-xs">{{ access()->user()->full_name }}</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ access()->user()->picture }}" class="img-circle" alt="User Avatar" />
                            <p>
                                {{ access()->user()->full_name }} - {{ implode(", ", access()->user()->roles->pluck('name')->toArray()) }}
                                <small>{{ trans('strings.backend.general.member_since') }} {{ access()->user()->created_at->format("m/d/Y") }}</small>
                            </p>
                        </li>

                        <li class="user-body">
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{!! route('frontend.index') !!}" class="btn btn-default btn-flat">
                                    <i class="fa fa-home"></i>
                                    {{ trans('navs.general.home') }}
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{!! route('frontend.auth.logout') !!}" class="btn btn-danger btn-flat">
                                    <i class="fa fa-sign-out"></i>
                                    {{ trans('navs.general.logout') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-custom-menu -->
    </nav>
</header>
