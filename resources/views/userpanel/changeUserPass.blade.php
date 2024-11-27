@extends('front-ui.include')
@section('uititle')
    Password Update
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('updateMyPass') }}" method="POST">
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
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="text" class="form-control border border-dark" name="oldPassword" placeholder="Old Password*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="text" class="form-control border border-dark" name="newPassword" placeholder="New Password*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="text" class="form-control border border-dark" name="confirmPassword" placeholder="Confirm New Password*" required>
                        </div>
                    </div>
                    <div class="col-8 mx-auto text-center">
                        <div class="input-group d-grid gap-2 mb-2">
                            <input type="submit" class="btn btn-dark model-btn" value="Change Password" />
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
@endsection