@extends('layouts.default-template')


@section('title')
    Dashboard
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
                            <h5 class="content-header-title float-left pr-1 mb-0">Dashboard</h5>
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
                                    <h4 class="card-title">Dashboard</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Persons</th>
                                                    <th>Tasks</th>
                                                    <th>Start date - End date</th>
                                                    <th>Operations</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>John Doe</td>
                                                    <td>Create website</td>
                                                    <td>15/04/2021 - 16/04/2021</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm">
                                                            <i class="fas fa-search top-0"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jan Froster</td>
                                                    <td>Build API</td>
                                                    <td>17/04/2021 - 21/04/2021</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm">
                                                            <i class="fas fa-search top-0"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bob Miles</td>
                                                    <td>Design database</td>
                                                    <td>22/04/2021 - 22/04/2021</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm">
                                                            <i class="fas fa-search top-0"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Persons</th>
                                                    <th>Persons</th>
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
            $('#skills').select2();
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
