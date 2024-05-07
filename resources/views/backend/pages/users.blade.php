@extends('backend.main')
@section('content')
<?php
use App\Models\Branch; 
?>
<style>
    .hidden{
        display: none
    }
</style>
<!-- Preloader element -->
<div id="preloader" class="hidden">
    <div class="spinner"></div>
</div>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Users</h4>
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                            {{session('success')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                            {{session('error')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ($errors->any())
                            <ul style="list-style: none">
                                @foreach ($errors->all() as $error)
                                <li>
                                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                                        {{$error}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="my-4">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">Add New user</button>
                            </div>

                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Role</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                    {{-- <th>Amount (GHS)</th>
                                    <th>Date (time)</th> --}}
                                </tr>
                                </thead>


                                <tbody>
                                    @foreach ($users as $user)
                                    @if($user->role !== 'admin')
                                    <?php 
                                    $branch = Branch::where('branch_code', $user->branch)->first();
                                    ?>
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>{{$branch->branch_name}}</td>
                                        <td><button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#editModal{{$user->id}}">Edit</button></td>
                                        {{-- <td>{{number_format($user->amount, 2, '.', ',')}}</td>
                                        <td>{{\Carbon\Carbon::parse($user->created_at)->format('jS F, Y')}} <span style="color: blue"> ({{\Carbon\Carbon::parse($user->created_at)->format('H:i')}})</span></td> --}}
                                    </tr>
                                    @endif
                                    <div id="editModal{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="myModalLabel">Edit user</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="modal-body" action="{{route('editUser', ['id' => $user->id])}}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="station_name">User Name</label>
                                                            <input type="text"  value="{{$user->name}}" class="form-control" id="name" aria-describedby="emailHelp" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="station_officer">User Email</label>
                                                            <input type="email"  value="{{$user->email}}"  class="form-control" id="email" aria-describedby="emailHelp" readonly>
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Role</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="role" readonly>
                                                                <option value="collector" {{$user->role == 'collector' ? 'selected' : ''}} >Collector</option>
                                                                <option value="manager" {{$user->role == 'manager' ? 'selected' : ''}}>Manager</option>
                                                                <option value="operator" {{$user->role == 'operator' ? 'selected' : ''}}>Operator</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Branch</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="branch">
                                                                @foreach ($branches as $branch )
                                                                <option value={{$branch->branch_code}} {{$user->branch == $branch->branch_code ? 'selected' : ''}}>{{$branch->branch_name}}</option>
                                                                @endforeach
                                                                
                                                                {{-- <option value="admin">Admin</option> --}}
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn2">
                                                                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                                                Processing...
                                                            </button> 
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="addBtn2">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                            
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
                <!-- sample modal content -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Add user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="modal-body" action="{{route('addUser')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="station_name">User Name</label>
                                <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="station_officer">User Email</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Role</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="role">
                                    <option value="collector" >Collector</option>
                                    <option value="manager">Manager</option>
                                    <option value="operator">Operator</option>
                                    {{-- <option value="admin">Admin</option> --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Branch</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="branch">
                                    @foreach ($branches as $branch )
                                    <option value={{$branch->branch_code}} >{{$branch->branch_name}}</option>
                                    @endforeach
                                    
                                    {{-- <option value="admin">Admin</option> --}}
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn">
                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                    Processing...
                                </button> 
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="addBtn">Add user</button>
                            </div>
                        </form>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    
</div>


<!-- JavaScript for handling payment and showing preloader -->
<script>
    document.getElementById('addBtn').addEventListener('click', function() {
        // Show preloader
        document.getElementById('spinnerBtn').classList.remove('hidden');
        document.getElementById('addBtn').classList.add('hidden');

        setTimeout(() => {
            document.getElementById('spinnerBtn').classList.add('hidden');
            document.getElementById('addBtn').classList.remove('hidden');
        }, 6000);
        
    }); 
</script>
{{-- <script>
     document.getElementById('addBtn2').addEventListener('click', function() {
        // Show preloader
        document.getElementById('spinnerBtn2').classList.remove('hidden');
        document.getElementById('addBtn2').classList.add('hidden');

        setTimeout(() => {
            document.getElementById('spinnerBtn2').classList.add('hidden');
            document.getElementById('addBtn2').classList.remove('hidden');
        }, 6000);
        
    });
</script> --}}


<!-- App js -->
{{-- <script src="assets/js/app.js"></script> --}}

@endsection
