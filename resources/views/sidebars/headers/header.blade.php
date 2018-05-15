<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
      <link rel="mask-icon" href="{{ asset('img/j.svg') }}">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <style type="text/css">
            body,html,.row-offcanvas {
                height:100%;
            }

            body {
              padding-top: 57px;
            }

            #sidebar {
              width: inherit;
              min-width: 180px;
              max-width: 180px;
              background-color:#f5f5f5;
              float: left;
              height:100%;
              position:relative;
              overflow-y:auto;
              overflow-x:hidden;
            }
            #main {
              height:100%;
              overflow:auto;
            }

            /*
             * off Canvas sidebar
             * --------------------------------------------------
             */
            @media screen and (max-width: 768px) {
              .row-offcanvas {
                position: relative;
                -webkit-transition: all 0.25s ease-out;
                -moz-transition: all 0.25s ease-out;
                transition: all 0.25s ease-out;
                width:calc(100% + 220px);
              }
                
              .row-offcanvas-left
              {
                left: -220px;
              }

              .row-offcanvas-left.active {
                left: 0;
              }

              .sidebar-offcanvas {
                position: absolute;
                top: 0;
              }
            }
        </style>
    </head>
  <body>
    <div class="navbar navbar-light bg-light border-bottom fixed-top navbar-expand-md"> 
      <a class="navbar-brand" style="user-select: none">Plagiaadikontroll</a>
        <ul class="nav navbar-nav  mr-auto">
            <li class="nav-item {{ $headerActive == 1 ? 'active':'' }}">
                <a class="nav-link" href="/dashboard/juliaUsage">Dashboard</span></a>
            </li>
            <li class="nav-item {{ $headerActive == 2 ? 'active':'' }}">
                <a class="nav-link">Section</span></a>
            </li>
            <li class="nav-item {{ $headerActive == 3 ? 'active':'' }}">
                <a class="nav-link" href="">Section</span></a>
            </li>
            <li class="nav-item {{ $headerActive == 4 ? 'active':'' }}">
                <a class="nav-link" href="">Section</span></a>
            </li>
            @isset($admin)
            <li class="nav-item {{ $headerActive == 5 ? 'active':'' }}">
                <a class="nav-link" href="/adminPanel/allUsers">Admin Panel</span></a>
            </li>
            @endisset
        </ul>
        <a href="/logout" class="btn btn-outline-success " role="button">Logout</a>
    </div>
    <div class="row-offcanvas row-offcanvas-left">
        @yield('sidebarAndBody')
    </div>
  </body>
</html>
