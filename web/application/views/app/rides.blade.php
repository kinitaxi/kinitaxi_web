@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            @if (!count($rides) == 0)
                <div class="row" style="padding-bottom: 15px">
                    <div class="col-md-3">
                        <a href="{{ site_url().'app/rides?retrieve=cancelled' }}" class="btn btn-danger btn-block"><i class="fa fa-remove"></i> Cancelled Rides</a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ site_url().'app/rides?retrieve=accepted' }}" class="btn btn-info btn-block"><i class="fa fa-minus"></i> Accepted Rides</a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ site_url().'app/rides?retrieve=ended' }}" class="btn btn-success btn-block"><i class="fa fa-check"></i> Completed Rides</a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (count($rides) == 0)
                            <div class="text-center" style="padding:80px;">
                                <img src="https://png.icons8.com/color/100/e67e22/road.png">
                                <h4>No rides to show</h4>
                            </div>
                        @else
                            <div class="header">
                                <h4 class="title">{{ ucfirst($filter) }} Rides ({{ count($rides) }})</h4>
                                <p>Click on the ID of a ride to view more information about that ride</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>ID</th>
                                        <th>Driver</th>
                                        <th>Rider</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rides as $key => $ride)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <a href="javascript:;" class="ajax-load" data-href="{{ site_url().'app/ride_details?id='.$key }}">
                                                    {{ $key }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ site_url().'app/driver_profile?id='.$ride['driver_id'] }}" target="_blank">
                                                    {{ $ride['driver_id'] }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ site_url().'app/user_profile?id='.$ride['rider_id'] }}" target="_blank">
                                                    {{ $ride['rider_id'] }}
                                                </a>
                                            </td>
                                            <td>{{ timeAgo($ride['created_at']) }}</td>
                                            <td>
                                                @if ($ride['status'] == 'cancelled_d')
                                                    <span class="text-danger"><i class="fa fa-remove"></i></span>
                                                @elseif ($ride['status'] == 'cancelled_p')
                                                    <span class="text-danger"><i class="fa fa-remove"></i></span>
                                                @elseif ($ride['status'] == 'accepted')
                                                    <span class="text-info"><i class="fa fa-minus"></i></span>
                                                @elseif ($ride['status'] == 'ended')
                                                    <span class="text-success"><i class="fa fa-check"></i></span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('app_gen.footer')
</div>



