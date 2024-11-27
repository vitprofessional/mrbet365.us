@php
    $superAdmin     = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Super Admin'])->first();
    $financeAdmin   = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level One'])->first();
    $betAdmin       = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level Two'])->first();
    if(!empty($superAdmin)):
        $name           = $superAdmin->adminid;
    elseif(!empty($financeAdmin)):
        $name           = $financeAdmin->adminid;
    elseif(!empty($betAdmin)):
        $name           = $betAdmin->adminid;
    else:
        $name           = "Annonimous";
    endif;
    $mediaurl   = url('/');
    $mainurl    = $mediaurl;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>MrBet365 - @yield('otikaTitle')</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/css/app.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/css/style.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href="{{ asset('/') }}otikaAdmin/assets/img/favicon.ico" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<style>
    .select2-container {
        display: block !important;
    }
</style>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            @if(!empty($superAdmin) || !empty($financeAdmin))
            <li class="mt-2">
                <div  class="fw-bold font-15"><i class="fab fa-google-wallet"></i> @if(!empty($superAdmin)) {{ $superAdmin->accountBalance }} @else {{ $financeAdmin->accountBalance }} @endif</div>
            </li>
            @endif
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
            
        @php
            $deposit   = \App\Models\Deposit::where(['status'=>'Pending'])->get();
            $depositLimit = \App\Models\Deposit::where(['status'=>'Pending'])->limit(5)->get();
        @endphp
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link message-toggle nav-link-lg"><i data-feather="slack"></i></i>
              <span class="badge headerBadge1 bg-success">
                {{ count($deposit) }} </span>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Deposit Request
                <div class="float-right">
                  <span class="text-success">{{ $deposit->sum('amount') }} BDT Total</span>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                @if(count($depositLimit)>0)
                    @foreach($depositLimit as $dp)
                    @php
                        $depositUser    = \App\Models\BetUser::find($dp->user);
                    @endphp
                    <b href="#" class="dropdown-item dropdown-item-unread"> <span class="dropdown-item-desc"> {{ $depositUser->userid }} has a deposit request of <small class="text-muted mb-0">amount of {{ $dp->amount }}</small> <span class="time">{{ $dp->created_at->diffForHumans() }}</span>
                      </span>
                      <div class="text-start">
                        <a href="{{ route('acceptDeposit',['id'=>$dp->id]) }}" class="btn btn-success btn-sm" onclick="return confirm('are you sure to accept this transaction?')"><i class="fas fa-check-square" title="Accept Deposit"></i></a> 
                        <a href="{{ route('rejectDeposit',['id'=>$dp->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to reject this transaction?')"><i class="fas fa-window-close" title="Reject Deposit"></i></a>
                       </div>
                    </b> 
                    @endforeach
                @else
                    <span class="dropdown-item py-3">
                            No deposit request found
                    </span><!--end-item-->
                @endif
              </div>
              <div class="dropdown-footer text-center">
                <a href="{{ route('pendingDeposit') }}">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
            @php
                $withdrawal   = \App\Models\WithdrawalRequest::where(['status'=>'Pending'])->get();
                $withdrawalLimit = \App\Models\WithdrawalRequest::where(['status'=>'Pending'])->limit(5)->get();
                $pendingWithdraw = \App\Models\WithdrawalRequest::where('status','Pending')->get()->sum('amount');
            @endphp
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link message-toggle nav-link-lg"><i data-feather="shopping-bag"></i></i>
              <span class="badge headerBadge1 bg-warning">
                {{ count($withdrawal) }} </span>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Withdrawal Request
                <div class="float-right">
                  <span class="col-orange">{{ $pendingWithdraw }} BDT Total</span>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                @if(count($withdrawalLimit)>0)
                    @foreach($withdrawalLimit as $wl)
                    @php
                        $withdrawUser    = \App\Models\BetUser::find($wl->user);
                    @endphp
                <b class="dropdown-item dropdown-item-unread"> 
                  <!--  <span-->
                  <!--  class="dropdown-item-icon bg-primary text-white"> <i class="fas fa-piggy-bank"></i>-->
                  <!--</span> -->
                  <span class="dropdown-item-desc"> {{ $withdrawUser->userid }} has a withdrawal request of <small class="text-muted mb-0">amount of {{ $wl->amount }}</small> <span class="time">{{ $wl->created_at->diffForHumans() }}</span>
                  </span>
                  <div class="text-start">
                    <a href="{{ route('processingWithdrawal',['id'=>$wl->id]) }}" class="btn btn-warning btn-sm" onclick="return confirm('are you sure to update this transaction?')"><i class="fas fa-check-square" title="Sent to processing list"></i></a> 
                    <a href="{{ route('rejectWithdrawal',['id'=>$wl->id]) }}" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('are you sure to reject transaction?')"><i class="fas fa-window-close" title="Reject Transaction"></i></a>
                   </div>
                </b> 
                    @endforeach
                @else
                    <span class="dropdown-item py-3">
                            No withdrawal request found
                    </span><!--end-item-->
                @endif
              </div>
              <div class="dropdown-footer text-center">
                <a href="{{ route('pendingWithdrawal') }}">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{ asset('/') }}otikaAdmin/assets/img/users/avatar.jpg"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello, {{ $name }}</div>
              <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> 
              @if(!empty($superAdmin))
              <a href="{{ route('serverConfig') }}" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              @endif
              <div class="dropdown-divider"></div>
              <a href="{{ route('adminLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
              <form id="logout-form" action="{{ route('adminLogout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </nav>
      <!--sidebar start from here-->
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('/') }}" target="_blank"> <img alt="image" src="{{ asset('/') }}otikaAdmin/assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">Mrbet365</span>
            </a>
          </div>
          <ul class="sidebar-menu mb-4">
            <li class="menu-header">Main</li>
            <li class="dropdown">
              <a href="{{ route('AdminHome') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="{{ url('/') }}" class="nav-link" target="_blank"><i class="fas fa-home"></i><span>Website</span></a>
            </li>
            <li class="menu-header">Important Menu</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  class="fas fa-gamepad"></i><span>Match Manage</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newMatch') }}">Add New</a></li>
                @php
                    $category   = \App\Models\Category::all();
                    if(count($category)>0):
                        foreach($category as $cat):
                        //Category details
                        $catData    = \App\Models\Category::find($cat->id);
                        if(count($cat)>0):
                            $catname  = $cat->name;
                        else:
                            $catname  = "-";
                        endif;
                @endphp
                <li><a class="nav-link" href="{{ route('matchList',['catId'=>$cat->id]) }}">{{ $catname }}</a></li>
                @php
                        endforeach;
                    endif;
                @endphp
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-trophy"></i><span>Tournament</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newTournament') }}">Add New</a></li>
                <li><a class="nav-link" href="{{ route('tournamentList') }}">Tournament List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-users"></i><span>Site User</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('searchUser') }}">Single User</a></li>
                <li><a class="nav-link" href="{{ route('activeUser') }}">Active User</a></li>
                <li><a class="nav-link" href="{{ route('bannedUser') }}">Banned User</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-wallet"></i><span>Deposit Request</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('pendingDeposit') }}">Pending List</a></li>
                <li><a class="nav-link" href="{{ route('paidDeposit') }}">Paid List</a></li>
                <li><a class="nav-link" href="{{ route('unpaidDeposit') }}">Unpaid List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-piggy-bank"></i><span>Cash Pickup</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('pendingWithdrawal') }}">Pending List</a></li>
                <li><a class="nav-link" href="{{ route('processWithdrawRequest') }}">Processing List</a></li>
                <li><a class="nav-link" href="{{ route('paidWithdrawal') }}">Paid List</a></li>
                <li><a class="nav-link" href="{{ route('unpaidWithdrawal') }}">Unpaid List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-university"></i><span>Club Cash Pickup</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('clubPendingWithdraw') }}">Pending List</a></li>
                <li><a class="nav-link" href="{{ route('clubProcessWithdrawList') }}">Processing List</a></li>
                <li><a class="nav-link" href="{{ route('clubPaidWithdraw') }}">Paid List</a></li>
                <li><a class="nav-link" href="{{ route('clubUnpaidWithdraw') }}">Unpaid List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-coins"></i><span>Coin Manager</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('serverCoin') }}">Server Coin</a></li>
                <li><a class="nav-link" href="{{ route('adminCoin') }}">Admin Coin</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fab fa-xbox"></i><span>Bet Option</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newBetOption') }}">New Option</a></li>
                <li><a class="nav-link" href="{{ route('betOptions') }}">Question List</a></li>
                <li><a class="nav-link" href="{{ route('betAnswer') }}">Answer List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-users-cog"></i><span>Team Management</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newTeam') }}">Add New</a></li>
                <li><a class="nav-link" href="{{ route('teamList') }}">Team List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-building"></i><span>Club Management</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newClub') }}">Add New</a></li>
                <li><a class="nav-link" href="{{ route('clubList') }}">Club List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-list-ul"></i><span>Category Management</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newCategory') }}">Add New</a></li>
                <li><a class="nav-link" href="{{ route('categoryList') }}">Category List</a></li>
              </ul>
            </li>
            <li class="menu-header">Others Menu</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-user-secret"></i><span>Admin Operator</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newAdminProfile') }}">New Operator</a></li>
                <li><a class="nav-link" href="{{ route('manageAdmin') }}">Operator List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fab fa-google-wallet"></i><span>Bkash Wallet</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newBankChanel') }}">New Wallet</a></li>
                <li><a class="nav-link" href="{{ route('manageBankChanel') }}">Wallet List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-rss-square"></i><span>Slider</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('newSlider') }}">Add New</a></li>
                <li><a class="nav-link" href="{{ route('sliderList') }}">Slider List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-receipt"></i><span>Site Reports</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="#">Admin Report</a></li>
                <li><a class="nav-link" href="{{ route('customerReport') }}">Wallet Report</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="{{ route('serverConfig') }}" class="nav-link"><i class="fas fa-cogs"></i><span>Settings</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link"><i class="fas fa-user-graduate"></i><span>Profile Management</span></a>
            </li>
            <li class="dropdown">
              <a href="{{ route('adminLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
                <form id="logout-form" action="{{ route('adminLogout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                </form>
            </li>
          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
          @yield('otikaContent')
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="{{ url('/') }}">Mrbet365.in</a></a>
        </div>
        <div class="footer-right font-weight-bold">
            Version 2.0 by AK47
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('/') }}otikaAdmin/assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/cleave-js/dist/cleave.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/select2/dist/js/select2.full.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('/') }}otikaAdmin/assets/js/page/forms-advanced-forms.js"></script>
  <!-- Template JS File -->
  <script src="{{ asset('/') }}otikaAdmin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('/') }}otikaAdmin/assets/js/custom.js"></script>
</body>
</html>