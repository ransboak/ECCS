
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <div class="navbar-brand-box">
            <a href="{{route('dashboard')}}" class="logo">
                <img src="{{asset('assets/images/pbl-logo.svg')}}" alt="" style="width: 12rem">
            </a>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                {{-- @if (Auth::user()->role == 'manager')
                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect"><i class="mdi mdi-home-analytics"></i><span>Dashboard</span></a>
                </li>
                @endif --}}
                
                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect"><i class="mdi mdi-home-analytics"></i><span>Dashboard</span></a>
                </li>
                @if (Auth::user()->role !== 'admin')
                <li>
                    <a href="{{route('customers')}}" class="waves-effect"><i class="mdi mdi-account-multiple-outline"></i><span>Customers</span></a>
                </li>
                @endif

                @if(Auth::user()->role == 'manager')
                <li>
                    <a href="{{route('allCollections')}}" class="waves-effect"><i class="mdi mdi-wallet"></i><span>All Collections</span></a>
                </li>
                
                <li>
                    <a href="{{route('generalReport')}}" class="waves-effect"><i class="mdi mdi-file-document-box-check"></i><span>Report</span></a>
                </li>
                @endif
                {{-- @if (Auth::user()->role == 'manager' && Auth::user()->branch == '000')
                <li>
                    <a href="{{route('branchReport')}}" class="waves-effect"><i class="mdi mdi-file-document-box-check"></i><span>Branch Report</span></a>
                </li>
                @endif --}}
                
                @if (Auth::user()->role == 'operator' || Auth::user()->role == 'manager')
                <li>
                    <a href="{{route('customerRequest')}}" class="waves-effect"><i class="mdi mdi-checkbox-multiple-marked-outline"></i><span>Requests</span></a>
                </li>
                @endif
                
                @if(Auth::user()->role == 'admin')
                <li>
                    <a href="{{route('getUsers')}}" class="waves-effect"><i class="mdi mdi-account-key-outline"></i><span>Users</span></a>
                </li>
                @endif

                


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->