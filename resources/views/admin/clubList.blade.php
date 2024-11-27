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
                                                    <h4 class="card-title">Club List</h4>
                                                    <p class="text-muted mb-0"> 
                                                    All the club are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Club name</th>
                                                                <th>Login ID</th>
                                                                <th>Password</th>
                                                                <th>Mobile</th>
                                                                <th>Status</th>
                                                                <th>Balance</th>
                                                                <th>Profile Create</th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($club)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($club as $clb)
                                                            <tr>
                                                                <td>{{ $clb->id }}</td>
                                                                <td>{{ $clb->fullname }}</td>
                                                                <td>{{ $clb->clubid }}</td>
                                                                <td>{{ $clb->plainpassword }}</td>
                                                                <td>{{ $clb->phone }}</td>
                                                                <td>@if($clb->status==5) Active @else Banned @endif </td>
                                                                <td>{{ $clb->balance }}</td>
                                                                <td>{{ $clb->created_at }}</td>
                                                                <td>
                                                                    <a href="{{ route('editClub',['id'=>$clb->id]) }}" class="btn btn-primary btn-sm" title="Update Club Details">
                                                    <i class="fas fa-pen-square"></i>
                                                                    </a>
                                                                    @if($clb->status==4)
                                                                    <a href="{{ route('activeClub',['id'=>$clb->id]) }}" class="btn btn-success btn-sm" onclick="return confirm('are you sure to active this club?')" title="Active Club">
                                                                        <i class="fas fa-check-square"></i>
                                                                    </a>
                                                                    @else
                                                                    <a href="{{ route('bannedClub',['id'=>$clb->id]) }}" class="btn btn-warning btn-sm" onclick="return confirm('are you sure to delete this record?')" title="Banned Club">
                                                                        <i class="fas fa-eye-slash"></i>
                                                                    </a>
                                                                    @endif
                                                                    <a href="{{ route('delClub',['id'=>$clb->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')">
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
                                                                <td colspan="6">Sorry! No records found</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('newClub') }}" class="btn btn-dark">Add New</a>
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