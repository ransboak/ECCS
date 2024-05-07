@extends('backend.main')
@section('content')

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
                        <h4 class="mb-0 font-size-18">Requests</h4>
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
                                <li class="breadcrumb-item active">requests</li>
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

                            @if (Auth::user()->role == 'operator')
                            <div class="my-4">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">New customer request</button>
                            </div>
                            @endif
                           

                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Contact</th>
                                    @if (Auth::user()->role == 'manager')
                                    <th>Action</th>
                                    @else
                                    <th>Status</th>
                                    @endif
                                    
                                    {{-- <th>Amount (GHS)</th>
                                    <th>Date (time)</th> --}}
                                </tr>
                                </thead>

                                <tbody>
                                    @if (Auth::user()->role == 'manager')
                                        @foreach ($operators as $operator)
                                        @foreach ($operator->reqs as $request)
                                        <tr>
                                            <td>{{$request->name}}</td>
                                            <td>{{$request->email}}</td>
                                            <td>{{$request->contact}}</td>
                                            <td>
                                            @if ($request->status == 'pending')
                                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#myModalApprove{{$request->id}}">Approve</button>
                                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#myModalDecline{{$request->id}}">Decline</button>
                                            @elseif ($request->status == 'approved')
                                            <span class="badge badge-soft-success">Approved</span>
                                            @elseif ($request->status == 'declined')
                                            <span class="badge badge-soft-danger">Declined</span>
                                            @endif
                                            </td>
                                            {{-- <td>{{number_format($request->amount, 2, '.', ',')}}</td>
                                            <td>{{\Carbon\Carbon::parse($request->created_at)->format('jS F, Y')}} <span style="color: blue"> ({{\Carbon\Carbon::parse($request->created_at)->format('H:i')}})</span></td> --}}
                                        </tr>
                                        <div id="myModalDecline{{$request->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Approve request</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="modal-body" action="{{route('declineRequest', ['id' => $request->id])}}" method="POST">
                                                            @csrf
                                                            <h6 style="margin-top: -2rem">Are you sure you want to decline the profiling request of {{$request->name}}?</h6>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">No</button>
                                                                <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn">
                                                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                                                    Processing...
                                                                </button> 
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="addBtn">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        <div id="myModalApprove{{$request->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Approve request</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="modal-body" action="{{route('approveRequest', ['id' => $request->id])}}" method="POST">
                                                            @csrf
                                                            <h6 style="margin-top: -2rem">Are you sure you want to approve the request of {{$request->name}}?</h6>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">No</button>
                                                                <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn">
                                                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                                                    Processing...
                                                                </button> 
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="addBtn">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        @endforeach
                                        @endforeach
                                    @else
                                    @foreach ($requests as $request)
                                    <tr>
                                        <td>{{$request->name}}</td>
                                        <td>{{$request->email}}</td>
                                        <td>{{$request->contact}}</td>
                                        <td>
                                            @if ($request->status == 'pending')
                                            <span class="badge badge-soft-warning">Pending</span>                                            @elseif ($request->status == 'approved')
                                            <span class="badge badge-soft-success">Approved</span>
                                            @elseif ($request->status == 'declined')
                                            <span class="badge badge-soft-danger">Declined</span>
                                            @endif
                                            </td>
                                            
                                        {{-- <td>{{number_format($request->amount, 2, '.', ',')}}</td>
                                        <td>{{\Carbon\Carbon::parse($request->created_at)->format('jS F, Y')}} <span style="color: blue"> ({{\Carbon\Carbon::parse($request->created_at)->format('H:i')}})</span></td> --}}
                                    </tr>
                                    @endforeach
                                    @endif
                                    

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
                        <h5 class="modal-title mt-0" id="myModalLabel">Customer request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="modal-body" action="{{route('confirmRequest')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="station_name">Enter Customer Cif</label>
                                <input type="text" name="cif" class="form-control" id="cif" aria-describedby="emailHelp" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="station_officer">Customer Email</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="amount">Customer Contact</label>
                                <input type="text" name="contact" class="form-control" id="contatct" aria-describedby="emailHelp" >
                            </div> --}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn">
                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                    Processing...
                                </button> 
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="confirmBtn">Confirm Customer</button>
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
    document.getElementById('confirmBtn').addEventListener('click', function() {
        // Show preloader
        document.getElementById('spinnerBtn').classList.remove('hidden');
        document.getElementById('confirmBtn').classList.add('hidden');

        setTimeout(() => {
            document.getElementById('spinnerBtn').classList.add('hidden');
            document.getElementById('confirmBtn').classList.remove('hidden');
        }, 6000);
        
    });
</script>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cifInput = document.getElementById('cif');
        const confirmBtn = document.getElementById('confirmBtn');

        // Function to check if all fields are filled
        function checkInputs() {
            const cifValue = cifInput.value.trim();

            if (cifValue == '') {
                confirmBtn.setAttribute('disabled', 'true');
                
            } else {
                confirmBtn.removeAttribute('disabled');
            }
        }

        // Listen for changes in input fields
        checkInputs();
        setInterval(checkInputs, 0.005);
    });
</script>
<!-- App js -->
{{-- <script src="assets/js/app.js"></script> --}}

@endsection
