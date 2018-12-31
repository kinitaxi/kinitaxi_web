@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="card card-user">
                        <div class="image">
                            <img src="{{ base_url().'img/background.jpg' }}" alt="..."/>
                        </div>
                        <div class="content">
                            <div class="author">
                                <img class="avatar border-white" src="@if ($user['photo_url'] != ''){{ $user['photo_url'] }} @else{{ base_url().'img/user.png' }} @endif"/>
                                <h4 class="title">{{ $user['first_name'] }} {{ $user['last_name'] }}<br />
                                    <a href="#"><small>{{ $user['email'] }}</small></a>
                                </h4>
                            </div><br>
                            <p class="description text-center">
                                {{ timeAgo($user['created_at']) }}
                                <br />
                                <span class="text-muted"><small>Joined</small></span>
                            </p>
                        </div>
                        <hr>
                        <div class="text-center">
                            <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-5">
                                    <h5>{{ count($rides) }}<br /><small>Rides</small></h5>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <h5>₦{{ number_format($total_spent) }}<br /><small>Spent</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content" style="padding-bottom:15px !important;">
                            @if (isset($user['cardData']))
                                @foreach($user['cardData'] as $card)
                                    <div style="margin-bottom:0;color:white;border:1px dashed lightgrey;">
                                        <p class="description text-center" style="margin-top: 10px;">
                                            <i class="fa fa-credit-card text-success"></i><b> {{ ccMasking($card['card_no']) }}</b><br>
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-muted" style="margin-bottom:0"><i class="fa fa-credit-card"></i> No card added yet</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Edit Profile</h4>
                        </div>
                        <div class="content">
                            <form method="POST" action="{{ site_url().'app/user_profile' }}" data-redirect="{{ site_url().'app/user_profile?id='.$phone }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" class="form-control border-input" placeholder="Username" value="{{ $phone }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="text" name="email" class="form-control border-input" placeholder="e.g. example@123.com" value="{{ $user['email'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" class="form-control border-input" placeholder="e.g. James" value="{{ $user['first_name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" class="form-control border-input" placeholder="e.g. Corden" value="{{ $user['last_name'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-xs-6" style="padding:0">
                                            <button type="submit" class="btn btn-info btn-fill btn-wd pull-right">Update Profile</button>
                                        </div>
                                        <div class="col-xs-6" style="padding:0;padding-left:5px;">
                                            <button type="submit" class="btn btn-danger btn-fill btn-wd pull-left" form="delete_user"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">Delete User</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                            <form method="post" action="{{ site_url().'app/delete_user' }}" id="delete_user" data-redirect="{{ site_url().'app/users' }}">
                                <input name="user_id" value="{{ $phone }}" type="hidden">
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Rides</h4>
                        </div>
                        <div class="content">
                            @if ($rides)
                                <ul class="list-unstyled team-members">
                                    @foreach ($rides as $key => $ride)
                                        <li>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    {{ $ride['pickup_address'] }}
                                                    <br />
                                                    <span class="text-danger"><small>From</small></span>
                                                </div>
                                                <div class="col-xs-4">
                                                    {{ $ride['destination_address'] }}
                                                    <br />
                                                    <span class="text-success"><small>To</small></span>
                                                </div>
                                                <div class="col-xs-2">
                                                    @if (isset($ride['fares']))
                                                        ₦{{ number_format($ride['fares']['total_fare']) }}<br />
                                                        <span class="text-primary"><small>Paid with {{ $ride['payment_method'] }}</small></span>
                                                    @else
                                                        <small class="text-danger">Not yet received</small>
                                                    @endif
                                                </div>
                                                <div class="col-xs-1 text-right">
                                                    <a class="btn btn-sm btn-success btn-icon" href="#" data-toggle="modal" data-target="#myModal{{ $key }}"><i class="fa fa-exclamation-circle"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <h5 class="text-center">{{ $user['first_name'] }} hasn't taken any rides yet</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals -->
        @foreach ($rides as $key => $ride)
            <div id="myModal{{ $key }}" class="modal fade" data-keyboard="false" data-backdrop="static" style="z-index:2000">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Ride Details</h4>
                        </div>
                        <div class="modal-body">
                            <p>Driver Information</p>
                            <div class="row">
                                <div class="col-lg-3" style="padding-right: 0 !important">
                                    <img class="avatar border-white" style="width:100%" src="{{ $ride['driver']['documents']['profile_pic']['url'] }}"/>
                                </div>
                                <div class="col-lg-9">
                                    <p><b>{{ $ride['driver']['personal_details']['first_name'] }} {{ $ride['driver']['personal_details']['last_name'] }}</b></p>
                                    <p>{{ $ride['rider_id'] }} - ({{ $ride['driver']['personal_details']['email'] }})</p>
                                    <p class="text-muted">Joined {{ timeAgo($ride['driver']['personal_details']['created_at']) }} - ({{ date('m/d/Y', $ride['driver']['personal_details']['created_at']) }})</p>
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
            </div>
        @endforeach
    </div>
    @include('app_gen.footer')
</div>




