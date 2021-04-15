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
                            <h5 class="content-header-title float-left pr-1 mb-0">Projects</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/projects') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Add Project</a>
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
                                    <h4 class="card-title">Project form</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="mt-1">Add project</p>
                                        <form class="form-horizontal">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <input type="text" name="project_name" id="project_name"
                                                                   class="form-control"
                                                                   placeholder="Project Name" required
                                                                   data-validation-required-message="This Project Name field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <textarea class="form-control" name="description"
                                                                      id="description" placeholder="Description"
                                                                      required
                                                                      rows="5"
                                                                      data-validation-required-message="This Project Description field is required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a type="button" class="btn btn-danger"
                                               href="{{ url('projects') }}">Cancel</a>
                                            <button type="submit" onclick="createProject(); return false;"
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

        });


        async function createProject() {
            let data = {
                project_name: $('#project_name').val(),
                description: $('#description').val()
            }
            let response = await postData('{{ url('api/v1/projects/add') }}', data, 'POST')
            if (response.success) {
                location.href = '{{ url('projects') }}';
            } else {
                Swal.fire({
                    title: 'Projects',
                    text: "Create project failed!: " + JSON.stringify(response.message),
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
