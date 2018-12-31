@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (count($withdrawals) == 0)
                            <div class="text-center" style="padding:80px;">
                                <img src="https://png.icons8.com/color/100/e67e22/coins.png">
                                <h4>No pending withdrawal</h4>
                            </div>
                        @else
                            <div class="header">
                                <h4 class="title">Pending Withdrawal Requests</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Amount</th>
                                        <th>Driver ID</th>
                                        <th>Created</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($withdrawals as $key => $withdrawal)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                ₦{{ number_format($withdrawal['amount']) }}
                                            </td>
                                            <td>
                                                <a class="ajax-load" href="javascript:;" data-href="{{ site_url().'app/driver_profile?id='.$key }}" data-link="driver_profile?id='.$key">{{ $key }}</a>
                                            </td>
                                            <td>
                                                {{ timeAgo($withdrawal['created_at']) }}
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-fill btn-wd withdraw-btn" id="withdraw{{ $key }}" data-id="{{ $key }}" data-amount="{{ $withdrawal['amount'] }}">Process</button>
                                                <p class="text-success sent hidden">Sent <i class="fa fa-check"></i></p>
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



