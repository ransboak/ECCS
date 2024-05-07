
@extends('backend.main')
@section('content')
<?php
use Carbon\Carbon;
$today = Carbon::today();
?>
<style>
    .hidden{
        display: none
    }
    input[type='text']{
            border: none;
            background: transparent
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
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">Confirm Customer Request</h5>
                        <form class="card-body" method="POST" action="{{route('addRequest')}}">
                            @csrf

                            <div class="form-group">
                                <label for="station_name">Customer Name</label>
                                <input type="text" name="name" class="form-control" value="{{$name}}" id="station_name" aria-describedby="emailHelp" readonly>
                            </div>
                            <div class="form-group">
                                <label for="station_officer">Customer Email</label>
                                <input type="text" name="email" class="form-control" value="{{$email}}" id="station_officer" aria-describedby="emailHelp" readonly>
                            </div>
                            <div class="form-group">
                                <label for="station_officer">Contact</label>
                                <input type="text" name="mobile_number" class="form-control" value="{{$contact}}" id="station_officer" aria-describedby="emailHelp" readonly>
                            </div>
                            <input type="hidden" name="cif" value="{{$cif}}">
                            {{-- <h4 class="card-title">Customer Name</h4>
                            <p class="card-text">{{$name}}</p>
                            <h4 class="card-title">Customer Email</h4>
                            <p class="card-text">{{$email}}</p>
                            <h4 class="card-title">Contact</h4>
                            <p class="card-text">{{$contact}}</p> --}}
                                <button class="btn btn-primary hidden" type="button" disabled id="spinnerBtn">
                                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                    Processing...
                                </button> 
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="addBtn">Make Request</button>
                            </form>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            
                
                <!-- sample modal content -->
        

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
        }, 8000);
    });
    document.getElementById('addBtn2').addEventListener('click', function() {
        // Show preloader
        document.getElementById('spinnerBtn2').classList.remove('hidden');
        document.getElementById('addBtn2').classList.add('hidden');
        setTimeout(() => {
            document.getElementById('spinnerBtn2').classList.add('hidden');
            document.getElementById('addBtn2').classList.remove('hidden');
        }, 8000);
    });
</script>


<!-- App js -->
{{-- <script src="assets/js/app.js"></script> --}}

@endsection
