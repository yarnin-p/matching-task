@extends('layouts.default-template')


@section('title')
    Project
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
                            <h5 class="content-header-title float-left pr-1 mb-0">Projects -
                                {{ isset($results['project']) && !empty($results['project']) ? $results['project']->project_name : 'Unknown project' }}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/projects') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Tasks</a></li>
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
                                    <h4 class="card-title">Tasks</h4>
                                    <a href="{{ url('projects/'.$results['project']->id.'/tasks/add') }}"
                                       class="btn btn-primary btn-sm">Add</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Task name</th>
                                                    <th>Description</th>
                                                    <th>Start date</th>
                                                    <th>End date</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($results['tasks'] as $task)
                                                    <tr>
                                                        <td>{{ $task['task_name'] }}</td>
                                                        <td>{{ $task['description'] }}</td>
                                                        <td>{{ defaultDateFormat($task['start_date']) }}</td>
                                                        <td>{{ defaultDateFormat($task['end_date']) }}</td>
                                                        <td>
                                                            <a href="{{ url('projects/'.$results['project']->id.'/tasks/'.$task['id'].'/edit') }}"
                                                               type="button" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-pencil-alt top-0"></i>
                                                            </a>
                                                            <button onclick="deleteTask({{ $task['id'] }}, {{ $task['project_id'] }});"
                                                                    type="button" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash top-0"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Task name</th>
                                                    <th>Description</th>
                                                    <th>Start date</th>
                                                    <th>End date</th>
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


        async function deleteTask(taskId, projectId) {
            let data = {}
            Swal.fire({
                title: 'Tasks',
                text: "Are you want to delete task record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async function (result) {
                if (result.value) {
                    let response = await postData('{{ url('api/v1/projects') }}' + '/' + projectId + '/tasks/' + taskId + '/delete', data, 'POST');
                    if (response.success) {
                        location.href = '{{ url('projects') }}' + '/' + projectId + '/tasks';
                    } else {
                        Swal.fire({
                            title: 'Tasks',
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
