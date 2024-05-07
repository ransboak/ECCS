@extends('backend.main')
@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Dashboard</h4>
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Collection</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge badge-soft-primary float-right">Today</span>
                                <h5 class="card-title mb-0">All ollections Today</h5>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        ₵{{number_format($collection_today, 2, '.', ',')}}
                                    </h2>
                                </div>
                                {{-- <div class="col-4 text-right">
                                    <span class="text-muted">12.5% <i
                                            class="mdi mdi-arrow-up text-success"></i></span>
                                </div> --}}
                            </div>

                            <div class="progress shadow-sm" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <!--end card body-->
                    </div><!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge badge-soft-primary float-right">Today</span>
                                <h5 class="card-title mb-0">Number of collections</h5>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{$collection_today_count}}
                                    </h2>
                                </div>
                                {{-- <div class="col-4 text-right">
                                    <span class="text-muted">18.71% <i
                                            class="mdi mdi-arrow-down text-danger"></i></span>
                                </div> --}}
                            </div>

                            <div class="progress shadow-sm" style="height: 5px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <!--end card body-->
                    </div><!-- end card-->
                </div> <!-- end col-->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge badge-soft-primary float-right">Today</span>
                                <h5 class="card-title mb-0">Branch Collections Today</h5>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        ₵{{number_format($collection_branch_today, 2, '.', ',')}}
                                    </h2>
                                </div>
                                {{-- <div class="col-4 text-right">
                                    <span class="text-muted">12.5% <i
                                            class="mdi mdi-arrow-up text-success"></i></span>
                                </div> --}}
                            </div>

                            <div class="progress shadow-sm" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <!--end card body-->
                    </div><!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge badge-soft-primary float-right">Today</span>
                                <h5 class="card-title mb-0">Total branch collections</h5>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{$collection_branch_today_count}}
                                    </h2>
                                </div>
                                {{-- <div class="col-4 text-right">
                                    <span class="text-muted">18.71% <i
                                            class="mdi mdi-arrow-down text-danger"></i></span>
                                </div> --}}
                            </div>

                            <div class="progress shadow-sm" style="height: 5px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <!--end card body-->
                    </div><!-- end card-->
                </div> <!-- end col-->

                

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge badge-soft-primary float-right">All Time</span>
                                <h5 class="card-title mb-0">Total Collections</h5>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        ₵{{number_format($collection_total, 2, '.', ",")}}
                                    </h2>
                                </div>
                                {{-- <div class="col-4 text-right">
                                    <span class="text-muted">17.8% <i
                                            class="mdi mdi-arrow-down text-danger"></i></span>
                                </div> --}}
                            </div>

                            <div class="progress shadow-sm" style="height: 5px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
                            </div>
                        </div>
                        <!--end card body-->
                    </div><!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge badge-soft-primary float-right">All Time</span>
                                <h5 class="card-title mb-0">Number of Collections</h5>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{$collection_total_count}}
                                    </h2>
                                </div>
                                {{-- <div class="col-4 text-right">
                                    <span class="text-muted">57% <i
                                            class="mdi mdi-arrow-up text-success"></i></span>
                                </div> --}}
                            </div>

                            <div class="progress shadow-sm" style="height: 5px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <!--end card body-->
                    </div>
                    <!--end card-->
                </div> <!-- end col-->



            </div>
            <!-- end row-->



            {{-- <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right position-relative">
                                <a href="index.html#" class="dropdown-toggle h4 text-muted" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="index.html#" class="dropdown-item">Action</a></li>
                                    <li><a href="index.html#" class="dropdown-item">Another action</a></li>
                                    <li><a href="index.html#" class="dropdown-item">Something else here</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a href="index.html#" class="dropdown-item">Separated link</a></li>
                                </ul>
                            </div>
                            <h4 class="card-title d-inline-block">Total Revenue</h4>

                            <div id="morris-line-example" class="morris-chart" style="height: 290px;"></div>

                            <div class="row text-center mt-4">
                                <div class="col-6">
                                    <h4>$7841.12</h4>
                                    <p class="text-muted mb-0">Total Revenue</p>
                                </div>
                                <div class="col-6">
                                    <h4>17</h4>
                                    <p class="text-muted mb-0">Open Compaign</p>
                                </div>
                            </div>

                        </div>
                        <!--end card body-->

                    </div>
                    <!--end card-->
                </div>
                <!--end col-->


            </div> --}}
            <!--end row-->

        </div> <!-- container-fluid -->
    </div>


</div>
<!-- end main content-->
@endsection
