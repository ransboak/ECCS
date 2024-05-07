
@extends('backend.main')
@section('content')
<?php
use App\Models\Collection;
use App\Models\Customer;
use Carbon\Carbon;
$today = Carbon::today();
?>
<style>
    .hidden{
        display: none
    }
</style>

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">{{$customer->name}} Collections @if(\Carbon\Carbon::parse($start_date)->format('jS F Y') == \Carbon\Carbon::parse($end_date)->format('jS F Y') && \Carbon\Carbon::parse($end_date)->format('jS F Y') == \Carbon\Carbon::parse($today)->format('jS F Y')) For Today 
                            @elseif(\Carbon\Carbon::parse($start_date)->format('jS F Y') !== \Carbon\Carbon::parse($end_date)->format('jS F Y') && \Carbon\Carbon::parse($end_date)->format('jS F Y') == \Carbon\Carbon::parse($today)->format('jS F Y')) From {{\Carbon\Carbon::parse($start_date)->format('jS F Y') }} to Today
                            @elseif(\Carbon\Carbon::parse($start_date)->format('jS F Y') !== \Carbon\Carbon::parse($end_date)->format('jS F Y') && \Carbon\Carbon::parse($end_date)->format('jS F Y') !== \Carbon\Carbon::parse($today)->format('jS F Y')) From {{\Carbon\Carbon::parse($start_date)->format('jS F Y') }} to {{\Carbon\Carbon::parse($end_date)->format('jS F Y') }}
                            @elseif(\Carbon\Carbon::parse($start_date)->format('jS F Y') == \Carbon\Carbon::parse($end_date)->format('jS F Y') && \Carbon\Carbon::parse($end_date)->format('jS F Y') !== \Carbon\Carbon::parse($today)->format('jS F Y')) For {{\Carbon\Carbon::parse($end_date)->format('jS F Y')}}
                            @endif </h4>
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
                                <li class="breadcrumb-item active">Collections</li>
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
                            <div class="my-4" style="display:flex; gap: 1rem">
                                @if (Auth::user()->role == 'manager')
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#mySpecModal">Date Specific Collection <i class="mdi mdi-calendar-search"></i></button>

                                @endif
                            </div>

                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Station Name</th>
                                    <th>Station Officer</th>
                                    <th>Collector</th>
                                    <th>Amount (GHS)</th>
                                    <th>Date (Time)</th>
                                </tr>
                                </thead>


                                <tbody>
                                    @foreach ($collections as $collection)
                                    <tr>
                                        <td>{{$collection->station_name}}</td>
                                        <td>{{$collection->station_officer}}</td>
                                        <td>{{$collection->collector->name}}</td>
                                        <td>{{number_format($collection->amount, 2, '.', ',')}}</td>
                                        <td>{{\Carbon\Carbon::parse($collection->created_at)->format('jS F Y')}}<span style="color: blue"> ({{\Carbon\Carbon::parse($collection->created_at)->format('H:i')}})</span></td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
                <!-- sample modal content -->
                <div id="mySpecModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Collection Date</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="modal-body" action="{{route('getCollections')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$customer->id}}" name="customer_id">
                                    <div class="form-group">
                                        <label for="date">Start Date</label>
                                        <input type="date" name="start_date" value={{$start_date}}  max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"class="form-control" id="date" aria-describedby="emailHelp" >
                                    </div>
                                    <div class="form-group">
                                        <label for="date">End Date</label>
                                        <input type="date" name="end_date" value={{$end_date}} max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" id="date" aria-describedby="emailHelp" >
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn">
                                            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                            Processing...
                                        </button> 
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="addBtn">Get Collection</button>
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


<!-- App js -->
{{-- <script src="assets/js/app.js"></script> --}}

@endsection
