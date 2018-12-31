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
                                <img class="avatar border-white" src="@if (isset($driver['documents']['profile_pic']['url'])){{ $driver['documents']['profile_pic']['url'] }} @else{{ base_url().'img/user.png' }} @endif"/>
                                <h4 class="title">{{ $driver['personal_details']['first_name'] }} {{ $driver['personal_details']['last_name'] }}<br />
                                    <a href="#"><small>{{ $driver['personal_details']['email'] }}</small></a>
                                </h4>
                            </div><br>
                            <p class="description text-center">
                                {{ timeAgo($driver['personal_details']['created_at']) }}
                                <br/>
                                <span class="text-muted"><small>Joined</small></span>
                            </p>
                        </div>
                        <hr>
                        <div class="text-center">
                            <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-5">
                                    <h5>{{ count($trips) }}<br /><small>Trips</small></h5>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <h5>₦{{ number_format($total_earned) }}<br /><small>Earned</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content" style="padding-bottom:15px !important;">
                            @if (isset($driver['bank_details']))
                                <div style="margin-bottom:0;color:white;border:1px dashed lightgrey;">
                                    <p class="description text-center" style="margin-top: 10px;">
                                        <b>{{ $driver['bank_details']['account_name'] }}</b><br>
                                        {{ $driver['bank_details']['account_number'] }}
                                        <br/>
                                        <span class="text-primary"><small>{{ $driver['bank_details']['bank_name'] }}</small></span>
                                    </p>
                                </div>
                            @else
                                <p class="text-center text-muted" style="margin-bottom:0"><i class="fa fa-institution"></i> No bank details added yet</p>
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
                            @if ($driver['account_status'] == 'suspended')
                                <div class="alert alert-danger text-center" style="margin-bottom:0;color:white;">
                                    <b>Driver is suspended!</b> Kindly confirm from admin before lifting the suspension.
                                </div>
                            @endif
                            <form method="POST" action="{{ site_url().'app/driver_profile' }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}">
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
                                            <input type="text" name="email" class="form-control border-input" placeholder="e.g. example@123.com" value="{{ $driver['personal_details']['email'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" class="form-control border-input" placeholder="e.g. James" value="{{ $driver['personal_details']['first_name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" class="form-control border-input" placeholder="e.g. Corden" value="{{ $driver['personal_details']['last_name'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Car Make</label>
                                            <input type="text" name="car_make" class="form-control border-input" placeholder="e.g. Toyota" value="@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['make'] }} @else --- @endif">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Car Model</label>
                                            <input type="text" name="car_model" class="form-control border-input" placeholder="e.g. Camry" value="@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['model'] }} @else --- @endif">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Car Color</label>
                                            <input type="text" name="car_color" class="form-control border-input" placeholder="e.g. Red" value="@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['color'] }} @else --- @endif">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Model Year</label>
                                            <input type="text" name="car_year" class="form-control border-input" placeholder="e.g. 1999" value="@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['year'] }} @else --- @endif">
                                        </div>
                                    </div>
                                </div>
                                {{--
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>These are samples retrieved from google images based on the driver's input</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ $car_sample[0] }}" style="width:100%">
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{ $car_sample[1] }}" style="width:100%">
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{ $car_sample[2] }}" style="width:100%">
                                    </div>
                                </div>--}}
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Driver's License</label><br/>
                                            @if (isset($driver['documents']['license']))
                                                <a target="_blank" href="{{ $driver['documents']['license']['url'] }}">Click to view image</a>
                                                @if ($driver['documents']['license']['status'] == 'approved')
                                                    <br><small class="text-success">Approved <i class="fa fa-check"></i></small>
                                                    <a class="btn btn-sm btn-danger btn-icon ajax-action" data-href="{{ site_url().'app/document/rejected-license-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-remove"></i></a>
                                                @elseif ($driver['documents']['license']['status'] == 'rejected')
                                                    <br><small class="text-danger">Rejected <i class="fa fa-remove"></i></small>
                                                    <a class="btn btn-sm btn-success btn-icon ajax-action" data-href="{{ site_url().'app/document/approved-license-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-check"></i></a>
                                                @else
                                                    <br><small class="text-warning">Pending <i class="fa fa-asterisk"></i></small>
                                                    <a class="btn btn-sm btn-success btn-icon ajax-action" data-href="{{ site_url().'app/document/approved-license-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-check"></i></a>
                                                    <a class="btn btn-sm btn-danger btn-icon ajax-action" data-href="{{ site_url().'app/document/rejected-license-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-remove"></i></a>
                                                @endif
                                            @else
                                                <small class="text-danger"><i class="fa fa-remove"></i> No image uploaded</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Road Worthiness</label><br/>
                                            @if (isset($driver['documents']['worthiness']))
                                                <a target="_blank" href="{{ $driver['documents']['worthiness']['url'] }}">Click to view image</a>
                                                @if ($driver['documents']['worthiness']['status'] == 'approved')
                                                    <br><small class="text-success">Approved <i class="fa fa-check"></i></small>
                                                    <a class="btn btn-sm btn-danger btn-icon ajax-action" data-href="{{ site_url().'app/document/rejected-worthiness-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-remove"></i></a>
                                                @elseif ($driver['documents']['worthiness']['status'] == 'rejected')
                                                    <br><small class="text-danger">Rejected <i class="fa fa-remove"></i></small>
                                                    <a class="btn btn-sm btn-success btn-icon ajax-action" data-href="{{ site_url().'app/document/approved-worthiness-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-check"></i></a>
                                                @else
                                                    <br><small class="text-warning">Pending <i class="fa fa-asterisk"></i></small>
                                                    <a class="btn btn-sm btn-success btn-icon ajax-action" data-href="{{ site_url().'app/document/approved-worthiness-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-check"></i></a>
                                                    <a class="btn btn-sm btn-danger btn-icon ajax-action" data-href="{{ site_url().'app/document/rejected-worthiness-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-remove"></i></a>
                                                @endif
                                            @else
                                                <small class="text-danger"><i class="fa fa-remove"></i> No image uploaded</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Profile Image</label><br/>
                                            @if (isset($driver['documents']['profile_pic']))
                                                <a target="_blank" href="{{ $driver['documents']['profile_pic']['url'] }}">Click to view image</a>
                                                @if ($driver['documents']['profile_pic']['status'] == 'approved')
                                                    <br><small class="text-success">Approved <i class="fa fa-check"></i></small>
                                                    <a class="btn btn-sm btn-danger btn-icon ajax-action" data-href="{{ site_url().'app/document/rejected-profile_pic-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-remove"></i></a>
                                                @elseif ($driver['documents']['profile_pic']['status'] == 'rejected')
                                                    <br><small class="text-danger">Rejected <i class="fa fa-remove"></i></small>
                                                    <a class="btn btn-sm btn-success btn-icon ajax-action" data-href="{{ site_url().'app/document/approved-profile_pic-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-check"></i></a>
                                                @else
                                                    <br><small class="text-warning">Pending <i class="fa fa-asterisk"></i></small>
                                                    <a class="btn btn-sm btn-success btn-icon ajax-action" data-href="{{ site_url().'app/document/approved-profile_pic-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-check"></i></a>
                                                    <a class="btn btn-sm btn-danger btn-icon ajax-action" data-href="{{ site_url().'app/document/rejected-profile_pic-'.$phone }}" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}"><i class="fa fa-remove"></i></a>
                                                @endif
                                            @else
                                                <small class="text-danger"><i class="fa fa-remove"></i> No image uploaded</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vehicle Inspection Report</label><br/>
                                            <a target="_blank" href="{{ 'https://www.dropbox.com/home/Vehicle%20Inspection?preview='. $phone.'.pdf' }}">{{ 'https://www.dropbox.com/home/Vehicle%20Inspection?preview='. $phone.'.pdf' }}</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">Update Profile</button>
                                    @if ($driver['account_status'] == 'approved')
                                        <button type="submit" class="btn btn-warning btn-fill btn-wd" form="suspend_driver"
                                                onclick="return confirm('Are you sure you want to suspend this driver?');">Suspend Driver</button>
                                    @elseif ($driver['account_status'] == 'suspended')
                                        <button type="submit" class="btn btn-default btn-fill btn-wd" form="unsuspend_driver"
                                                onclick="return confirm('Are you sure you want to un-suspend this driver?');">Un-suspend Driver</button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-fill btn-wd" form="approve_driver"
                                                onclick="return confirm('This will approve all documents, continue?');">Approve Driver</button>
                                    @endif
                                    <button type="submit" class="btn btn-danger btn-fill btn-wd" form="delete_driver"
                                            onclick="return confirm('Are you sure you want to delete this driver?');">Delete Driver</button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                            <form method="post" action="{{ site_url().'app/delete_driver' }}" id="delete_driver" data-redirect="{{ site_url().'app/drivers?retrieve=all' }}">
                                <input name="driver_id" value="{{ $phone }}" type="hidden">
                            </form>
                            <form method="post" action="{{ site_url().'app/approve_driver' }}" id="approve_driver" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}">
                                <input name="driver_id" value="{{ $phone }}" type="hidden">
                            </form>
                            <form method="post" action="{{ site_url().'app/suspend_driver' }}" id="suspend_driver" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}">
                                <input name="driver_id" value="{{ $phone }}" type="hidden">
                            </form>
                            <form method="post" action="{{ site_url().'app/unsuspend_driver' }}" id="unsuspend_driver" data-redirect="{{ site_url().'app/driver_profile?id='.$phone }}">
                                <input name="driver_id" value="{{ $phone }}" type="hidden">
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Trips</h4>
                        </div>
                        <div class="content">
                            @if ($trips)
                                <ul class="list-unstyled team-members">
                                    @foreach ($trips as $key => $trip)
                                        <li>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    @if(isset($trip['pickup_address'])){{ $trip['pickup_address'] }}@else -- @endif
                                                    <br />
                                                    <span class="text-danger"><small>From</small></span>
                                                </div>
                                                <div class="col-xs-4">
                                                    @if(isset($trip['destination_address'])){{ $trip['destination_address'] }}@else -- @endif
                                                    <br />
                                                    <span class="text-success"><small>To</small></span>
                                                </div>
                                                <div class="col-xs-2">
                                                    @if (isset($trip['fares']))
                                                        ₦{{ number_format($trip['fares']['total_fare']) }}<br />
                                                        <span class="text-primary"><small>Paid with {{ $trip['payment_method'] }}</small></span>
                                                    @else
                                                        <small class="text-danger">Not yet received</small>
                                                    @endif
                                                </div>
                                                <div class="col-xs-1 text-right">
                                                    <a role="button" href="#myModal{{ $key }}" data-toggle="modal" class="btn btn-sm btn-success btn-icon"><i class="fa fa-exclamation-circle"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <h5 class="text-center">{{ $driver['personal_details']['first_name'] }} hasn't taken any trips yet</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        @foreach ($trips as $key => $trip)
            <div id="myModal{{ $key }}" class="modal fade" data-keyboard="false" data-backdrop="static" style="z-index:2000">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Trip Details</h4>
                        </div>
                        <div class="modal-body">
                            <p>Rider Information</p>
                            <div class="row">
                                <div class="col-lg-3" style="padding-right: 0 !important">
                                    <img class="avatar border-white" src="{{ $trip['user']['photo_url'] }}"/>
                                </div>
                                <div class="col-lg-9">
                                    <p><b>{{ $trip['user']['first_name'] }} {{ $trip['user']['last_name'] }}</b></p>
                                    <p>{{ $trip['rider_id'] }} - ({{ $trip['user']['email'] }})</p>
                                    <p class="text-muted">Joined {{ timeAgo($trip['user']['created_at']) }} - ({{ date('m/d/Y', $trip['user']['created_at']) }})</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><img src="{{ base_url().'img/start.png' }}"> {{ $trip['pickup_address'] }}</p>
                                    <a target="_blank" href="{{ 'https://www.google.com/maps?q='.$trip['location']['latitude'].','.$trip['location']['longitude'] }}">View in maps ({{ round($trip['location']['latitude'], 2) }}..., {{ round($trip['location']['longitude'], 2) }}..)</a><br>
                                </div>
                                <div class="col-lg-6">
                                    <p><img src="{{ base_url().'img/end.png' }}"> {{ $trip['destination_address'] }}</p>
                                    <a target="_blank" href="{{ 'https://www.google.com/maps?q='.$trip['destination']['latitude'].','.$trip['destination']['longitude'] }}">View in maps ({{ round($trip['destination']['latitude'], 2) }}..., {{ round($trip['destination']['longitude'], 2) }}..)</a><br>
                                </div>
                            </div>
                            <br>
                            <p><b>Taken:</b> {{ timeAgo($trip['created_at']) }} - ({{ date('m/d/Y', $trip['created_at']) }})</p>
                            @if (isset($trip['feedback']))
                                <hr>
                                <p><b>Feedback:</b> "{{ $trip['feedback'] }}"</p>
                                <p><b>Rating:</b></p>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="star-rating">
                                            <span class="fa fa-star-o" data-rating="1"></span>
                                            <span class="fa fa-star-o" data-rating="2"></span>
                                            <span class="fa fa-star-o" data-rating="3"></span>
                                            <span class="fa fa-star-o" data-rating="4"></span>
                                            <span class="fa fa-star-o" data-rating="5"></span>
                                            <input type="hidden" class="rating-value" value="{{ (int)$trip['rating'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <p><b>Status:</b>
                                @if ($trip['status'] == 'ended')
                                    <span class="text-success">Completed<i class="fa fa-check"></i></span>
                                @elseif ($trip['status'] == 'ongoing')
                                    <span class="text-info">On-trip<i class="fa fa-minus"></i></span>
                                @elseif ($trip['status'] == 'cancelled_p')
                                    <span class="text-danger">Cancelled by rider<i class="fa fa-remove"></i></span>
                                @elseif ($trip['status'] == 'cancelled_d')
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



