@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Customer Report</h4>
                                    <p class="text-muted mb-0">List of customer report day by day
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="POST" action="{{ route('finalCustomerReport') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="type">Type</label>
                                            <select name="type" class="form-control border border-dark" required>
                                                <option value="All">All</option>
                                                <option value="Deposit">
                                                    Deposit
                                                </option>
                                                <option value="Withdrawal">
                                                    Withdrawal
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="adminId">Admin</label>
                                            <select name="adminId" class="form-control border border-dark" required>
                                                <option value="All">All</option>
                                                @php
                                                    $financeAdmin = \App\Models\AdminUser::where(['rule'=>'Super Admin'])->orWhere(['rule'=>'Level One'])->get();
                                                @endphp
                                                @if(!empty($financeAdmin))
                                                @foreach($financeAdmin as $fAdmin)
                                                <option value="{{ $fAdmin->id }}">
                                                    {{ $fAdmin->adminid }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="dateTimeForm">From Date</label>
                                            <input type="date" name="dateTimeForm" class="form-control border border-dark" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="dateTimeTo">To Date</label>
                                            <input type="date" name="dateTimeTo" class="form-control border border-dark" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Generate">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection