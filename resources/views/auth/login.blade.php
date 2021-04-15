@extends('layouts.login-template')

@section('title')
    {{ __('Login') }}
@endsection

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div
                                        class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">Welcome Back</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="d-flex flex-md-row flex-column justify-content-around">
                                                    <a href="#"
                                                       class="btn btn-social btn-google btn-block font-small-3 mr-md-1 mb-md-0 mb-1">
                                                        <i class="bx bxl-google font-medium-3"></i><span
                                                            class="pl-50 d-block text-center">Google</span></a>
                                                    <a href="#"
                                                       class="btn btn-social btn-block mt-0 btn-facebook font-small-3">
                                                        <i class="bx bxl-facebook-square font-medium-3"></i><span
                                                            class="pl-50 d-block text-center">Facebook</span></a>
                                                </div>
                                                <div class="divider">
                                                    <div class="divider-text text-uppercase text-muted"><small>or login
                                                            with
                                                            email</small>
                                                    </div>
                                                </div>
                                                <form id="login-form">
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600" for="email">Email
                                                            address</label>
                                                        <input type="email" class="form-control" id="email"
                                                               placeholder="Email address" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-bold-600" for="password">Password</label>
                                                        <input type="password" class="form-control"
                                                               id="password" placeholder="Password">
                                                    </div>
                                                    <div
                                                        class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <div class="checkbox checkbox-sm">
                                                                <input type="checkbox" class="form-check-input"
                                                                       id="exampleCheck1">
                                                                <label class="checkboxsmall" for="exampleCheck1"><small>Keep
                                                                        me logged
                                                                        in</small></label>
                                                            </div>
                                                        </div>
                                                        <div class="text-right"><a href="auth-forgot-password.html"
                                                                                   class="card-link"><small>Forgot
                                                                    Password?</small></a></div>
                                                    </div>
                                                    <button type="button" onclick="getLockIn(); return false;"
                                                            class="btn btn-primary glow w-100 position-relative">
                                                        Login
                                                        <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                                    </button>
                                                </form>
                                                <hr>
                                                <div class="text-center"><small class="mr-25">Don't have an
                                                        account?</small><a href="#"><small>Sign
                                                            up</small></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <div class="card-content">
                                        <img class="img-fluid" src="{{ asset('assets/images/pages/login.png') }}"
                                             alt="branding logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection




@section('script')
    <script>
        $(document).ready(function () {

        });

        function validateLoginFm() {
            if (!$('#email').val() || !$('#password').val()) {
                Swal.fire({
                    title: 'Login',
                    text: "Please fill in your email and password!",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                });
                return false
            }
            return true
        }

        // Example POST method implementation:


        async function getLockIn() {
            let isValidate = validateLoginFm();
            if (isValidate) {
                let data = {
                    email: $('#email').val(),
                    password: $('#password').val()
                }
                let response = await postData('{{ url('api/v1/auth/login/check-login') }}', data, 'POST')
                if (response.success) {
                    location.href = 'home'
                } else {
                    Swal.fire({
                        title: 'Login',
                        text: "Unauthorized!",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    });
                }
            }
        }
    </script>
@endsection
