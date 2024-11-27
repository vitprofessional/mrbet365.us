@extends('front-ui.include')
@section('uititle')
    Profile Update
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
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
                        <div class="input-group-text"><i class="fas fa-unlock"></i></div>
                        <input type="text" class="form-control" value="{{ $details->userid }}" readonly>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                        <input type="email" class="form-control" value="{{ $details->email }}" readonly>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text"><i class="fas fa-list"></i></div>
                        <input type="text" class="form-control" value="{{ $details->country }}" readonly>
                        </select>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text"><i class="fas fa-id-card-alt"></i></div>
                        <input type="text" class="form-control" name="sponsor" value="{{ $details->sponsor }}" readonly>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="input-group mb-4">
                        <div class="input-group-text"><i class="fas fa-phone-square"></i></div>
                        <input type="text" class="form-control" value="{{ $details->phone }}" readonly>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-text"><i class="fas fa-building"></i></div>
                        <input class="form-control" type="text" value="{{ $details->club }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection