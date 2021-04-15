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
                                        <button type="submit"
                                                class="btn btn-primary mb-3">Search
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
                                                    <td>John Doe</td>
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
                                                <tr>
                                                    <td>Jane Foster</td>
                                                    <td>
                                                        <fieldset>
                                                            <div class="radio">
                                                                <input type="radio"
                                                                       name="matching_person"
                                                                       id="radio2">
                                                                <label for="radio2"></label>
                                                            </div>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bob Miles</td>
                                                    <td>
                                                        <fieldset>
                                                            <div class="radio">
                                                                <input type="radio"
                                                                       name="matching_person"
                                                                       id="radio3">
                                                                <label for="radio3"></label>
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
                                                class="btn btn-primary">Matching
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

        });


        async function deleteProject(id) {
            let data = {}
            Swal.fire({
                title: 'Projects',
                text: "Are you want to delete project record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async function (result) {
                if (result.value) {
                    let response = await postData('{{ url('api/v1/projects/delete') }}/' + id, data, 'POST');
                    if (response.success) {
                        location.href = '{{ url('projects') }}';
                    } else {
                        Swal.fire({
                            title: 'Projects',
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
