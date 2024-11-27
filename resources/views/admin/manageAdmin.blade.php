@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Admin Profile List</h4>
                                                    <p class="text-muted mb-0">All admin account are listed here</p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>AdminID</th>
                                                                <th>Email</th>
                                                                <th>Password</th>
                                                                <th>Balance</th>
                                                                <th>Rule</th>
                                                                <th>Status</th>
                                                                <th>Profile Creation</th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($adminUser)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($adminUser as $c)
                                                            <tr>
                                                                <td>{{ $x }}</td>
                                                                <td>{{ $c->adminid }}</td>
                                                                <td>{{ $c->email }}</td>
                                                                <td>{{ $c->plainpass }}</td>
                                                                <td>{{ $c->accountBalance }}</td>
                                                                <td>@if($c->rule=="Level One") Finance Admin @elseif($c->rule=="Level Two") Bet Admin @else Super Admin @endif</td>
                                                                <td>{{ $c->status }}</td>
                                                                <td>{{ $c->created_at }}</td>
                                                                <td class="fw-bold">
                                                                    <a href="{{ route('editAdminProfile',['id'=>$c->id]) }}" class="text-success"><i class="fas fa-eye" title="Update admin profile"></i></a>
                                                                    @if($c->status=="Active")
                                                                    <a href="{{ route('inactiveAdminProfile',['id'=>$c->id]) }}" onclick="return confirm('are you sure to inactive this profile?')" class="text-warning" title="Inactive admin profile"><i class="fas fa-window-close"></i></a>
                                                                @else
                                                                    <a href="{{ route('activeAdminProfile',['id'=>$c->id]) }}" onclick="return confirm('are you sure to active this profile?')" class="text-success" title="Active admin profile"><i class="fas fa-check-square"></i></a>
                                                                @endif
                                                                    <a href="{{ route('delAdminProfile',['id'=>$c->id]) }}" onclick="return confirm('are you sure to delete this profile?')" class="text-danger" title="Delete admin profile"><i class="far fa-trash-alt"></i></a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! No admin found to database</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('newAdminProfile') }}" class="btn btn-dark">New Admin</a>
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