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
                                {{ isset($result['project']) && !empty($result['project']) ? $result['project']->project_name : 'Unknown project' }}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/projects') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Edit Task</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <!-- Project form start -->
                <section class="simple-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit task form</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="mt-1">Edit task</p>
                                        <form class="form-horizontal">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <input type="text" name="task_name" id="task_name"
                                                                   class="form-control"
                                                                   placeholder="Task Name" required
                                                                   value="{{ $result['task']->task_name }}"
                                                                   data-validation-required-message="This Task Name field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <textarea class="form-control" name="description"
                                                                      id="description" placeholder="Description"
                                                                      rows="5"
                                                                      data-validation-required-message="This Project Description field is required">{{ $result['task']->description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control daterange"
                                                               id="period_date" name="period_date"
                                                               placeholder="Select Date">
                                                        <div class="form-control-position">
                                                            <i class='bx bx-calendar-check'></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <a type="button" class="btn btn-danger"
                                               href="{{ url('projects/'.$result['project']->id.'/tasks/') }}">Cancel</a>
                                            <button type="submit"
                                                    onclick="updateTask(); return false;"
                                                    class="btn btn-primary">Save
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Project form end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection



@section('script')
    <script>
        $(document).ready(function () {
            $('#period_date').daterangepicker({
                // locale: {
                //     format: 'YYYY-MM-DD'
                // },
                startDate: '{{ customDateFormat('d/m/Y', $result['task']->start_date) }}',
                endDate: '{{ customDateFormat('d/m/Y', $result['task']->end_date) }}'
            })
        });


        async function updateTask() {
            let data = {
                task_name: $('#task_name').val(),
                description: $('#description').val(),
                period_date: $('#period_date').val()
            }
            let response = await postData('{{ url('api/v1/projects/'.$result['project']->id.'/tasks/'.$result['task']->id.'/edit') }}', data, 'POST')
            if (response.success) {
                location.href = '{{ url('projects/'.$result['project']->id.'/tasks/') }}';
            } else {
                Swal.fire({
                    title: 'Task',
                    text: "Update task failed!: " + JSON.stringify(response.message),
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                });
            }
        }

    </script>

@endsection
