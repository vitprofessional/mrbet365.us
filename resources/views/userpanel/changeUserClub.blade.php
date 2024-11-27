@extends('front-ui.include')
@section('uititle')
    Profile Update
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('updateMyClub') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-10 col-md-8 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-building"></i> Change Club</h2>
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
                            <div class="input-group-text border border-dark"><i class="fas fa-building"></i></div>
                            <select name="club" class="form-control border border-dark">
                                <option value="{{ $details->club }}">{{ $details->club }}</option>
                                @php
                                        $clubList   = \App\Models\BettingClub::all();
                                        if(count($clubList)>0):
                                            foreach($clubList as $cl):
                                    @endphp
                                    <option value="{{ $cl->clubid }}">{{ $cl->clubid }}</option>
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
                    <div class="col-8 mx-auto text-center">
                        <div class="input-group d-grid gap-2 mb-2">
                            <input type="submit" class="btn btn-dark model-btn" value="Change Club" />
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
@endsection