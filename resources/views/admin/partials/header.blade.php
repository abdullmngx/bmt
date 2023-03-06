<!doctype html>
<html lang="en">

<head>
<title>:: {{ env("APP_NAME") }} :: @yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="My Genie World">
<meta name="author" content="abdullmng">
<link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">

<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('assets1/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/vendor/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets1/vendor/charts-c3/plugin.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets1/vendor/sweetalert/sweetalert.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets1/vendor/summernote/dist/summernote.css') }}"/>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- MAIN Project CSS file -->
<link rel="stylesheet" href="{{ asset('assets1/css/main.css') }}">
@yield('datatablecss')
</head>
<body data-theme="light" class="font-nunito">
<div id="wrapper" class="theme-green">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="{{ asset('logo.png') }}" width="100" alt="Iconic"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <!-- Top navbar div start -->
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-brand">
                <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-bars"></i></button>
                <button type="button" class="btn-toggle-fullwidth"><i class="fa fa-bars"></i></button>
                <a href="/">{{ env('APP_NAME') }}</a>                
            </div>
            
            <div class="navbar-right">
                <form id="navbar-search" class="navbar-form search-form">
                    <input value="" class="form-control" placeholder="Search here..." type="text">
                    <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>                

                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            @if (auth('admin')->user())
                            <a href="/admin/logout" class="icon-menu"><i class="fa fa-power-off"></i></a>
                            @else
                            <a href="/users/logout" class="icon-menu"><i class="fa fa-power-off"></i></a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- main left menu -->
    <div id="left-sidebar" class="sidebar">
        <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-arrow-left"></i></button>
        <div class="sidebar-scroll">
            <div class="user-account">
                <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle user-photo" alt="User Profile Picture">
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="user-name"><strong>{{ auth()->user()->name }}</strong></a>
                </div>
                <hr>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="fa fa-cog"></i></a></li>             
            </ul>
                
            <!-- Tab panes -->
            <div class="tab-content padding-0">
                <div class="tab-pane active" id="menu">
                    <nav id="left-sidebar-nav" class="sidebar-nav">
                        <ul id="main-menu" class="metismenu li_animation_delay">
                            @if(auth('admin')->user())
                            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : "" }}">
                                <a href="{{ route('admin.dashboard') }}" class=""><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                            </li>
                            <li class="{{ request()->routeIs('admin.plans') ? 'active': '' }}">
                                <a href="/admin/manage-plans" class=""><i class="fa fa-diamond"></i><span>Manage Plans</span></a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users') ? 'active':'' }} {{ request()->routeIs('admin.team') ? 'active':''}} {{ request()->routeIs('admin.single_user') ? 'active':'' }}">
                                <a href="#users" class="has-arrow"><i class="fa fa-users"></i><span>Manage Users</span></a>
                                <ul>
                                    <li class="{{ request()->routeIs('admin.users') ? 'active':'' }} {{ request()->routeIs('admin.single_user') ? 'active':'' }}"><a href="/admin/manage-users">Users</a></li>
                                    <li><a href="/admin/manage-team">Team</a></li>
                                </ul>
                            </li>
                            <li class="{{ request()->routeIs('admin.deposits') ? 'active':'' }}">
                                <a href="/admin/deposits" class=""><i class="fa fa-money"></i><span>Deposits</span></a>
                            </li>
                            <li class="{{ request()->routeIs('admin.withdrawals') ? 'active':'' }}">
                                <a href="/admin/withdrawals" class=""><i class="fa fa-credit-card"></i><span>Withdrawals</span></a>
                            </li>
                            <li class="{{ request()->routeIs('admin.settings') ? 'active':'' }}">
                                <a href="/admin/settings" class=""><i class="fa fa-cog"></i><span>Site Settings</span></a>
                            </li>
                            <li class="{{ request()->routeIs('admin.promotions') ? 'active':'' }}">
                                <a href="/admin/promotions" class=""><i class="fa fa-envelope"></i><span>Promotions</span></a>
                            </li>
                            <li>
                                <a href="/admin/logout" class=""><i class="fa fa-sign-out"></i><span>Logout</span></a>
                            </li>
                            <!--<li>
                                <a href="#uiElements" class="has-arrow"><i class="fa fa-diamond"></i><span>UI Elements</span></a>
                                <ul>
                                    <li><a href="ui-typography.html">Typography</a></li>
                                    <li><a href="ui-tabs.html">Tabs</a></li>
                                    <li><a href="ui-buttons.html">Buttons</a></li>
                                    <li><a href="ui-bootstrap.html">Bootstrap UI</a></li>
                                    <li><a href="ui-icons.html">Icons</a></li>
                                    <li><a href="ui-notifications.html">Notifications</a></li>
                                    <li><a href="ui-colors.html">Colors</a></li>
                                    <li><a href="ui-dialogs.html">Dialogs</a></li>                                    
                                    <li><a href="ui-list-group.html">List Group</a></li>
                                    <li><a href="ui-media-object.html">Media Object</a></li>
                                    <li><a href="ui-modals.html">Modals</a></li>
                                    <li><a href="ui-nestable.html">Nestable</a></li>
                                    <li><a href="ui-progressbars.html">Progress Bars</a></li>
                                    <li><a href="ui-range-sliders.html">Range Sliders</a></li>
                                    <li><a href="ui-treeview.html">Treeview</a></li>
                                </ul>
                            </li>-->
                            @endif
                        </ul>
                    </nav>
                </div>
                
                <div class="tab-pane" id="setting">
                    <ul class="list-unstyled mt-3">
                        <li class="d-flex align-items-center mb-2">
                            <label class="toggle-switch theme-switch">
                                <input type="checkbox">
                                <span class="toggle-switch-slider"></span>
                            </label>
                            <span class="ml-3">Enable Dark Mode!</span>
                        </li>
                    </ul>                   
                </div>
                    
            </div>          
        </div>
    </div>

    <div id="main-content" style="background-image: url('{{ asset('bg.png') }}'); background-size: 100% 100%; background-repeat: no-repeat">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2 class="text-light">@yield('title')</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>