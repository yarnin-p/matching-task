@extends('layouts.default-template')


@section('title')
    Task assigned
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
                            <h5 class="content-header-title float-left pr-1 mb-0">Task assigned</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item">
                                        <a><i class="bx bx-home-alt"></i></a>
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
                                    <h4 class="card-title">Task assigned</h4>
                                    <a href="{{ url('assignment/history/complete') }}"
                                       class="btn btn-sm btn-primary">History success tasks</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Tasks</th>
                                                    <th>Start date - End date</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($resultTasks as $resultTask)
                                                    <tr class="{{ $resultTask->end_date < date('Y-m-d H:i:s') ? 'bg-danger' : '' }}">
                                                        <td class="{{ $resultTask->end_date < date('Y-m-d H:i:s') ? 'text-white' : '' }}">
                                                            {{ $resultTask->task_name }}</td>
                                                        <td class="{{ $resultTask->end_date < date('Y-m-d H:i:s') ? 'text-white' : '' }}">
                                                            {{ $resultTask->start_date.' - '. $resultTask->end_date }}
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                    onclick="sendTask('{{ $resultTask->id }}');"
                                                                    class="btn btn-success btn-sm">
                                                                Check
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty

                                                @endforelse
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Tasks</th>
                                                    <th>Start date - End date</th>
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


        async function sendTask(id) {
            let data = {}
            Swal.fire({
                title: 'Assignment',
                text: "Are you want to commit task?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Commit'
            }).then(async function (result) {
                if (result.value) {
                    let response = await postData('{{ url('api/v1/tasks/send-task') }}/' + id, data, 'POST');
                    if (response.success) {
                        Swal.fire({
                            title: 'Assignment',
                            text: "Commit task successfully!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then(function (result) {
                            if (result.value) {
                                location.href = '{{ url('assignment') }}';
                            } else {
                                location.href = '{{ url('assignment') }}';
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Assignment',
                            text: "Something went wrong!",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        })
                    }
                }
            });
        }

    </script>
@endsection
