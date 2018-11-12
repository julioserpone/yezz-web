<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/page/yezz-logo.png')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('message.online') }}</a>
                </div>
            </div>
        @endif


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ route('admin.home') }}"><i class='fa fa-home'></i> <span>{{ trans('message.home') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-comments'></i> <span>{{ trans('message.yezztalk') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="/ytcategories/view">{{ trans('message.category') }}</a></li>
                    <li><a href="/ytthemes/view">{{ trans('message.themes') }}</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-book'></i> <span>{{ trans('message.maintenance') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="/admin/faqs/view">{{ trans('message.faqs') }}</a></li>
                    <li><a href="{{ route('categories.index') }}">{{ trans('message.categories') }}</a></li>
                    <li><a href="{{ route('banners.index') }}">{{ trans('message.banners') }}</a></li>
                    <li><a href="{{ route('softwares.index') }}">{{ trans('message.softwares') }}</a></li>
                    <li><a href="/admin/journal">{{ trans('message.journal') }}</a></li>
                    <li><a href="/admin/products/view">{{ trans('message.products') }}</a></li>
                    <li><a href="/regions/view">{{ trans('message.region') }}</a></li>
                    <li><a href="/countries/view">{{ trans('message.countries') }}</a></li>
                    <li><a href="/admin/sellers">{{ trans('message.sellers') }}</a></li>
                    <li><a href="/admin/serviceproviders">{{ trans('message.service_providers') }}</a></li>
                    <li><a href="{{ route('users.index') }}">{{ trans('message.users') }}</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
