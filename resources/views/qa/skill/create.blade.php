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
                                    <li class="breadcrumb-item"><a href="{{ url('/qa') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Add Skill</a>
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
                                    <h4 class="card-title">Add Skill</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="mt-1">Add Skill</p>
                                        <form id="skill-add-form" class="form-horizontal" method="post"
                                              enctype="multipart/form-data" autocomplete="off"
                                              action="{{ url('qa/skill/edit') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="skills">Skills</label>
                                                            <select name="skills" id="skills"
                                                                    onchange="getSkillDescription(this);"
                                                                    class="form-control">
                                                                <option value=""></option>
                                                                @foreach($skills as $skill)
                                                                    <option
                                                                        value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="skills">Description</label>
                                                            <textarea name="description" id="description"
                                                                      placeholder="Description"
                                                                      readonly
                                                                      class="form-control"
                                                                      rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a type="button" class="btn btn-danger"
                                               href="{{ url('qa') }}">Cancel</a>
                                            <button type="button" class="btn btn-primary btn-skill-add">Save</button>
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
            $('#skills').select2({
                placeholder: '-- Please select skill --',
                width: '100%'
            });

            $('.btn-skill-add').on('click', function () {
                $('#skill-add-form').submit();
            });
        });


        async function getSkillDescription(obj) {
            let response = await getData('{{ url('api/v1/skills/detail') }}/' + obj.value, {}, 'GET')
            if (response.success) {
                if (response.data) {
                    $('#description').val(response.data.description)
                }
            } else {
                Swal.fire({
                    title: 'Skills',
                    text: "Get skill detail failed: " + JSON.stringify(response.message),
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
