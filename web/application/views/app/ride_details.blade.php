@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-5">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Ride Information</h4>
                            <hr>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="margin-top: 0 !important">Rider</h5>
                                    <div class="card card-user">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content">
                                                    <div class="author" style="margin-top: 0 !important;">
                                                        <img class="avatar border-white" src="@if ($rider['photo_url'] != ''){{ $rider['photo_url'] }} @else{{ base_url().'img/user.png' }} @endif"/>
                                                        <h4 class="title">{{ $rider['first_name'] }} {{ $rider['last_name'] }}<br />
                                                            <a href="#"><small>{{ $rider['email'] }}</small></a>
                                                        </h4>
                                                    </div><br>
                                                    <p class="description text-center">
                                                        {{ timeAgo($rider['created_at']) }}
                                                        <br />
                                                        <span class="text-muted"><small>Joined</small></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 style="margin-top: 0 !important;">Driver</h5>
                                    <div class="card card-user">
                                        <div class="content">
                                            <div class="author" style="margin-top: 0 !important;">
                                                <img class="avatar border-white" src="{{ $driver['documents']['profile_pic']['url'] }}"/>
                                                <h4 class="title">{{ $driver['personal_details']['first_name'] }} {{ $driver['personal_details']['last_name'] }}<br />
                                                    <a href="#"><small>{{ $driver['personal_details']['email'] }}</small></a>
                                                </h4>
                                            </div><br>
                                            <p class="description text-center">
                                                {{ timeAgo($driver['personal_details']['created_at']) }}
                                                <br />
                                                <span class="text-muted"><small>Joined</small></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><img src="{{ base_url().'img/start.png' }}"> {{ $ride['pickup_address'] }}</p>
                                    <a target="_blank" href="{{ 'https://www.google.com/maps?q='.$ride['location']['latitude'].','.$ride['location']['longitude'] }}">View in maps ({{ round($ride['location']['latitude'], 2) }}..., {{ round($ride['location']['longitude'], 2) }}..)</a><br>
                                </div>
                                <div class="col-lg-6">
                                    <p><img src="{{ base_url().'img/end.png' }}"> {{ $ride['destination_address'] }}</p>
                                    <a target="_blank" href="{{ 'https://www.google.com/maps?q='.$ride['destination']['latitude'].','.$ride['destination']['longitude'] }}">View in maps ({{ round($ride['destination']['latitude'], 2) }}..., {{ round($ride['destination']['longitude'], 2) }}..)</a><br>
                                </div>
                            </div>
                            <br>
                            <p><b>Taken:</b> {{ timeAgo($ride['created_at']) }} - ({{ date('m/d/Y', $ride['created_at']) }})</p>
                            <p><b>Payment Method:</b> {{ ucfirst($ride['payment_method']) }}</p>
                            @if (isset($ride['feedback']))
                                <hr>
                                <p><b>Feedback:</b> "{{ $ride['feedback'] }}"</p>
                                <p><b>Rating:</b></p>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="star-rating">
                                            <span class="fa fa-star-o" data-rating="1"></span>
                                            <span class="fa fa-star-o" data-rating="2"></span>
                                            <span class="fa fa-star-o" data-rating="3"></span>
                                            <span class="fa fa-star-o" data-rating="4"></span>
                                            <span class="fa fa-star-o" data-rating="5"></span>
                                            <input type="hidden" class="rating-value" value="{{ (int)$ride['rating'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <p><b>Status:</b>
                                @if ($ride['status'] == 'ended')
                                    <span class="text-success">Completed<i class="fa fa-check"></i></span>
                                @elseif ($ride['status'] == 'ongoing')
                                    <span class="text-info">On-ride<i class="fa fa-minus"></i></span>
                                @elseif ($ride['status'] == 'cancelled_p')
                                    <span class="text-danger">Cancelled by rider<i class="fa fa-remove"></i></span>
                                @elseif ($ride['status'] == 'cancelled_d')
                                    <span class="text-danger">Cancelled by driver<i class="fa fa-remove"></i></span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Billing</h4>
                            <hr>
                        </div>
                        <div class="content">
                            @if (isset($ride['fares']))
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Base Fare:</p>
                                        <p>Distance Fare:</p>
                                        <p>Stop Fare:</p>
                                        <p>Time Fare:</p>
                                        <br>
                                        <p><b>Total: </b></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>₦{{ number_format($ride['fares']['base_fare']) }}</p>
                                        <p>₦{{ number_format($ride['fares']['distance_fare']) }}</p>
                                        <p>₦{{ number_format($ride['fares']['stop_fare']) }}</p>
                                        <p>₦{{ number_format($ride['fares']['time_fare']) }}</p>
                                        <br>
                                        <p><b>₦{{ number_format($ride['fares']['total_fare']) }}</b></p>
                                    </div>
                                </div>
                            @else
                                <p class="text-center text-muted" style="margin-bottom: 30px;">No Billing information for this ride</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('app_gen.footer')
</div>



