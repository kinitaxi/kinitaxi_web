@extends('gen.base')
@section('title', 'Log In')

@section('content')
    @include('gen/header')
    <div class="blue-back" style="padding-top:5% !important;"></div>
    <div style="background-color: #f9fafc;">
        <div class="container">
            <div class="contact section-invert py-4">
                <h3 class="section-title text-center m-5">Why Choose KiniTaxi</h3>
                <div class="container py-4">
                    <div class="row justify-content-md-center">
                        <div class="contact-form col-sm-12 col-md-10 col-lg-12 p-4 mb-4 card">
                            <div class="row">
                                <div class="col-sm-4 text-center">
                                    <img src="https://png.icons8.com/color/150/2980b9/security-checked.png">
                                </div>
                                <div class="col-sm-8">
                                    <h3><b>Safe Rides, always</b></h3>
                                    <p>We care about your safety and that is why we perform physical verification of every single driver on our platform.
                                    At any time of the day or at night, we've got you covered.</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row desktop-remove">
                                <div class="col-xs-12 text-center">
                                    <img style="padding-left: 90px;" src="https://png.icons8.com/color/150/2980b9/time.png">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3><b>Get moving, save time</b></h3>
                                    <p>We know your time is precious, that is why we train our drivers on time management so you can get moving right away.
                                        So when next you are rushing for a meeting, lets get you there on time.</p>
                                </div>
                                <div class="col-sm-4 text-center mobile-remove">
                                    <img src="https://png.icons8.com/color/150/2980b9/time.png">
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('gen/footer')
@endsection

