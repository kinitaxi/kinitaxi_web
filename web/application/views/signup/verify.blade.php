@extends('gen.base')
@section('title', 'Verify')

@section('content')
    @include('gen/header')
    <div class="container">
        <div class="row verify-top">
            <div class="col-md-8 ml-auto mr-auto text-center">
                <h2 class="">Verification.</h2>
                <h5 class="description">A code was sent to your phone number, please provide it in the field below.</h5>
            </div>
            <div class="col-md-6 ml-auto mr-auto">
                <div class="no-top-margin">
                    <div class="">
                        <form method="POST" action="{{ site_url(). 'signup/verify' }}">
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" placeholder="Verification code" name="otp">
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-info btn-round btn-block zero-top-margin small-top-margin-mobile">Verify</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('gen/footer')
@endsection