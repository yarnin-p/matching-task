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
                                    <h4 class="card-title">Matching</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="tasks">Tasks</label>
                                                        <select name="tasks" id="tasks" class="form-control">
                                                            <option value="1">Create HTML mockup</option>
                                                            <option value="2">Build web service</option>
                                                            <option value="3">UI design</option>
                                                            <option value="4">Design database</option>
                                                            <option value="5">Create backoffice website</option>
                                                            <option value="6">Config server</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="skills">Skills</label>
                                                        <select name="skills[]" id="skills" multiple
                                                                class="form-control">
                                                            <option value="PHP">PHP</option>
                                                            <option value="HTML5">HTML5</option>
                                                            <option value="CSS3">CSS3</option>
                                                            <option value="Python">Python</option>
                                                            <option value="Go">Go</option>
                                                            <option value="DevOps">DevOps</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="task_size">Task size</label>
                                                        <select name="task_size" id="task_size" class="form-control">
                                                            <option value="S">S</option>
                                                            <option value="M">M</option>
                                                            <option value="L">L</option>
                                                            <option value="XL">XL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="task_size">Work experiences</label>
                                                        <input type="number" class="form-control"
                                                               placeholder="Work experiences"
                                                               value="1"
                                                               name="work_experiences" id="work_experiences">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="period_date">Start and end date of task</label>
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
                                        <button type="button" onclick="search();"
                                                class="btn btn-primary mb-3">Match
                                        </button>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Persons</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Chaloemchai</td>
                                                    <td>
                                                        <fieldset>
                                                            <div class="radio">
                                                                <input type="radio"
                                                                       name="matching_person"
                                                                       id="radio1">
                                                                <label for="radio1"></label>
                                                            </div>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Persons</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <a type="button" class="btn btn-danger">Cancel</a>
                                        <button type="submit"
                                                class="btn btn-primary">Submit
                                        </button>
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
            $('#skills').select2();
        });


        async function search() {
            let data = {
                skills: $('#skills').val(),
                experience: $('#work_experiences').val(),
                period_date: $('#period_date').val(),
                task_size: $('#task_size').val(),
            }
            let response = await postData('{{ url('api/v1/matching/search') }}', data, 'POST');
            if (response.success) {
                location.href = '{{ url('matching') }}';
            } else {
                Swal.fire({
                    title: 'Matching',
                    text: "Something went wrong!",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                })
            }
        }

    </script>
@endsection
