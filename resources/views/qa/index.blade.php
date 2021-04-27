@extends('layouts.default-template')


@section('title')
    QA
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
                            <h5 class="content-header-title float-left pr-1 mb-0">QA</h5>
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
                                    <h4 class="card-title">Skill</h4>
                                    <a href="{{ url('qa/skill/edit') }}"
                                       class="btn btn-primary btn-sm">Add</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Skill</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($skills as $skill)
                                                        <tr>
                                                            <td>{{ $skill->skill_name }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSkill('{{ $skill->id }}')">
                                                                    <i class="fas fa-trash top-0"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Skill</th>
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

                <section class="simple-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Work experiences</h4>
                                    <a href="{{ url('qa/work-experience/edit') }}"
                                       class="btn btn-primary btn-sm">Add</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Organization</th>
                                                    <th>Position</th>
                                                    <th>Years</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($experiences as $experience)
                                                    <tr>
                                                        <td>{{ $experience->organization_name }}</td>
                                                        <td>{{ $experience->position }}</td>
                                                        <td>{{ $experience->year }}</td>
                                                        <td>
                                                            <a href="{{ url('qa/work-experience/edit/' . $experience->id) }}"
                                                               type="button" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-pencil-alt top-0"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteWorkExperience('{{ $experience->id }}')">
                                                                <i class="fas fa-trash top-0"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Organization</th>
                                                    <th>Position</th>
                                                    <th>Years</th>
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


        async function deleteWorkExperience(id) {
            let url = '{{ url('qa/work-experience/delete/?id=') }}' + id;
            Swal.fire({
                title: 'Work Experience',
                text: "Are you want to delete work experience record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async function (result) {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        cache: false,
                        success: function(response) {
                            location.href = '{{ url('qa') }}';
                        },
                        failure: function (response) {
                            Swal.fire(
                                "Error",
                                "Oops, Something went wrong!", // had a missing comma
                                "error"
                            )
                        }
                    });
                }
            });
        }

        async function deleteSkill(id) {
            console.log(id)
            let url = '{{ url('qa/skill/delete/?id=') }}' + id;
            console.log(url)
            Swal.fire({
                title: 'Skills',
                text: "Are you want to delete skill record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async function (result) {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        cache: false,
                        success: function(response) {
                            location.href = '{{ url('qa') }}';
                        },
                        failure: function (response) {
                            Swal.fire(
                                "Error",
                                "Oops, Something went wrong!", // had a missing comma
                                "error"
                            )
                        }
                    });
                }
            });
        }

    </script>
@endsection
