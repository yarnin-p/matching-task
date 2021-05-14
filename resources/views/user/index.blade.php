@extends('layouts.default-template')


@section('title')
    Users
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
                            <h5 class="content-header-title float-left pr-1 mb-0">Users</h5>
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
                                    <h4 class="card-title">Users</h4>
                                    <a href="{{ url('users/add') }}"
                                       class="btn btn-primary btn-sm">Add</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Firstname</th>
                                                    <th>Lastname</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($results as $result)
                                                    <tr>
                                                        <td>{{ $result->firstname }}</td>
                                                        <td>{{ $result->lastname }}</td>
                                                        <td>{{ $result->email }}</td>
                                                        <td>
                                                            <a href="{{ url('skills/'.$result['id']).'/edit' }}"
                                                               type="button" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-pencil-alt top-0"></i>
                                                            </a>
                                                            <button
                                                                onclick="deleteSkill({{ $result['id'] }});"
                                                                type="button" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash top-0"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Firstname</th>
                                                    <th>Lastname</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
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


        async function deleteSkill(skillId) {
            let data = {}
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
                    let response = await postData('{{ url('api/v1/skills') }}' + '/' + skillId + '/delete', data, 'POST');
                    if (response.success) {
                        location.href = '{{ url('skills') }}';
                    } else {
                        Swal.fire({
                            title: 'Skills',
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
