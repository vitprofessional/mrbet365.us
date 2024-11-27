@extends('front-ui.include')
@section('uititle')
    User Register
@endsection
@include('front-ui.loginregistermodal')
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-10 col-md-8 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-users"></i> User Register</h2>
                </div> 
                <div class="card-body d-none d-md-block">
                <form class="form" action="{{ route('confirmRegister') }}" method="POST">
                      {{ csrf_field() }}
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
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                                <input type="text" class="form-control border border-dark" pattern="[A-Za-z^0-9]{3,15}" title="Allow only [A-Z,a-z,0-9], Space or special character not allowed and minimum 3, maximum 15 character" name="userId" placeholder="Enter an user id*" required>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                                <input type="password" class="form-control border border-dark" name="password" placeholder="Enter your password*" required>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-list"></i></div>
                                <select id="country3" name="country" class="form-control border border-dark" required>
                                </select>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-id-card-alt"></i></div>
                                <input type="text" class="form-control border border-dark" name="sponsor" placeholder="Enter sponsor name(Optional)">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-envelope"></i></div>
                                <input type="email" class="form-control border border-dark" name="email" placeholder="Enter an email*" required>
                            </div>
        
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                                <input type="password" class="form-control border border-dark" name="conPass" placeholder="Confirm password again*" required>
                            </div>
        
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-phone-square"></i></div>
                                <input type="text" class="form-control border border-dark" name="phoneNumber" placeholder="Enter your phone number*" required>
                            </div>
        
                            <div class="input-group mb-4">
                                <div class="input-group-text border border-dark"><i class="fas fa-building"></i></div>
                                <select name ="club" class="form-control border border-dark" required>
                                    <option value="">Select Club</option>
                                    @php
                                        $clubList   = \App\Models\BettingClub::where('status',5)->get();
                                        if(count($clubList)>0):
                                            foreach($clubList as $cl):
                                    @endphp
                                    <option value="{{ $cl->clubid }}">{{ $cl->fullname }}</option>
                                    @php
                                            endforeach;
                                        else:
                                    @endphp
                                        <option value="">-</option>
                                    @php
                                        endif;
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mx-auto text-center">
                            <div class="input-group d-grid gap-2 mb-2">
                                <input type="submit" class="btn btn-dark model-btn" value="Submit" />
                            </div>
                            <a href="{{ route('userLogin') }}" class="text-dark"><i class="fas fa-paper-plane"></i> Already have an account? <span class="btn btn-primary">Login</span></a>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- Mobile Registration Form -->
                <div class="card-body row d-block d-md-none">
                <form class="form" action="{{ route('confirmRegister') }}" method="POST">
                      {{ csrf_field() }}
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
                    <div class="col-12">
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                            <input type="text" class="form-control border border-dark" name="userId" placeholder="Enter an user id*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-envelope"></i></div>
                            <input type="email" class="form-control border border-dark" name="email" placeholder="Enter an email*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="password" class="form-control border border-dark" name="password" placeholder="Enter your password*" required>
                        </div>
    
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="password" class="form-control border border-dark" name="conPass" placeholder="Confirm password again*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-list"></i></div>
                            <select id="country" name ="country" class="form-control border border-dark" required>
                            </select>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-id-card-alt"></i></div>
                            <input type="text" class="form-control border border-dark" name="sponsor" placeholder="Enter sponsor name(Optional)">
                        </div>
    
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-phone-square"></i></div>
                            <input type="text" class="form-control border border-dark" name="phoneNumber" placeholder="Enter your phone number*" required>
                        </div>
    
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-building"></i></div>
                            <select name ="club" class="form-control border border-dark" required>
                                    <option value="">Select Club</option>
                                    @php
                                        $clubList   = \App\Models\BettingClub::all();
                                        if(count($clubList)>0):
                                            foreach($clubList as $cl):
                                    @endphp
                                    <option value="{{ $cl->clubid }}">{{ $cl->fullname }}</option>
                                    @php
                                            endforeach;
                                        else:
                                    @endphp
                                        <option value="">-</option>
                                    @php
                                        endif;
                                    @endphp
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mx-auto text-center">
                        <div class="input-group d-grid gap-2 mb-2">
                            <input type="submit" class="btn btn-dark model-btn" value="Submit" />
                        </div>
                        <a href="{{ route('userLogin') }}" class="text-dark"><i class="fas fa-paper-plane"></i> Already have an account? <span class="btn btn-primary">Login</span></a>
                    </div>
                </form>
                </div>
            </div>
    </div>
    <script type="text/javascript">
        populateCountries("country2");
    </script>
    <script type="text/javascript">
        populateCountries("country");
    </script>
    <script type="text/javascript">
        populateCountries("country3");
    </script>
@endsection