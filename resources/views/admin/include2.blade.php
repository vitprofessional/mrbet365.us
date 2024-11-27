@php
    $superAdmin     = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Super Admin'])->first();
    $financeAdmin   = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level One'])->first();
    $betAdmin       = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level Two'])->first();
    $name           = $admin->adminid;
    $mediaurl   = url('/');
    $mainurl    = $mediaurl;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>MRBet365 | Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="MrBet365.us. Your trusted partner" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/') }}admin/assets/images/favicon.png">
        <!-- DataTables -->
        <link href="{{ asset('/') }}admin/plugins/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <script src="{{ url('/') }}/assets/js/countries.js" type="text/javascript"> </script>
        <link href="{{ asset('/') }}admin/plugins/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ asset('/') }}admin/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 

        <!-- jvectormap -->
        <link href="{{ asset('/') }}admin/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
        <link href="{{ asset('/') }}admin/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('/') }}admin/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}admin/assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}admin/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}admin/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    	<script src="{{ asset('/') }}admin/plugins/rich-editor/ckeditor.js"></script>
    	<script src="{{ asset('/') }}admin/plugins/rich-editor/js/sample.js"></script>
          <!--sweet alert-->
          <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
          <script src="{{asset('/')}}admin/plugins/jquery/jquery.min.js"></script>
          <!--notify js cdn-->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        <style type="text/css">
            .bethistory-table,.bethistory-table td{
                font-size: 12px !important;
            }
            .notifyjs-cornner{
              z-index:10000!important;
            }
            th, td {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
        </style>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    </head>

    <body class="dark-sidenav">
        <!-- Left Sidenav -->
        <div class="row">
            <div class="col-2">
                <div class="left-sidenav">
                    <!-- LOGO -->
                    <div class="brand row">
                        <a href="{{ url('/') }}" target="_blank" class="logo col-10 mx-auto p-3">
                            <h2 class="fw-bold text-white">Mr.Bet365</h2>
                        </a>
                    </div>
                    <!--end logo-->
                    <div class="menu-content h-100" data-simplebar>
                        <ul class="metismenu left-sidenav-menu">
                            <li class="menu-label mt-0">Main</li>
                            <li>
                                <a href="{{ route('AdminHome') }}"> <i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span></a>
                            </li>
                            @if(count($superAdmin)>0)
                            <li>
                                <a href="{{ route('serverConfig') }}"> <i data-feather="settings" class="align-self-center menu-icon"></i><span>Settings</span></a>
                            </li>
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-users align-self-center menu-icon"></i><span>Users</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('searchUser') }}"><i class="ti-control-record"></i>Single User</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('activeUser') }}"><i class="ti-control-record"></i>Active User</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('bannedUser') }}"><i class="ti-control-record"></i>Banned User</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-user-tie align-self-center menu-icon"></i><span>Admin User</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newAdminProfile') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('manageAdmin') }}"><i class="ti-control-record"></i>Admin List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-university align-self-center menu-icon"></i><span>Bank Chanel</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newBankChanel') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('manageBankChanel') }}"><i class="ti-control-record"></i>Bank/Bkash List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-exclamation-triangle align-self-center menu-icon"></i><span>Reports</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="#"><i class="ti-control-record"></i>Admin Reports</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('customerReport') }}"><i class="ti-control-record"></i>Customer Reports</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Coin Manager</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('serverCoin') }}"><i class="ti-control-record"></i>Server Coin</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('adminCoin') }}"><i class="ti-control-record"></i>Admin Coin</a></li>
                                </ul>
                            </li> 
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Deposit Manage</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pendingDeposit') }}"><i class="ti-control-record"></i>Pending List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('paidDeposit') }}"><i class="ti-control-record"></i>Paid List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('unpaidDeposit') }}"><i class="ti-control-record"></i>Unpaid List</a></li>
                                </ul>
                            </li>
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Withdrawal Manage</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pendingWithdrawal') }}"><i class="ti-control-record"></i>Pending List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('processWithdrawRequest') }}"><i class="ti-control-record"></i>Processing List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('paidWithdrawal') }}"><i class="ti-control-record"></i>Paid List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('unpaidWithdrawal') }}"><i class="ti-control-record"></i>Unpaid List</a></li>
                                </ul>
                            </li>
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Club Withdraw</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubPendingWithdraw') }}"><i class="ti-control-record"></i>Pending List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubProcessWithdrawList') }}"><i class="ti-control-record"></i>Processing List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubPaidWithdraw') }}"><i class="ti-control-record"></i>Paid List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubUnpaidWithdraw') }}"><i class="ti-control-record"></i>Unpaid List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-camera align-self-center menu-icon"></i><span>Slider</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newSlider') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('sliderList') }}"><i class="ti-control-record"></i>Slider List</a></li>
                                </ul>
                            </li> 
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-list align-self-center menu-icon"></i><span>Category</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newCategory') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('categoryList') }}"><i class="ti-control-record"></i>Category List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-users-cog align-self-center menu-icon"></i><span>Team</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newTeam') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('teamList') }}"><i class="ti-control-record"></i>Team List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-building align-self-center menu-icon"></i><span>Club</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newClub') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubList') }}"><i class="ti-control-record"></i>Club List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-trophy align-self-center menu-icon"></i><span>Tournament</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newTournament') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('tournamentList') }}"><i class="ti-control-record"></i>Tournament List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-gamepad align-self-center menu-icon"></i><span>Match Manage</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newMatch') }}"><i class="ti-control-record"></i>Add New</a></li>
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
                                    <li class="nav-item"><a class="nav-link" href="{{ route('matchList',['catId'=>$cat->id]) }}"><i class="ti-control-record"></i>{{ $catname }}</a></li>
                                    @php
                                            endforeach;
                                        endif;
                                    @endphp
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fab fa-flipboard align-self-center menu-icon"></i><span>Bet Option</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newBetOption') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('betOptions') }}"><i class="ti-control-record"></i>Option List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('betAnswer') }}"><i class="ti-control-record"></i>Answer List</a></li>
                                </ul>
                            </li>
                        @elseif(count($financeAdmin)>0)
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-university align-self-center menu-icon"></i><span>Bank Chanel</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newBankChanel') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('manageBankChanel') }}"><i class="ti-control-record"></i>Bank/Bkash List</a></li>
                                </ul>
                            </li> 
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Deposit Manage</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pendingDeposit') }}"><i class="ti-control-record"></i>Pending List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('paidDeposit') }}"><i class="ti-control-record"></i>Paid List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('unpaidDeposit') }}"><i class="ti-control-record"></i>Unpaid List</a></li>
                                </ul>
                            </li>
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Withdrawal Manage</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pendingWithdrawal') }}"><i class="ti-control-record"></i>Pending List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('processWithdrawRequest') }}"><i class="ti-control-record"></i>Processing List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('paidWithdrawal') }}"><i class="ti-control-record"></i>Paid List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('unpaidWithdrawal') }}"><i class="ti-control-record"></i>Unpaid List</a></li>
                                </ul>
                            </li>
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-donate align-self-center menu-icon"></i><span>Club Withdraw</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubPendingWithdraw') }}"><i class="ti-control-record"></i>Pending List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubProcessWithdrawList') }}"><i class="ti-control-record"></i>Processing List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubPaidWithdraw') }}"><i class="ti-control-record"></i>Paid List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('clubUnpaidWithdraw') }}"><i class="ti-control-record"></i>Unpaid List</a></li>
                                </ul>
                            </li>
                        @elseif(count($betAdmin)>0)
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-camera align-self-center menu-icon"></i><span>Slider</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newSlider') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('sliderList') }}"><i class="ti-control-record"></i>Slider List</a></li>
                                </ul>
                            </li> 
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-list align-self-center menu-icon"></i><span>Category</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newCategory') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('categoryList') }}"><i class="ti-control-record"></i>Category List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-users-cog align-self-center menu-icon"></i><span>Team</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newTeam') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('teamList') }}"><i class="ti-control-record"></i>Team List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-trophy align-self-center menu-icon"></i><span>Tournament</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newTournament') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('tournamentList') }}"><i class="ti-control-record"></i>Tournament List</a></li>
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fas fa-gamepad align-self-center menu-icon"></i><span>Match Manage</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newMatch') }}"><i class="ti-control-record"></i>Add New</a></li>
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
                                    <li class="nav-item"><a class="nav-link" href="{{ route('matchList',['catId'=>$cat->id]) }}"><i class="ti-control-record"></i>{{ $catname }}</a></li>
                                    @php
                                            endforeach;
                                        endif;
                                    @endphp
                                </ul>
                            </li> 
            
                            <li>
                                <a href="javascript: void(0);"><i class="fab fa-flipboard align-self-center menu-icon"></i><span>Bet Option</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">  
                                    <li class="nav-item"><a class="nav-link" href="{{ route('newBetOption') }}"><i class="ti-control-record"></i>Add New</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('betOptions') }}"><i class="ti-control-record"></i>Option List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('betAnswer') }}"><i class="ti-control-record"></i>Answer List</a></li>
                                </ul>
                            </li>
                        @else
                            <li>No Permission</li>
                        @endif
                            
                            <hr class="hr-dashed hr-menu">
                            <li class="menu-label my-2">Mailing</li>
                            <li>
                                <a href="#"><i data-feather="message-circle" class="align-self-center menu-icon"></i><span>Mail Sending</span></a>
                            </li> 
            
                            <li>
                                <a href="#"><i data-feather="life-buoy" class="align-self-center menu-icon"></i><span>Callback/Support</span></a>
                            </li> 
                        </ul>
                    </div>
                </div>
                <!-- end left-sidenav-->
            </div>
            <div id="toogleClass" class="col-12 col-lg-10">
                    <div class="row sticky bg-white">   
                        <div class="col-12 text-end">
                            <nav class="navbar-custom">    
                                <ul class="list-unstyled topbar-nav float-end mb-0">  
                                @if(!empty($superAdmin) || !empty($financeAdmin))
                                    <li class="dropdown notification-list">
                                        <!-- Deposit request notification -->
                                        @php
                                            $deposit   = \App\Models\Deposit::where(['status'=>'Pending'])->get();
                                            $depositLimit = \App\Models\Deposit::where(['status'=>'Pending'])->limit(5)->get();
                                        @endphp
                                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i data-feather="credit-card"></i>
                                            <span class="badge bg-danger rounded-pill noti-icon-badge">{{ count($deposit) }}</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-276px, 54px);" data-popper-placement="bottom-end">
                                        
                                            <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                                Deposit Request <span class="badge bg-primary rounded-pill">{{ count($deposit) }}</span>
                                            </h6> 
                                            <div class="notification-menu" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                        @if(count($depositLimit)>0)
                                            @foreach($depositLimit as $dl)
                                            @php
                                                $depositor    = \App\Models\BetUser::find($dl->user);
                                            @endphp
                                                <!-- item-->
                                                <span class="dropdown-item py-3">
                                                    <div class="media">
                                                        <div class="avatar-md bg-soft-primary">
                                            <i data-feather="user"></i>
                                                        </div>
                                                        <div class="media-body align-self-center ms-2 text-truncate">
                                                            <h6 class="my-0 fw-normal text-dark">{{ $depositor->userid }} has a deposit request for</h6>
                                                            <small class="text-muted mb-0">amount of {{ $dl->amount }}</small>
                                        <small class="float-end text-muted ps-2">{{ $dl->created_at->diffForHumans() }}</small>
                                        <div class="text-start">
                                            <a href="{{ route('acceptDeposit',['id'=>$dl->id]) }}" class="btn btn-success btn-sm" onclick="return confirm('are you sure to accept this transaction?')"><i class="fas fa-check-square" title="Accept Deposit"></i></a> 
                                                                        <a href="{{ route('rejectDeposit',['id'=>$dl->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to reject this transaction?')"><i class="fas fa-window-close" title="Reject Deposit"></i></a>
                                        </div>
                                                        </div><!--end media-body-->
                                                    </div><!--end media-->
                                                </span><!--end-item-->
                                            @endforeach
                                        @else
                                                <span href="#" class="dropdown-item py-3">
                                                    <div class="media">
                                                        <div class="media-body align-self-center ms-2 text-truncate">
                                                    No deposit request found
                                                        </div><!--end media-body-->
                                                    </div><!--end media-->
                                                </span><!--end-item-->
                                        @endif
                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 340px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 142px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
                                            <!-- All-->
                                            <a href="{{ route('pendingDeposit') }}" class="dropdown-item text-center text-primary">
                                                View all <i class="fi-arrow-right"></i>
                                            </a>
                                        </div>
                                        
                                        <!-- Deposit request notification -->
                                        @php
                                            $withdrawal   = \App\Models\WithdrawalRequest::where(['status'=>'Pending'])->get();
                                            $withdrawalLimit = \App\Models\WithdrawalRequest::where(['status'=>'Pending'])->limit(5)->get();
                                        @endphp
                                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i data-feather="dollar-sign"></i>
                                            <span class="badge bg-danger rounded-pill noti-icon-badge">{{ count($withdrawal) }}</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-276px, 54px);" data-popper-placement="bottom-end">
                                        
                                            <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                                Withdrawal Request <span class="badge bg-primary rounded-pill">{{ count($withdrawal) }}</span>
                                            </h6> 
                                            <div class="notification-menu" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                        @if(count($withdrawalLimit)>0)
                                            @foreach($withdrawalLimit as $wl)
                                            @php
                                                $withdrawUser    = \App\Models\BetUser::find($wl->user);
                                            @endphp
                                                <!-- item-->
                                                <span href="#" class="dropdown-item py-3">
                                                    <div class="media">
                                                        <div class="avatar-md bg-soft-primary">
                                            <i data-feather="user"></i>
                                                        </div>
                                                        <div class="media-body align-self-center ms-2 text-truncate">
                                                            <h6 class="my-0 fw-normal text-dark">{{ $withdrawUser->userid }} has a withdrawal request for</h6>
                                                            <small class="text-muted mb-0">amount of {{ $wl->amount }}</small>
                                                            <small class="float-end text-muted ps-2">{{ $wl->created_at->diffForHumans() }}</small>
                                                        <div class="text-start">
                                                            <a href="{{ route('processingWithdrawal',['id'=>$wl->id]) }}" class="btn btn-warning btn-sm" onclick="return confirm('are you sure to update this transaction?')"><i class="fas fa-check-square" title="Sent to processing list"></i></a> 
                                                            <a href="{{ route('rejectWithdrawal',['id'=>$wl->id]) }}" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('are you sure to reject transaction?')"><i class="fas fa-window-close" title="Reject Transaction"></i></a>
                                                        </div>
                                                        </div><!--end media-body -->
                                                    </div><!--end media-->
                                                </span><!--end-item-->
                                            @endforeach
                                        @else
                                            <span class="dropdown-item py-3">
                                                    No withdrawal request found
                                            </span><!--end-item-->
                                        @endif
                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 340px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 142px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
                                            <!-- All-->
                                            <a href="{{ route('pendingWithdrawal') }}" class="dropdown-item text-center text-primary">
                                                View all <i class="fi-arrow-right"></i>
                                            </a>
                                        </div>
                                        
                                        <!-- Profile manage and logout -->
                                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="far fa-user-circle fs-3 my-3"></i> 
                                        </a>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs"></i> Profile</a>
                                            <a class="dropdown-item" href="{{ route('adminLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> Logout</a>
                                                <form id="logout-form" action="{{ route('adminLogout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                        </div>
                                    </li>
                                @elseif(!empty($betAdmin))
                                    <li class="dropdown notification-list">
                                        <!-- Profile manage and logout -->
                                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="far fa-user-circle fs-3 my-3"></i> 
                                        </a>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs"></i> Profile</a>
                                            <a class="dropdown-item" href="{{ route('adminLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> Logout</a>
                                                <form id="logout-form" action="{{ route('adminLogout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                        </div>
                                    </li>
                                @endif
                                </ul><!--end topbar-nav-->
                    
                                <ul class="list-unstyled topbar-nav mb-0">                        
                                    <li>
                                        <button onclick="changeClass()" class="nav-link button-menu-mobile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu align-self-center topbar-icon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                        </button>
                                    </li>  
                                    @if(!empty($superAdmin) || !empty($financeAdmin))
                                    <li class="mt-3 fw-bold">
                                        <i class="fab fa-google-wallet"></i> @if(!empty($superAdmin)) {{ $superAdmin->accountBalance }} @else {{ $financeAdmin->accountBalance }} @endif
                                    </li>
                                    @endif
                                </ul>
                            </nav>
                        </div><!--end topbar-nav-->
                    </div>
                    <div class="row align-items-center mt-2">
                        <!-- end navbar-->
                        <div class="col-12">
                            <!-- Page Content-->
                            <div class="page-content mb-4">
                                <div class="row my-3">
                                    <div class="col-10 mx-auto">
                                        @if(Session::get('success'))
                                          <div class="alert alert-success border-0">
                                            <span>{!! Session::get('success') !!}</span>
                                          </div>
                                        @endif
                                        @if(Session::get('error'))
                                          <div class="alert alert-danger border-0">
                                            <span>{!! Session::get('error') !!}</span>
                                          </div>
                                        @endif
                                    </div>
                                </div>
                                @yield('admincontent')
                            </div>
                            <!-- end page content -->
                        </div>
                    </div>
                    <!-- end page-wrapper -->
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <footer class="footer text-center">
                     <span class="text-muted d-none d-sm-inline-block float-end">&copy; <script>
                        document.write(new Date().getFullYear())
                    </script> MRBet365 <i
                            class="mdi mdi-heart text-danger"></i> by AK47</span>
                </footer><!--end footer-->
            </div>
        </div>
        
<script type="text/javascript">
    $(document).ready(function () {
        $('select').selectize({
            sortField: 'text'
        });
    });
    
    // alert disaper after seconds
    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").alert('close');
            });
        },5000);
    });
    
    
    function changeClass() {
        let cls = document.getElementById('toogleClass');
        cls.class = "col-12";
    }
	initSample();
    
    
    $(document).ready(function() {
        $('#datatable').DataTable( {
            "order": [[ 0, "desc" ]],
            "lengthMenu": [20, 60, 100, 200, 500],
            "pageLength": 20
        } );
    } );
    
	populateCountries("country5");
</script>


        <!-- jQuery  -->
        <script src="{{ asset('/') }}admin/assets/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/metismenu.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/waves.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/feather.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/simplebar.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/moment.js"></script>
        <script src="{{ asset('/') }}admin/plugins/daterangepicker/daterangepicker.js"></script>
        
        <!-- Required datatable js -->
        <script src="{{ asset('/') }}admin/plugins/select2/select2.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/dataTables.bootstrap5.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('/') }}admin/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/buttons.bootstrap5.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/jszip.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/pdfmake.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/vfs_fonts.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/buttons.html5.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/buttons.print.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('/') }}admin/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/pages/jquery.datatable.init.js"></script>

        <script src="{{ asset('/') }}admin/plugins/apex-charts/apexcharts.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="{{ asset('/') }}admin/plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
        <script src="{{ asset('/') }}admin/assets/pages/jquery.analytics_dashboard.init.js"></script>

        <!-- App js -->
        <script src="{{ asset('/') }}admin/assets/js/app.js"></script>
        
    </body>
</html>