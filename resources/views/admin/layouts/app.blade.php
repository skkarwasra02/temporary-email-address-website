<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script type="text/javascript">
        var activeSidebarLi = "{{ $data['active-sidebar-li'] }}";
    </script>
    @include('admin.assets.inc.head')
</head>
<body>
    <div id="" class="">
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar" class="">
                <div class="sidebar-header">
                    <h3>TSM Admin</h3>
                </div>

                <ul class="list-unstyled components">
                    <!--<p>Dummy Heading</p>-->
                    <!--
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="#">Home 1</a>
                            </li>
                            <li>
                                <a href="#">Home 2</a>
                            </li>
                            <li>
                                <a href="#">Home 3</a>
                            </li>
                        </ul>
                    </li>
                    -->
                    <li id="dashboard-li">
                        <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
                    </li>
                    <li id="domains-li">
                        <a href="{{ url('/admin/domains') }}">Domains</a>
                    </li>
                    <li id="mails-li">
                        <a href="{{ url('/admin/mails') }}">Mails</a>
                    </li>
                    <li id="accounts-li">
                        <a href="{{ url('/admin/accounts') }}">Accounts</a>
                    </li>
                    <li id="sent-mails-li">
                        <a href="{{ url('/admin/sentmails') }}">Sent Mails</a>
                    </li>
                    <li id="abuse-reports-li">
                        <a href="{{ url('/admin/abuse-reports') }}">Abuse Reports</a>
                    </li>
                    <li id="advertising-li">
                        <a href="{{ url('/admin/advertising') }}">Advertising</a>
                    </li>
                    <li id="support-li">
                        <a href="{{ url('/admin/support') }}">Support</a>
                    </li>
                    <li id="cron-jobs-li">
                        <a href="{{ url('/admin/cron-jobs') }}">Cron Jobs</a>
                    </li>
                    <li id="settings-li">
                        <a href="{{ url('/admin/settings') }}">Settings</a>
                    </li>
                    <li id="profile-li">
                        <a href="{{ url('/admin/profile') }}">Profile</a>
                    </li>
                </ul>

            </nav>
            <!-- Page Content -->
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn text-white">
                            <i class="fas fa-align-left"></i>
                        </button>
                    </div>
                    <ul class="ml-auto nav">
                        <li class="nav-item">
                            <a href="{{ url('/logout') }}" class="nav-link">LogOut</a>
                        </li>
                    </ul>
                </nav>
                <div class="page-content">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="row mx-auto">
                                <div class="alert alert-danger" style="margin-left:15px;margin-right:15px;">
                                    {{ $error }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
