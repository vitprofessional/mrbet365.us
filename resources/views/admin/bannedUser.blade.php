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
                                                    <h4 class="card-title">Banned User</h4>
                                                    <p class="text-muted mb-0">All banned customer account are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>User ID</th>
                                                                <th>Email</th>
                                                                <th>Password</th>
                                                                <th>Balance</th>
                                                                <th>Member Form</th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($customer)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($customer as $c)
                                                            <tr>
                                                                <td>{{ $c->id }}</td>
                                                                <td>{{ $c->userid }}</td>
                                                                <td>{{ $c->email }}</td>
                                                                <td>{{ $c->plainpassword }}</td>
                                                                <td>{{ $c->balance }}</td>
                                                                <td>{{ $c->created_at }}</td>
                                                                <td>
                                                                    <a href="{{ route('editUser',['id'=>$c->id]) }}" class="btn btn-primary" title="Update Profile"><i class="fas fa-pen-square"></i></a>
                                                                    <a href="{{ route('activeStatus',['id'=>$c->id]) }}" onclick="return confirm('are you sure to active this profile?')" class="btn btn-success" title="Active Profile"><i class="fas fa-check-square"></i></a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! No user found to database</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="#" class="btn btn-dark">Add New</a>
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