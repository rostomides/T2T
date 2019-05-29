<nav class="bg-dark text-white">
    <div class="sidebar-sticky">
        <ul class="nav flex-column" id="sidebar">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('dashboard') }}">
            <span data-feather="home"></span>
            Dashboard <span class="sr-only">(current)</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manage_admin') }}">
            <span data-feather="shopping-cart"></span>
            Manage administrators
            </a>  
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('create_free_account') }}">
            <span data-feather="shopping-cart"></span>
                Create a free account
            </a>  
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('interviews') }}">
            <span data-feather="file"></span>
            Interviews  <span class="badge badge-primary">{{$interview_count}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('active_users') }}">
            <span data-feather="file"></span>
            Active users  <span class="badge badge-primary">{{$active_count}}</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('expired_users') }}">
            <span data-feather="file"></span>
            Membership expired  <span class="badge badge-primary">{{$expired_count}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin_banned_users') }}">
            <span data-feather="file"></span>
            Banned Users <span class="badge badge-primary">{{$banned_count}}</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin_new_flagged_users') }}">
            <span data-feather="file"></span>
                New flagged users 
                <span class="badge badge-primary">{{$new_flags}}</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin_flagged_users') }}">
            <span data-feather="file"></span>
                Flagged users                 
            </a>
        </li>

        
        


        {{-- <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="users"></span>
            Customers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="bar-chart-2"></span>
            Reports
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="layers"></span>
            Integrations
            </a>
        </li> --}}
        </ul>

        {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Saved reports</span>
        <a class="d-flex align-items-center text-muted" href="#">
            <span data-feather="plus-circle"></span>
        </a>
        </h6>
        <ul class="nav flex-column mb-2">
        <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="file-text"></span>
            Current month
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="file-text"></span>
            Last quarter
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="file-text"></span>
            Social engagement
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
            <span data-feather="file-text"></span>
            Year-end sale
            </a>
        </li>
        </ul> --}}
    </div>
</nav>
