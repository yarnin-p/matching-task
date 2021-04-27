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
                                    <li class="breadcrumb-item"><a href="{{ url('qa') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">{{ isset($qaExperience->id) ? "Edit" : "Add" }} Work Experience
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
                                    <h4 class="card-title">{{ isset($qaExperience->id) ? "Edit" : "Add" }} Work Experience Form</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="mt-1">{{ isset($qaExperience->id) ? "Edit" : "Add" }} Work Experience</p>
                                        <form id="work-experience-form" class="form-horizontal" method="post" enctype="multipart/form-data" autocomplete="off" action="{{ url('qa/work-experience/edit/' . $id) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <input type="text" name="organization" id="organization"
                                                                   class="form-control"
                                                                   value="{{ isset($qaExperience->organization_name) ? $qaExperience->organization_name : "" }}"
                                                                   placeholder="Organization Name" required
                                                                   data-validation-required-message="This Organization Name field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <input type="text" name="position" id="position"
                                                                   class="form-control"
                                                                   value="{{ isset($qaExperience->position) ? $qaExperience->position : "" }}"
                                                                   placeholder="Position" required
                                                                   data-validation-required-message="This Position field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <input type="number" name="year" id="year"
                                                                   class="form-control"
                                                                   value="{{ isset($qaExperience->year) ? $qaExperience->year : "" }}"
                                                                   placeholder="Years" required
                                                                   data-validation-required-message="This Years field is required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a type="button" class="btn btn-danger"
                                               href="{{ url('qa') }}">Cancel</a>
                                            <button type="button" class="btn btn-primary btn-work-experience">Save </button>
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
            $('.btn-work-experience').on('click',function(){
                $('#work-experience-form').submit();
            });
        });


        {{--async function updateSkill() {--}}
        {{--    let data = {--}}
        {{--        skill_name: $('#skill_name').val(),--}}
        {{--        description: $('#description').val()--}}
        {{--    }--}}
        {{--    let response = await postData('{{ url('api/v1/skills/'.$result->id.'/edit/') }}', data, 'POST')--}}
        {{--    if (response.success) {--}}
        {{--        location.href = '{{ url('skills/') }}';--}}
        {{--    } else {--}}
        {{--        Swal.fire({--}}
        {{--            title: 'Skill',--}}
        {{--            text: "Update skill failed!: " + JSON.stringify(response.message),--}}
        {{--            icon: 'warning',--}}
        {{--            showCancelButton: false,--}}
        {{--            confirmButtonColor: '#3085d6',--}}
        {{--            cancelButtonColor: '#d33',--}}
        {{--            confirmButtonText: 'Ok'--}}
        {{--        });--}}
        {{--    }--}}
        {{--}--}}

    </script>

@endsection
