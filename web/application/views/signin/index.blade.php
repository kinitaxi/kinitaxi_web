@extends('gen.base')
@section('title', 'Log In')

@section('content')
    @include('gen/header')
    <div class="container" style="height:80%">
        <div class="row signin-top">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="">
                    <h2 class="text-center">Sign In</h2>
                    <p class="text-center">Administrator Sign in</p>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
        <div class="row">
            <div class="col-sm-4 ml-auto mr-auto">
                <div class="no-top-margin">
                    <form class="form-white" action="{{ site_url('signin') }}" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control full-width down-margin"
                                   placeholder="Email" name="email" required>
                            <input type="password" class="form-control full-width down-margin small-top-margin small-top-margin-mobile"
                                   placeholder="Password" name="password" required>
                            <button type="submit" class="btn btn-info w-50 full-width-mobile small-top-margin small-top-margin-mobile">Log In</button>
                        </div>
                        <input class="csrf_token" type="hidden" name="{{ csrf_token('name') }}" value="{{ csrf_token('value') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('gen/footer')
@endsection