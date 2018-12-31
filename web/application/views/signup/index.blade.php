@extends('gen.base')
@section('title', 'Sign Up')

@section('content')
    @include('gen/header')
    <div class="container page-top-margin page-top-margin-small">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="">
                    <h1 class="text-center fancy-header">Start Using Intract</h1>
                    <p class="text-center">Already have an account, <a href="{{ site_url('signin') }}">Log In</a></p>
                    <div class="row round-margin">
                        <div class="col-sm-6 bottom-padding-small-screen">
                            <button id="signup_fb" href="" title="Facebook" class="btn btn-block btn-social btn-lg btn-facebook" onclick="fb_login()">
                                <i class="fa fa-facebook"></i> Sign up with Facebook
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-block btn-social btn-lg btn-google" id="customBtn">
                                <i class="fa fa-google"></i> Sign up with Google
                            </button>
                        </div>
                    </div>
                    <hr class="style4">
                    <br>
                    <form class="form-inline form-white" action="{{ site_url('signup') }}" method="POST">
                        <div class="form-group full-width">
                            <input type="text" class="form-control full-width down-margin"
                                   placeholder="Full Name" name="name" required>
                            <input type="email" class="form-control full-width down-margin"
                                   placeholder="Email" name="email" required>
                            <input type="password" class="form-control full-width down-margin"
                                   placeholder="Password" name="password" required>
                            <button type="submit" class="btn btn-shadow btn-green full-width down-margin" id="btnclicked">Sign Up</button>
                            <small>By signing up, you agree to the Terms of Service and Privacy Policy.</small>
                        </div>
                        <input class="csrf_token" type="hidden" name="{{ csrf_token('name') }}" value="{{ csrf_token('value') }}">
                    </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection