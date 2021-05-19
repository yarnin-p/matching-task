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
                                    {{--                                    <a href="{{ url('matching/history') }}"--}}
                                    {{--                                       class="btn btn-sm btn-primary">Matching History</a>--}}
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form id="form-criteria">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="projects">Projects</label>
                                                            <select name="projects" id="projects"
                                                                    onchange="getTaskBySelectedProject(this);"
                                                                    class="form-control">
                                                                <option value=""></option>
                                                                @forelse($projects as $project)
                                                                    <option
                                                                        value="{{ $project['id'] }}">{{ $project['project_name'] }}</option>
                                                                @empty
                                                                    <option value="">No project found!</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="tasks">Tasks</label>
                                                            <select name="tasks" id="tasks" class="form-control">
                                                                <option value=""></option>
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
                                                                <option value=""></option>
                                                                @forelse($skills as $skill)
                                                                    <option
                                                                        value="{{ $skill['id'] }}">{{ $skill['skill_name'] }}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="task_size">Work experiences (year)</label>
                                                            <input type="number" class="form-control"
                                                                   placeholder="Work experiences"
                                                                   value="0"
                                                                   oninput="return isNumberKey(event)"
                                                                   name="work_experiences" id="work_experiences">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
                                                <tbody id="qa_list">
                                                <tr>
                                                    <td colspan="2" class="text-center">No data found!</td>
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
                                        <button type="button" onclick="resetMatching();" class="btn btn-danger">Reset
                                        </button>
                                        <button type="button"
                                                id="submit_matching"
                                                disabled
                                                onclick="saveMatching();"
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
            $('#skills').select2({
                width: '100%',
                placeholder: '-- Please Choose Skill --'
            });
            $('#projects').select2({
                width: '100%',
                placeholder: '-- Please Choose Project --'
            });

            $('#tasks').select2({
                width: '100%',
                placeholder: '-- Please Select Some Project --'
            });
        });

        function checkSelectedQa() {
            let selected_flag = false;
            let selected_person = $('.person_radio');
            [...selected_person].map((row, index) => {
                if (row.checked) {
                    selected_flag = true
                }
            });

            if (selected_flag) {
                $('#submit_matching').prop('disabled', false);
            }
        }


        async function search() {
            let elem = '';
            let data = {
                skills: $('#skills').val(),
                experience: $('#work_experiences').val(),
                project_id: $('#projects').val(),
                task_id: $('#tasks').val()
            }
            let response = await postData('{{ url('api/v1/matching/search') }}', data, 'POST');
            if (response.success) {
                if (response.data && response.data.length > 0) {
                    [...response.data].map((row, index) => {
                        elem += `<tr>`;
                        elem += `<td>${row.firstname} ${row.lastname}</td>`;
                        elem += `<td>`;
                        elem += `<fieldset>`;
                        elem += `<div class="radio">`;
                        elem += `<input type="radio" class="person_radio"
                                               value="${row.id}"
                                               name="matching_person"
                                               onchange="checkSelectedQa();"
                                               id="radio${row.id}">
                                            <label for="radio${row.id}"></label>`;
                        elem += `</div>`;
                        elem += `</fieldset>`;
                        elem += `</td>`;
                        elem += `</tr>`;
                    });
                } else {
                    Swal.fire({
                        title: 'Matching',
                        text: "No qa matching found!",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    });
                    elem += `<tr><td colspan="2" class="text-center">No data found!</td></tr>`;
                }

                $('#qa_list').empty().append(elem);
            } else {
                Swal.fire({
                    title: 'Matching',
                    text: "Something went wrong!",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                });
            }
        }


        async function getTaskBySelectedProject(obj) {
            if (obj.value) {
                console.log(obj.value)
                let project_id = obj.value;
                let elem = '<option></option>';
                let response = await getData('{{ url('api/v1/tasks/project') }}' + '/' + project_id, [], 'GET');
                if (response.success) {
                    if (response.data.length > 0) {
                        [...response.data].map((row, index) => {
                            elem += `<option value='${row.id}'>${row.task_name}</option>`;
                        });
                    } else {
                        elem += `<option value='' disabled>No task found!</option>`;
                    }
                    $('#tasks').empty().append(elem);
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
        }


        async function saveMatching() {
            Swal.fire({
                title: 'Matching',
                text: "Are you want to assign task?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                allowOutsideClick: false
            }).then(async function (result) {
                if (result.value) {
                    let qa_data = $('input[name="matching_person"]')[0].value
                    let data = {
                        task_id: $('#tasks').val(),
                        qa_id: qa_data,
                        task_size: $('#task_size').val()
                    }

                    let response = await postData('{{ url('api/v1/matching/save') }}', data, 'POST');
                    if (response.success) {
                        Swal.fire({
                            title: 'Matching',
                            text: "Matching successfully!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then(function (result) {
                            if (result.value) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        });
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
            });
        }

        function resetMatching() {
            $('#qa_list').empty().append('<tr><td colspan="2" class="text-center">No data found!</td></tr>');
            $('#submit_matching').prop('disabled', true);
            $('#skills').val([]).trigger('change');
            $('#projects').val([]).trigger('change.select2');
            $('#tasks').html('<option></option>');
        }

    </script>
@endsection
