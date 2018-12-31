@extends('gen.base')
@section('title', 'Ride around town easily')

@section('content')
    @include('gen/header')
    <div class="header-2">
        <div class="page-header header-filter">
            <div class="page-header-image" style="background-image: url({{ base_url().'img/background1.jpg' }});"></div>
            <div class="content-center medium-top-mobile">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 ml-auto mr-auto text-center">
                            <h1 class="title"> Break the Hassel, Ride in Style.</h1>
                            <h5 class="description">Kinitaxi is the easiest way to get around town. The riding experience re-imagined.</h5>
                        </div>
                        <div class="col-md-10 ml-auto mr-auto">
                            <div class="card card-raised card-form-horizontal no-top-margin">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="phone" placeholder="You Phone Number">
                                                <span class="input-group-addon">
                                                        <i class="now-ui-icons tech_mobile"></i>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="https://play.google.com/store/apps/details?id=com.kinitaxi.ng">
                                                <button class="btn btn-primary btn-round btn-block">Get A Free Ride Now</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features-3 small-top-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="title">Simple. Safe. Fast.</h2>
                    <h4 class="description">Going around town is easier now more than ever, you can book a private ride or ride with friends.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info info-hover">
                        <div class="icon icon-info icon-circle">
                            <i class="now-ui-icons tech_mobile"></i>
                        </div>
                        <h4 class="info-title">Simple</h4>
                        <p class="description">A well built interface that helps you focus on getting to your destination.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info info-hover small-top">
                        <div class="icon icon-success icon-circle">
                            <i class="now-ui-icons ui-2_favourite-28"></i>
                        </div>
                        <h4 class="info-title">Safe</h4>
                        <p class="description">All drivers on KiniTaxi are verified so you can get to know them.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info info-hover small-top">
                        <div class="icon icon-primary icon-circle">
                            <i class="now-ui-icons tech_watch-time"></i>
                        </div>
                        <h4 class="info-title">Fast</h4>
                        <p class="description">Get to where you are going on time without the stress and hassle.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features-6 small-top-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center">
                    <h2 class="title">Every Ride is a Pleasure</h2>
                    <h4 class="description">We guarantee it that you will enjoy your ride with KiniTaxi.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info info-horizontal small-top">
                        <div class="icon icon-info">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">Multiple Stops</h5>
                            <p>Want to pick up something on your way to the shop, make stops up to 3 times along your journey.</p>
                        </div>
                    </div>
                    <div class="info info-horizontal">
                        <div class="icon icon-danger">
                            <i class="now-ui-icons location_pin"></i>
                        </div>
                        <div class="description">
                            <h4 class="info-title">Book for Someone Else</h4>
                            <p>Want a Kinitaxi to go pickup your mum from the market, just order for her and a ride will be waiting for her.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="phone-container">
                        <img src="{{ base_url().'img/screenshot.png' }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info info-horizontal small-top-bottom">
                        <div class="icon icon-primary">
                            <i class="now-ui-icons ui-2_favourite-28"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">Save Favorite Places</h5>
                            <p>Save exciting places you visit regularly on Kinitaxi and we will be there to pick you up always.</p>
                        </div>
                    </div>
                    <div class="info info-horizontal">
                        <div class="icon icon-success">
                            <i class="now-ui-icons ui-2_chat-round"></i>
                        </div>
                        <div class="description">
                            <h4 class="info-title">Free Rides</h4>
                            <p>Get free rides when you refer someone to ride with Kintaxi, to any place at any time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="projects-4" data-background-color="gray" style="padding-top: 10px; padding-bottom:1px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mr-auto ml-auto text-center">
                    <h2 class="title">Meet Amazing People</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 px-0">
                    <div class="card card-fashion card-background" style="background-image: url({{ base_url().'img/girl2.jpg' }})">
                        <div class="card-body">
                            <div class="card-title text-left">
                                <h2>
                                    <a href="#">
                                        Getting my cakes to customers has been vital to my business success and Kinitaxi has helped me achieve that.
                                    </a>
                                </h2>
                            </div>
                            <div class="card-footer text-left">
                                <div class="stats">
                                            <span>
                                                <i class="now-ui-icons objects_globe"></i>Joani Cakes
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 px-0">
                    <div class="card-container">
                        <div class="card card-fashion">
                            <div class="card-title">
                                <a href="">
                                    <h4>
                                        <a href="">
                                            Move around with your friends, share rides with amazing new people just like you.
                                        </a>
                                    </h4>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-footer">
                                    <div class="stats">
                                                <span>
                                                    <i class="now-ui-icons ui-2_favourite-28"></i> Happy people
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-fashion card-background" style="background-image: url({{ base_url().'img/people.jpg' }})">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 px-0">
                    <div class="card-container">
                        <div class="card card-fashion card-background" style="background-image: url({{ base_url().'img/man.jpg' }})">
                        </div>
                        <div class="card card-fashion arrow-left">
                            <div class="card-title">
                                <h4>
                                    <a href="">
                                        Driving with Kinitaxi helps me work on my own time while making enough.
                                    </a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="card-footer">
                                    <div class="stats">
                                                <span>
                                                    <i class="now-ui-icons users_single-02"></i>Dave, driver since 2017
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 px-0">
                    <div class="card card-fashion card-background" style="background-image: url({{ base_url().'img/girl1.jpeg' }})">
                        <div class="card-body">
                            <div class="card-title text-left">
                                <h2>
                                    <a href="">KiniTaxi has helped me discover new places</a>
                                </h2>
                            </div>
                            <div class="card-footer text-left">
                                <div class="stats">
                                            <span>
                                                <i class="now-ui-icons media-2_sound-wave"></i>Susan Steel
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="projects-5 small-top-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center">
                    <h2 class="title">Go Solo, or With Friends</h2>
                    <h4 class="description">Whether you are rushing out to beat time or going out as a group for a hangout at your favorite restaurant, we've got your back.</h4>
                    <div class="section-space"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 ml-auto small-bottom-mobile">
                    <div class="card card-background card-background-product card-raised" style="background-image: url({{ base_url().'img/alone.jpg' }})">
                        <div class="card-body">
                            <h2 class="card-title">Go Alone</h2>
                            <p class="card-description">
                                Need to get somewhere fast without delay, go alone with our solo option.
                            </p>
                            <label class="badge badge-neutral">Solo</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mr-auto">
                    <div class="card card-background card-background-product card-raised" style="background-image: url({{ base_url().'img/friends.png' }})">
                        <div class="card-body">
                            <h2 class="card-title">Ride with Friends</h2>
                            <p class="card-description ">
                                Riding with others help you connect and build meaningful relationships.
                            </p>
                            <label class="badge badge-neutral">Group</label>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="zero-margin-bottom-mobile"/>
        </div>
    </div>
    <div class="cd-section">
        <div class="blogs-5 small-top" data-background-color="white">
            <div class="col-md-12 ml-auto mr-auto">
                <h2 class="title container text-center" style="color:black;">Meet The People Behind The Wheel</h2>
                <div class="responsive">
                    <div class="col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="">
                                    <img class="img rounded" src="{{ base_url().'img/driver1.jpg' }}">
                                </a>
                            </div>
                            <div class="card-body">
                                <h6 class="category text-primary">Top Driver</h6>
                                <h5 class="card-title">
                                    <b>Uchenna Nnodim</b>
                                </h5>
                                <p class="card-description">
                                    Driving with Kinitaxi has opened up a new way for me to make extra income on the side.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="">
                                    <img class="img rounded" src="{{ base_url().'img/driver4.jpg' }}">
                                </a>
                            </div>
                            <div class="card-body">
                                <h6 class="category text-primary">Top Driver</h6>
                                <h5 class="card-title">
                                    <b>Angela Magoda</b>
                                </h5>
                                <p class="card-description">
                                    As a single mother i have been able to provide consistently for my family.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="">
                                    <img class="img rounded" src="{{ base_url().'img/driver2.jpg' }}">
                                </a>
                            </div>
                            <div class="card-body">
                                <h6 class="category text-primary">Skillful</h6>
                                <h5 class="card-title">
                                    <b>Ayo Bamidele</b>
                                </h5>
                                <p class="card-description">
                                    Kinitaxi has been really helpful of late, with instant cash out, i can make what i need.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="">
                                    <img class="img rounded" src="{{ base_url().'img/driver3.jpg' }}">
                                </a>
                            </div>
                            <div class="card-body">
                                <h6 class="category text-primary">Top Driver</h6>
                                <h5 class="card-title">
                                    <b>Stella Dale</b>
                                </h5>
                                <p class="card-description">
                                    Meeting and interacting with new people for me is the most exciting part of my experience.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contactus-1 section-image">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h2 class="title">Get in Touch</h2>
                    <h4 class="description">You need more information? We will be glad to hear from you.</h4>
                    <div class="info info-horizontal">
                        <div class="icon icon-primary">
                            <i class="now-ui-icons location_pin"></i>
                        </div>
                        <div class="description">
                            <h4 class="info-title">Find us at the office</h4>
                            <p class="description"> 2 charles Ogan avenue,
                                <br> Nkpoju rd Trans Amadi PHC
                            </p>
                        </div>
                    </div>
                    <div class="info info-horizontal">
                        <div class="icon icon-primary">
                            <i class="now-ui-icons tech_mobile"></i>
                        </div>
                        <div class="description">
                            <h4 class="info-title">Give us a ring</h4>
                            <p class="description">
                                +234 812 479 7859
                                <br> +234 701 181 1927
                                <br> hello@kinitaxi.com
                                <br> Mon - Fri, 8:00-22:00
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 ml-auto mr-auto">
                    <div class="card card-contact card-raised">
                        <form role="form" action="{{ site_url().'home/contact' }}" id="contact-form" method="post">
                            <div class="card-header text-center">
                                <h4 class="card-title">Contact Us</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 pr-2">
                                        <label>First name</label>
                                        <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="now-ui-icons users_circle-08"></i>
                                                    </span>
                                            <input type="text" name="first_name" class="form-control" placeholder="First Name..." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pl-2">
                                        <div class="form-group">
                                            <label>Last name</label>
                                            <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="now-ui-icons text_caps-small"></i>
                                                        </span>
                                                <input type="text" name="last_name" placeholder="Last Name..." class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email address</label>
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="now-ui-icons ui-1_email-85"></i>
                                                </span>
                                        <input type="email" name="email" placeholder="Email Here..." class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Your message</label>
                                    <textarea name="message" class="form-control" id="message" rows="6" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            <input id="checkbox1" type="checkbox" required>
                                            <label for="checkbox1">
                                                I'm not a robot
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-round pull-right">Send Message</button>
                                    </div>
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
