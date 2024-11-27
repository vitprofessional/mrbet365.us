@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Bank/Bkash</h4>
                                    <p class="text-muted mb-0">Update an existing bank/bkash account
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                @if(!empty($bankChanel))
                                    <form class="form" method="Post" action="{{ route('updateBankChanel') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="bankId" value="{{ $bankChanel->id }}">
                                        <div class="form-group pb-2">
                                            <label for="pmtType">PaymentType</label>
                                            <select name="pmtType" class="form-control" required>
                                                <option value="{{ $bankChanel->paymentType }}">{{ $bankChanel->paymentType }}</option>
                                                <option value="Bkash Personal">Bkash Personal</option>
                                                <option value="Bkash Agent">Bkash Agent</option>
                                                <option value="Nagod Personal">Nagod Personal</option>
                                                <option value="Nagod Agent">Nagod Agent</option>
                                                <option value="Rocket Personal">Rocket Personal</option>
                                                <option value="Rocket Agent">Rocket Agent</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="accountNumber">Bank/Bkash Number</label>
                                            <input type="text" name="accountNumber" class="form-control" placeholder="Enter bank/bkash number" value="{{ $bankChanel->accountNumber }}" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="pmtStatus">Status</label>
                                            <select name="pmtStatus" class="form-control" required>
                                                <option value="{{ $bankChanel->status }}">{{ $bankChanel->status }}</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                            <a href="{{ route('manageBankChanel') }}" class="btn btn-dark">Bank/Bkash List</a>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning">Sorry! No data found</div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection