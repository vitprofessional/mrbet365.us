@extends('front-ui.include')
@section('uititle')
    Profile Update
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('clubDetailsUpdate') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-10 col-md-8 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-user-secret"></i> Profile Update</h2>
                </div> 
                <div class="card-body row">
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
                    <div class="col-12 col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                            <input type="text" class="form-control border border-dark" value="{{ $clubDetails->clubid }}" readonly>
                            <input type="hidden" name="clubid" value="{{ $clubDetails->id }}">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-text border border-dark"><i class="fas fa-envelope"></i></div>
                            <input type="email" class="form-control border border-dark"  @if(empty($clubDetails->email)) name="email" @endif value="{{ $clubDetails->email }}" @if(!empty($clubDetails->email)) readonly @else placeholder="Enter your email(Optional)" @endif>
                        </div>
                        @if(empty($clubDetails->email))<p class="mb-2 fw-bold text-danger">Note: You can never change this</p>@endif
                    </div>
                    <div class="col-12 col-md-6">
    
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="text" class="form-control border border-dark" name="password" placeholder="Password leave blank not to change (Optional)*">
                        </div>
    
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-phone-square"></i></div>
                            <input type="text" class="form-control border border-dark" name="phoneNumber" value="{{ $clubDetails->phone }}" placeholder="Enter your phone number*">
                        </div>
                    </div>
                    <div class="col-8 mx-auto text-center">
                        <div class="input-group d-grid gap-2 mb-2">
                            <input type="submit" class="btn btn-dark model-btn" value="Update" />
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
@endsection