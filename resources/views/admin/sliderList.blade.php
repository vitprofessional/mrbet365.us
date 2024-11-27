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
                                                    <h4 class="card-title">Slider List</h4>
                                                    <p class="text-muted mb-0"> 
                                                    Website slider
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Heading</th>
                                                                <th>Media</th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($slider)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($slider as $slide)
                                                            <tr>
                                                                <td>{{ $slide->id }}</td>
                                                                <td>{{ $slide->heading }}</td>
                                                                <td><img style="height:80px;widht:80px" src="{{ $slide->slider }}" alt="{{ $slide->heading }}"></td>
                                                                <td>
                                                                    <a href="{{ route('editSlider',['id'=>$slide->id]) }}" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-pen-square"></i>
                                                                    </a>
                                                                    <a href="{{ route('deleteSlider',['id'=>$slide->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success text-center">
                                                                <td colspan="6">Sorry! Nothing to slider list</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('newSlider') }}" class="btn btn-dark">Add New</a>
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