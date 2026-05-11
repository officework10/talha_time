<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Admin penal</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/lib/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/font-awesome/css/font-awesome.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/stylesheets/theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/stylesheets/premium.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <style>
        .dropdown-toggle:hover{
            background: #347d4f!important;
        }
      
        .btn{
            background: #347d4f!important;
            color: white!important;

        }
        .dashboard-menu nav{
            background: #347d4f!important;

            
        }
        .panel-heading{
            background: #347d4f!important;
            color: white!important;
        }
        .h2 , .h4{
            color: #347d4f!important;
        }

    </style>

</head>
<body class="theme-blue">
    <div class="navbar navbar-default" role="navigation" style="background: #3E9960">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="" href="index.html"><span class="navbar-brand" style="color:#fff"><span class="fa fa-paper-plane"></span> Admin Panel</span></a></div>
        <div class="navbar-collapse collapse" style="height: 1px;">
          <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                    <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span>
                    Admin <i class="fa fa-caret-down"></i>
                </a>

              <ul class="dropdown-menu">
                <li><a tabindex="-1" href="{{ url('admin/logout') }}">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
    </div>



    <div class="sidebar-nav">
    <ul>
        <li><a href="#" data-target=".dashboard-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-fw fa-dashboard"></i> Dashboard<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="dashboard-menu nav nav-list collapse in">
                {{-- <li ><a href="{{ url('admin') }}"><span class="fa fa-caret-right"></span> Dashboard</a></li> --}}
                <li class="{{ url('admin/calculators/')==url()->current()?'active':'' }}"><a href="{{ url('admin/calculators') }}/"><span class="fa fa-caret-right"></span> Calculators</a></li>
                <li class="{{ url('admin/posts/')==url()->current()?'active':'' }}"><a href="{{ url('admin/posts') }}/"><span class="fa fa-caret-right"></span> Posts</a></li>
                <li class="{{ url('admin/media/')==url()->current()?'active':'' }}"><a href="{{ url('admin/media') }}/"><span class="fa fa-caret-right"></span> Add Media</a></li>
                @if ($LoginUser['role']==1)
                    <li class="{{ url('admin/users/')==url()->current()?'active':'' }}"><a href="{{ url('admin/users') }}/"><span class="fa fa-caret-right"></span> Users</a></li>
                    <li class="{{ url('admin/categories/')==url()->current()?'active':'' }}"><a href="{{ url('admin/categories') }}/"><span class="fa fa-caret-right"></span> Categories</a></li>
                    <li class="{{ url('admin/sub-categories/')==url()->current()?'active':'' }}"><a href="{{ url('admin/sub-categories') }}/"><span class="fa fa-caret-right"></span> Sub Categories</a></li>
                @endif
            </ul>
        </li>
    </ul>
    </div>

    <div class="content">
        <?php if(isset($admin_error)): ?>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-<?php echo $alertType; ?>">
                    <?php echo $admin_error; ?>
                    <button data-dismiss="alert" class="close" type="button">×</button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        @section('admin')
        @show
    </div>

</div>



        </div>
    </div>


    <script src="{{ asset('assets/admin/lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

</body></html>
