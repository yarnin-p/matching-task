@extends('layouts.default-template')


@section('title')
    Matching
@endsection


@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">Matching</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('matching') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Matching history</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Simple Validation start -->
                <section class="simple-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Matching history</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Responsible person</th>
                                                    <th>Task name</th>
                                                    <th>Description</th>
                                                    <th>Start date</th>
                                                    <th>End date</th>
                                                    <th>Status</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($histories as $history)
                                                    <tr>
                                                        <td>{{ $history->firstname. ' '. $history->lastname }}</td>
                                                        <td>{{ $history->task_name }}</td>
                                                        <td>{{ $history->description }}</td>
                                                        <td>{{ $history->start_date }}</td>
                                                        <td>{{ $history->end_date }}</td>
                                                        <td>
                                                            @if ($history->status == 'process')
                                                                <span class="badge badge-warning text-white">Process</span>
                                                            @else
                                                                <span class="badge badge-success text-white">Complete</span>
                                                            @endif
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Responsible person</th>
                                                    <th>Task name</th>
                                                    <th>Description</th>
                                                    <th>Start date</th>
                                                    <th>End date</th>
                                                    <th>Status</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input Validation end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection



@section('script')
    <script>
        $(document).ready(function () {
        });


    </script>
@endsection
