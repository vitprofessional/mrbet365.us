@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">A2A(Account to Admin) balance transfer</h4>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($customer)>0)
                                    <form class="form" method="Post" action="{{ route('confirmA2ATransfer') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="profileid" value="{{ $customer->id }}">
                                        <div class="form-group pb-2">
                                            <label for="deductAmount">Coin Amount</label>
                                            <input type="number" name="deductAmount" class="form-control" placeholder="Enter amount to transfer" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Transfer Coin">
                                        </div>
                                    </form>
                                    @else
                                        <div class="alert alert-warning">Sorry! No profile found for transfer</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection