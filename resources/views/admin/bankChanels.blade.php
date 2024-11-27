@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Bank Chanel</h4>
                                                    <p class="text-muted mb-0"> 
                                                    Bank/Bkash List
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th> Account Number </th>
                                                                <th> Payment Type </th>
                                                                <th>Status </th>
                                                                <th>Add On </th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($bankChanel)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($bankChanel as $bc)
                                                            <tr>
                                                                <td>{{ $bc->id }}</td>
                                                                <td>{{ $bc->accountNumber }}</td>
                                                                <td>{{ $bc->paymentType }}</td>
                                                                <td>{{ $bc->status }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($bc->created_at)->format('j M Y') }}</td>
                                                                <td>
                                                                    <a href="{{ route('editBankChanel',['id'=>$bc->id]) }}" class="btn btn-primary btn-sm" onclick="return confirm('are you sure to accept this transaction?')">
                                                                        <i class="fas fa-pen-square"></i>
                                                                    </a>
                                                                    <a href="{{ route('deleteBankChanel',['id'=>$bc->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! Nothing to deposit</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('newBankChanel') }}" class="btn btn-dark">Add New</a>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection