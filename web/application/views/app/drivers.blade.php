@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            @if (!count($drivers) == 0)
                <div class="row" style="padding-bottom: 15px">
                    <div class="col-md-3">
                        <a href="javascript:;" data-href="{{ site_url().'app/drivers?retrieve=online' }}" class="ajax-load btn btn-info btn-block"><i class="fa fa-circle"></i> Drivers Online</a>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:;" data-href="{{ site_url().'app/withdrawals' }}" class="ajax-load btn btn-success btn-block"><i class="fa fa-download"></i> Withdrawal Requests</a>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:;" data-href="{{ site_url().'app/drivers?retrieve=pending' }}" class="ajax-load btn btn-warning btn-block"><i class="fa fa-asterisk"></i> Pending Approval</a>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:;" data-href="{{ site_url().'app/drivers?retrieve=suspended' }}" class="ajax-load btn btn-danger btn-block"><i class="fa fa-download"></i> Suspended Drivers</a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (count($drivers) == 0)
                            <div class="text-center" style="padding:80px;">
                                <img src="https://png.icons8.com/color/100/e67e22/driver.png">
                                <h4>No drivers to show</h4>
                            </div>
                        @else
                            <div class="header">
                                <h4 class="title">{{ ucfirst($filter) }} Drivers ({{ count($drivers) }})</h4>
                                <p>Click on the name of the driver to view more details about that driver</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th></th>
                                        <th>Phone</th>
                                        <th>Car Model</th>
                                        <th>Car Color</th>
                                        <th>Plate</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($drivers as $key => $driver)
                                        @if (isset($driver['personal_details']['first_name']))
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    @if (isset($driver['vehicle_details']))
                                                        <a class="ajax-load" href="javascript:;" data-href="{{ site_url().'app/driver_profile?id='.$key }}">
                                                            {{ $driver['personal_details']['first_name'] }} {{ $driver['personal_details']['last_name'] }}
                                                        </a>
                                                    @else
                                                        <p href="javascript:;" style="margin-bottom:0;">
                                                            {{ $driver['personal_details']['first_name'] }} {{ $driver['personal_details']['last_name'] }} -- still registering
                                                        </p>
                                                    @endif
                                                </td>
                                                <td>@if ($driver['online'] == 'online') <i class="fa fa-circle text-info"></i> @endif</td>
                                                <td>{{ $key }}</td>
                                                <td>@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['model'] }} @else --- @endif</td>
                                                <td>@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['color'] }} @else --- @endif</td>
                                                <td>@if (isset($driver['vehicle_details'])) {{ $driver['vehicle_details']['plate_number'] }} @else --- @endif</td>
                                                <td>
                                                    @if ($driver['account_status'] == 'approved')
                                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                                    @elseif ($driver['account_status'] == 'suspended')
                                                        <span class="text-danger"><i class="fa fa-exclamation-circle"></i></span>
                                                    @elseif ($driver['account_status'] == 'pending')
                                                        <span class="text-warning"><i class="fa fa-asterisk"></i></span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <p class="ajax-load text-danger" href="javascript:;">
                                                        Faulty Registration
                                                    </p>
                                                </td>
                                                <td></td>
                                                <td>{{ $key }}</td>
                                                <td> --- </td>
                                                <td> --- </td>
                                                <td> --- </td>
                                                <td>
                                                    ----
                                                </td>
                                            </tr>
                                        @endif
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



