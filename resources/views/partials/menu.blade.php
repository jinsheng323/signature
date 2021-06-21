<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('contract_access')
                <li class="nav-item">
                    <a href="{{ route("admin.contract-s.index") }}" class="nav-link {{ request()->is('admin/contract-s') || request()->is('admin/contract-s/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-list nav-icon">

                        </i>
                        {{ trans('cruds.contract_.title') }}
                    </a>
                </li>
            @endcan
            @can('service_access')
                <li class="nav-item">
                    <a href="{{ route("admin.service-s.index") }}" class="nav-link {{ request()->is('admin/service-s') || request()->is('admin/service-s/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-list nav-icon">

                        </i>
                        {{ trans('cruds.service_.title') }}
                    </a>
                </li>
            @endcan
            @can('site_access')
                <li class="nav-item">
                    <a href="{{ route("admin.sites.index") }}" class="nav-link {{ request()->is('admin/sites') || request()->is('admin/sites/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon">

                        </i>
                        {{ trans('cruds.site.title') }}
                    </a>
                </li>
            @endcan
            @can('servicecost_access')
                <li class="nav-item">
                    <a href="{{ route("admin.servicecosts.index") }}" class="nav-link {{ request()->is('admin/servicecosts') || request()->is('admin/servicecosts/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon">

                        </i>
                        {{ trans('cruds.servicecost.title') }}
                    </a>
                </li>
            @endcan

            @can('job_create')
                <li class="nav-item">
                    <a href="{{ route("jobs.index") }}" class="nav-link {{ request()->is('jobs') || request()->is('jobs/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-arrow-circle-right nav-icon">

                        </i>
                        {{ trans('cruds.job.title') }}
                    </a>
                </li>
            @endcan


            <li class="nav-item">
                <a href="/" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
</div>
