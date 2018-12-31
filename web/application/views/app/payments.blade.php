@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            @if (!count($owers) == 0)
                <div class="row" style="padding-bottom: 15px">
                    <div class="col-md-3">
                        <a href="javascript:;" data-href="{{ site_url().'app/payments?retrieve=users' }}" class="ajax-load btn btn-success btn-block"><i class="fa fa-circle-o"></i> Users only</a>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:;" data-href="{{ site_url().'app/payments?retrieve=drivers' }}" class="ajax-load btn btn-danger btn-block"><i class="fa fa-circle-o"></i> Drivers only</a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (count($owers) == 0)
                            <div class="text-center" style="padding:80px;">
                                <img src="https://png.icons8.com/color/100/2980b9/cash-.png">
                                <h4>Congratulations, no one is owing KiniTaxi</h4>
                            </div>
                        @else
                            <div class="header">
                                <h4 class="title">{{ ucfirst($filter) }} Debtors - ({{ count($owers) }})</h4>
                                <p>Click on the name of the debtor to view more details about that person</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Amount Owed</th>
                                        <th>Phone Number</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($owers as $key => $ower)
                                        @if ($ower['type'] == 'user')
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <a class="ajax-load" href="javascript:;" data-href="{{ site_url().'app/user_profile?id='.str_replace('u', '', $key) }}">
                                                        {{ $ower['first_name'] }} {{ $ower['last_name'] }}
                                                    </a>
                                                </td>
                                                <td>₦{{ number_format($ower['amount'] * -1) }}</td>
                                                <td>{{ str_replace('u', '', $key) }}</td>
                                                <td><i class="fa fa-circle text-success"></i></td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-fill btn-wd collect-btn" id="collect{{ $key }}" data-id="{{ str_replace('u', '', $key) }}" data-amount="{{ $ower['amount'] * -1 }}">Collect</button>
                                                    <p class="text-success collected hidden">Collected <i class="fa fa-check"></i></p>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <a class="ajax-load" href="javascript:;" data-href="{{ site_url().'app/driver_profile?id='.str_replace('d', '', $key) }}">
                                                        {{ $ower['personal_details']['first_name'] }} {{ $ower['personal_details']['last_name'] }}
                                                    </a>
                                                </td>
                                                <td>₦{{ number_format($ower['amount'] * -1) }}</td>
                                                <td>{{ str_replace('d', '', $key) }}</td>
                                                <td><i class="fa fa-circle text-danger"></i></td>
                                                <td class="text-center">
                                                    N/A
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



