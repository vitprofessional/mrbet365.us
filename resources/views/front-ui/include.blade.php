@php
    $details    = \App\Models\BetUser::find(Session::get('betuser'));
    $clubDetails    = \App\Models\BettingClub::find(Session::get('BettingClub'));
@endphp
<html>
<head>
        <meta charset="utf-8" />
        <title>Mr.Bet365 | @yield('uititle')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.png">
        <!-- DataTables -->
        <link href="{{ asset('/') }}admin/plugins/datatables/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <script src="{{ url('/') }}/assets/js/countries.js" type="text/javascript"> </script>
        <link href="{{ asset('/') }}admin/plugins/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ asset('/') }}admin/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
        <!-- App css -->
        <link href="{{ asset('/') }}admin/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script src="{{ url('/') }}/assets/js/countries.js" type="text/javascript"> </script>
        <link href="{{ url('/') }}/assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="adm-assets/css/customstyle.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            @media only screen and (max-width: 600px) {
              #dataTable {
                font-size: 10px;
              }
            }
            #dataTable {
                color: #000;
                font-weight:bold;
            }
            #datatable_previous, #datatable_next {
                padding: 7px 15px;
                background: #000!important;
                boder: 4px;
                /* border: 6px; */
                color: #fff!important;
            }
            .paginate_button{
                cursor:pointer;
                padding:.5rem;
            }
            .current{
                background:#0000ff;
                color:#fff;
                margin-left:.5rem;
            }
        </style>
    </head>

    <body class="" oncontextmenu="return false;">
    <!--<body class="">-->
        <div class="sticky shadow">
            <div class="bg-dark">
                <div class="container-fluid p-3">
                    <div class="d-none d-lg-block">
                        <div class="row align-items-center">
                            <div class="col-8 col-md-2 mx-auto text-center text-md-start text-white fw-bold rounded" style="font-size:1.3rem;"><a href="{{ url('/') }}" class="text-white"><img class="img-fluid" src="{{ asset('/') }}assets/images/mrbetlogo.png" alt="MrBet365"></a></div>
                            <div class="col-12 col-md-9 mx-auto text-center text-md-end top-bar">
                                @if(!empty($details) && count((array)$details)>0)
                                <a href="#" class="text-white"><i class="fas fa-paper-plane"></i> Messages</a>
                                <a href="{{ route('userdash') }}" class="text-white"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                <a href="{{ route('userlogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                <form id="logout-form" action="{{ route('userlogout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                @elseif(!empty($clubDetails) && count((array)$clubDetails)>0)
                                    <a href="{{ route('clubHome') }}" class="text-white"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                    <a href="{{ route('clubLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('clubLogout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                @else
                                <a href="{{ route('userLogin') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</a>
                                <a href="{{ route('userRegister') }}" class="btn btn-primary"><i class="fas fa-users"></i> Register</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-block d-lg-none mobile-bar sticky">
                        <div class="row align-items-center text-center">
                            <div class="col-2 text-start">
                                <button class="navbar-toggler rounded-0 border border-white px-3 py-2 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            <div class="col-3 text-start">
                                <div class="text-white fw-bold rounded" style="font-size:1.3rem;"><a href="{{ url('/') }}" class="text-white"><img class="img-fluid" src="{{ asset('/') }}assets/images/mrbetmobilelogo.png" alt="MrBet365"></a></div>
                            </div>
                            <div class="col-7 text-end mx-auto">
                                @if(!empty($details) && count((array)$details)>0)
                                <a href="{{ route('userprofile') }}" class="text-white fw-bold h4"><i class="fas fa-user-circle"></i> @if(empty($details->fullname)) {{ $details->userid }} @else {{ $details->fullname }} @endif</a>
                                    <span class="h4 fw-bold text-white"><i class="fas fa-donate"></i> <b id='userBalanceMT'>{{ number_format($details->balance,2) }}</b></span>
                                @elseif(!empty($clubDetails) && count((array)$clubDetails)>0)
                                <a href="{{ route('clubSettings') }}" class="text-white fw-bold h4"><i class="fas fa-user-circle"></i> @if(empty($clubDetails->fullname)) {{ $clubDetails->clubid }} @else {{ $clubDetails->fullname }} @endif</a>
                                    <span class="h4 fw-bold text-white"><i class="fas fa-donate"></i> {{ number_format($clubDetails->balance,2) }}</span>
                                @else
                                <a href="{{ route('userLogin') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</a>
                                <a href="{{ route('userRegister') }}" class="btn btn-primary"><i class="fas fa-users"></i> Register</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light bet-navbar shadow d-none d-lg-block">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12 mx-auto text-center text-md-end top-bar">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">
                                <div class="container-fluid row align-items-center">
                                    <div class="collapse navbar-collapse col-4 col-lg-8" id="navbarNavDropdown">
                                        <ul class="navbar-nav custom-menu">
                                            <li class="nav-item">
                                                <a class="nav-link onfocus" aria-current="page" href="{{ url('/') }}">Home</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('advanceBet') }}">Advance Bet</a>
                                            </li>
                                    @if(!empty($details) && count((array)$details)>0))
                                            <li class="nav-item dropdown">
                                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Account Activity
                                              </a>
                                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="{{ route('userprofile') }}">Profile</a></li>
                                                <li><a class="dropdown-item" href="{{ route('myFollowerList') }}">My Follower</a></li>
                                                <li><a class="dropdown-item" href="{{ route('betHistory') }}">Bet History</a></li>
                                                <li><a class="dropdown-item" href="{{ route('customerAccountStmt') }}">Statement</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            My Wallet
                                          </a>
                                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="{{ route('makeDeposit') }}">Make Deposit</a></li>
                                                <li><a class="dropdown-item" href="{{ route('depositHistory') }}">Deposit History</a></li>
                                                <li><a class="dropdown-item" href="{{ route('makeWithdraw') }}">Make Withdraw</a></li>
                                                <li><a class="dropdown-item" href="{{ route('withdrawHistory') }}">Withdraw History</a></li>
                                                <li><a class="dropdown-item" href="{{ route('makeC2CTransfer') }}">Coin Transfer</a></li>
                                                <li><a class="dropdown-item" href="{{ route('C2CTransferHistory') }}">Coin Transfer History</a></li>
                                                <li><a class="dropdown-item" href="{{ route('C2CReceivingHistory') }}">Coin Received History</a></li>
                                            </ul>
                                        </li>
                                    @elseif(!empty($clubDetails) && count((array)$clubDetails)>0))
                                            <li class="nav-item dropdown">
                                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Club Activity
                                              </a>
                                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="{{ route('clubSettings') }}">Settings</a></li>
                                                <li><a class="dropdown-item" href="{{ route('clubFollower',['clubid'=>$clubDetails->clubid]) }}">Follower List</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Club Wallet
                                          </a>
                                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="{{ route('makeClubWithdraw') }}">Make Withdraw</a></li>
                                                <li><a class="dropdown-item" href="{{ route('clubWithdrawHistory',['club'=>$clubDetails->id]) }}">Withdraw History</a></li>
                                                <li><a class="dropdown-item" href="{{ route('clubStatement',['club'=>$clubDetails->id]) }}">Statement</a></li>
                                            </ul>
                                        </li>
                                    @endif
                                    </div>
                                    @if(!empty($details) && count((array)$details)>0))
                                    <div class="col-8 col-lg-4 text-end">
                                        <ul class="navbar-nav">
                                            <li class="nav-item h3">
                                                <span class="nav-link"><i class="fas fa-user-circle"></i> @if(empty($details->fullname)) {{ $details->userid }} @else {{ $details->fullname }} @endif</span>
                                            </li>
                                            <li class="nav-item h3">
                                                <a class="nav-link" href="{{ route('makeDeposit') }}"><span class="btn btn-dark fw-bold"><i class="fab fa-google-wallet"></i> Deposit</span></a>
                                            </li>
                                            <li class="nav-item h3">
                                                <div class="nav-link">
                                                    <span class="coincolor"><i class="fas fa-donate"></i> <b id='userBalanceDT'>{{ number_format($details->balance,2) }}</b></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @elseif(!empty($clubDetails) && count((array)$clubDetails)>0))
                                    <div class="col-8 col-md-4 text-end">
                                        <ul class="navbar-nav text-uppercase">
                                            <li class="nav-item h3">
                                                <span class="nav-link text-capitalize"><i class="fas fa-building"></i> @if(empty($clubDetails->fullname)) {{ $clubDetails->clubid }} @else {{ $clubDetails->fullname }} @endif</span>
                                            </li>
                                            <li class="nav-item h3">
                                                <a class="nav-link" href="{{ route('makeClubWithdraw') }}"><span class="btn btn-dark fw-bold"><i class="fab fa-google-wallet"></i> Make Withdraw</span></a>
                                            </li>
                                            <li class="nav-item h3">
                                                <div class="nav-link">
                                                    <span class="coincolor"><i class="fas fa-donate"></i>  {{ number_format($clubDetails->balance,2) }}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offcanvas -->
        <div class="offcanvas offcanvas-start w-75" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header bg-dark p-3">
                <div class="d-block d-lg-none">
                    <div class="row align-items-center text-center mobile-bar">
                        <div class="col-12 top-bar mb-4">
                            <div class="row">
                                <div class="col-11 mx-autotext-white fw-bold rounded" style="font-size:1.3rem;"><a href="{{ url('/') }}" class="text-white">MrBet365</a>
                                </div>
                                <div class="col-1 mx-auto">
                                    <button type="button" class="btn-close text-reset text-white fw-bold" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        @if(!empty($details) && count((array)$details)>0))
                        <div class="col-12 mx-auto text-center">
                            <a href="{{ route('userprofile') }}" class="text-white fw-bold h4 px-2"><i class="fas fa-user-circle"></i> @if(empty($details->fullname)) {{ $details->userid }} @else {{ $details->fullname }} @endif</a>
                            <a class="text-white fw-bold h4 px-2" href="{{ route('makeDeposit') }}"><span class="btn btn-primary fw-bold"><i class="fab fa-google-wallet"></i> Deposit</span></a>
                            <span class="text-white fw-bold h4 px-2"><i class="fas fa-donate"></i> <b id='userBalanceDesktop'>{{ number_format($details->balance,2) }}</b></span>
                        </div>
                        @elseif(!empty($clubDetails) && count((array)$clubDetails)>0))
                        <div class="col-12 mx-auto text-center">
                            <a href="{{ route('userprofile') }}" class="text-white fw-bold h4 px-2"><i class="fas fa-user-circle"></i> @if(empty($clubDetails->fullname)) {{ $clubDetails->userid }} @else {{ $clubDetails->fullname }} @endif</a>
                            <span class="text-white fw-bold h4 px-2"><i class="fas fa-donate"></i> {{ number_format($clubDetails->balance,2) }}</span>
                        </div>
                        @else
                        <form class="form row" action="{{ route('confirmLogin') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="col-5">
                                <input type="text" class="form-control border border-dark" name="userId" placeholder="username">
                            </div>
                            <div class="col-5">
                                <input type="password" class="form-control border border-dark" name="loginPass" placeholder="password">
                            </div>
                            <div class="col-2 d-grid gap-2">
                                <input type="submit" class="btn btn-success btn-lg" value="Login" />
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="py-0">
                <ul class="list-group rounded-0">
                    @if(!empty($details) && count((array)$details)>0)
                    <li><a href="{{ url('/') }}" class="list-group-item"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="{{ route('advanceBet') }}" class="list-group-item"><i class="fas fa-bullhorn"></i> Advance Bet</a></li>
                    <div class="accordion accordion-flush" id="userMenuCollapse">
                        <div class="accordion-item sidenav">
                            <div class="accordion-header m-0" id="profileMenuHeading">
                                <button class="dropdown-btn fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profileMenu" aria-expanded="false" aria-controls="profileMenu">
                                    <i class="fas fa-user-secret"></i> Profile <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                            <div id="profileMenu" class="accordion-collapse collapse" aria-labelledby="profileMenuHeading" data-bs-parent="#userMenuCollapse" style="">
                                <div class="accordion-body dropdown-container pt-0">
                                    <a href="{{ route('userprofile') }}">View Profile</a>
                                    <a href="{{ route('betHistory') }}">Betting History</a>
                                    <a href="{{ route('myFollowerList') }}">Follower List</a>
                                    <a href="{{ route('changeMyPass') }}">Change Password</a>
                                    <a href="{{ route('changeMyClub') }}">Change Club</a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item sidenav">
                            <h5 class="accordion-header m-0" id="userWalletCollapse">
                                <button class="dropdown-btn fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flushWallet" aria-expanded="false" aria-controls="flushWallet"><i class="fab fa-google-wallet"></i> My Wallet <i class="fa fa-caret-down"></i>
                                </button>
                            </h5>
                            <div id="flushWallet" class="accordion-collapse collapse" aria-labelledby="MyWallet" data-bs-parent="#userWalletCollapse" style="">
                                <div class="accordion-body dropdown-container pt-0">
                                    <a href="{{ route('makeDeposit') }}">Make Deposit</a>
                                    <a href="{{ route('depositHistory') }}">Deposit History</a>
                                    <a href="{{ route('makeWithdraw') }}">Make Withdrawal</a>
                                    <a href="{{ route('withdrawHistory') }}">Withdrawal History</a>
                                    <a href="{{ route('makeC2CTransfer') }}">Coin Transfer</a>
                                    <a href="{{ route('C2CTransferHistory') }}">Coin Transfer History</a>
                                    <a href="{{ route('C2CReceivingHistory') }}">Coin Receiving History</a>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <li><a href="{{ route('customerAccountStmt') }}" class="list-group-item"><i class="fas fa-list"></i> Statement</a></li>
                    @elseif(!empty($clubDetails) && count((array)$clubDetails)>0))
                        <li><a href="{{ url('/') }}" class="list-group-item"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#" class="list-group-item"><i class="fas fa-globe"></i> Live</a></li>
                        <li><a href="#" class="list-group-item"><i class="fas fa-bullhorn"></i> Upcoming</a></li>
                        
                    <div class="accordion accordion-flush" id="clubMenuCollapse">
                        <div class="accordion-item sidenav">
                            <div class="accordion-header m-0" id="clubMenuHead">
                                <button class="dropdown-btn fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#clubMenu" aria-expanded="false" aria-controls="clubMenu">
                                    <i class="fas fa-cogs"></i> Club Activity <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                            <div id="clubMenu" class="accordion-collapse collapse" aria-labelledby="clubMenuHead" data-bs-parent="#clubMenuCollapse" style="">
                                <div class="accordion-body dropdown-container pt-0">
                                    <a href="{{ route('clubSettings') }}">Settings</a>
                                    <a href="{{ route('clubFollower',['clubid'=>$clubDetails->clubid]) }}">Follower List</a>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="accordion-item sidenav">
                            <h5 class="accordion-header m-0" id="clubWalletCollapse">
                                <button class="dropdown-btn fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#clubWallet" aria-expanded="false" aria-controls="clubWallet"><i class="fab fa-google-wallet"></i> Club Wallet <i class="fa fa-caret-down"></i>
                                </button>
                            </h5>
                            <div id="clubWallet" class="accordion-collapse collapse" aria-labelledby="clubWallet" data-bs-parent="#clubMenuCollapse" style="">
                                <div class="accordion-body dropdown-container pt-0">
                                    <a href="{{ route('makeClubWithdraw') }}">Make Withdraw</a>
                                    <a href="{{ route('clubWithdrawHistory',['club'=>$clubDetails->id]) }}">Withdraw History</a>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <li><a href="{{ route('clubStatement',['club'=>$clubDetails->id]) }}" class="list-group-item"><i class="fas fa-list"></i> Statement</a></li>
                    @else
                    <li><a href="{{ url('/') }}" class="list-group-item"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="{{ route('advanceBet') }}" class="list-group-item"><i class="fas fa-bullhorn"></i> Advance Bet</a></li>
                    @endif
                </ul>
            </div>
            @if(!empty($details) && count((array)$details)>0 || !empty($clubDetails) &&  count((array)$clubDetails)>0)
            <div class="bg-dark mt-auto p-3 row align-items-center g-0 text-center user-footer">
                <div class="col-4">
                    <a href="{{ url('/') }}" class="text-white"><i class="fas fa-home"></i></a>
                </div>
                <div class="col-4">
                    @if(!empty($clubDetails) && count((array)$clubDetails)>0)
                    <a href="{{ route('clubSettings') }}" class="text-white"><i class="fas fa-cogs"></i></a>
                    @else
                    <a href="{{ route('userprofile') }}" class="text-white"><i class="fas fa-tachometer-alt"></i></a>
                    @endif
                </div>
                <div class="col-4">
                        <a href="{{ route('userlogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white h2"><i class="fas fa-sign-out-alt"></i></a>
                            <form id="logout-form" action="{{ route('userlogout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                </div>
            </div>
            @endif
        </div>
        <!-- End Offcanvas -->
        @yield('uicontent')
    
    @if(session()->has('success'))
    <script type="text/javascript">
        $(function(){
            $.notify("{{session()->get('success')}}",{
                globalPosition:'top right',className:'success'
            });
        });
    </script>
    @endif
    
     @if(session()->has('error'))
    <script type="text/javascript">
        $(function(){
            $.notify("{{session()->get('error')}}",{
                globalPosition:'top right',className:'error'
            });
        });
    </script>
    @endif
        
        <!-- Footer Start -->
        <div class="bg-dark mt-4">
            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-8 col-md-4">
                        <div class="text-white fw-bold rounded" style="font-size:1.3rem;"><a href="{{ url('/') }}" class="text-white">MrBet365</a></div>
                        <p class="font-1 fw-bold text-white py-4">MrBet365.us are the best online betting service provider over the world.</p>
                        <div class="social-icon">
                            <i class="fab fa-facebook-square fw-bold font-15 text-white"></i>
                            <i class="fab fa-twitter-square fw-bold font-15 text-white"></i>
                            <i class="fab fa-instagram-square fw-bold font-15 text-white"></i>
                        </div>
                        <img src="{{ url('/') }}\assets\images\protected.jpg" class="w-50 bg-white rounded" alt="MrBet365">
                    </div>
                    <div class="col-12 col-md-4 mx-auto quick-link mt-4 mt-md-0">
                        <h2 class="mb-2">Quick Link</h2>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Terms & Condition</a></li>
                            <li><a href="#">Support</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4 mx-auto mt-4 mt-md-0">
                        <div class="bd-example location-text">
                          <address>
                            <strong>MrBet365.us</strong><br>
                            1355 Market St, Suite 900<br>
                            San Francisco, CA 94103<br>
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                          </address>
                          <address>
                            <a href="mailto:first.last@example.com" class="text-white">support@example.com</a>
                          </address>
                        </div>
                        <img src="{{ url('/') }}\assets\images\paymentmethod.png" class="w-50 bg-white rounded mt-4" alt="MrBet365">
                    </div>
                    <div class="col-10 col-md-6 mx-auto text-center mt-4 text-white fw-bold">
                        <p class="m-0">Copyright &copy; MrBet365 {{ date('Y') }} | All Rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        <div>
        <!-- jQuery  -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable( {
            "order": [[ 0, "desc" ]],
            "lengthMenu": [20, 60, 100, 200, 500],
            "pageLength": 20
        } );
    } );
</script>
<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;
    
    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
      } else {
      dropdownContent.style.display = "block";
      }
      });
    }
</script>
        <script src="{{ asset('/') }}admin/assets/js/bootstrap.bundle.min.js"></script>
        @if(!empty($details) && count((array)$details)>0)
        <!-- jQuery  -->
        <script src="{{ asset('/') }}admin/assets/js/metismenu.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/waves.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/feather.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/simplebar.min.js"></script>
        <script src="{{ asset('/') }}admin/assets/js/moment.js"></script>
        <script src="{{ asset('/') }}admin/plugins/daterangepicker/daterangepicker.js"></script>
        
        <!-- Required datatable js -->
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

            <!-- App js -->
            <script src="{{ asset('/') }}admin/assets/js/app.js"></script>
        @endif
        
    </body>
</html>