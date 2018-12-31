@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="card">
                        @if (count($tickets) == 0)
                            <div class="text-center" style="padding:80px;">
                                <img src="https://png.icons8.com/color/100/e67e22/trust.png">
                                <h4>No open tickets to show</h4>
                            </div>
                        @else
                            <div class="content">
                                @foreach ($tickets as $key => $ticket)
                                    <div>
                                        <div class="ticket">
                                            <div class="card">
                                                <div class="content">
                                                    <h5 style="color:#00a2bf;cursor:pointer;">{{ $ticket['title'] }}</h5>
                                                    <small><b>Category:</b> {{ $ticket['category'] }}</small><br><br>
                                                    <small><b>Created by:</b> {{ $ticket['user_id'] }}</small><br><br>
                                                    <small>on it</small>
                                                    <div class="stats text-right">
                                                        {{ timeAgo($ticket['created_at']) }}
                                                    </div>
                                                    <div class="footer">
                                                        <hr />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <template>
                                            <h3>{{ $ticket['title'] }}</h3>
                                            <hr>
                                            <p><b>Category:</b> {{ $ticket['category'] }}</p>
                                            <p><b>User Phone Number:</b> {{ $ticket['user_id'] }}</p>
                                            <p><b>Created:</b> {{ timeAgo($ticket['created_at']) }}</p>
                                            <p><b>Message:</b> {{ $ticket['message'] }}</p>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-6" style="padding:0">
                                                    <button type="submit" class="btn btn-info btn-fill btn-wd pull-right">On it</button>
                                                </div>
                                                <div class="col-xs-6" style="padding:0;padding-left:5px;">
                                                    <button type="submit" class="btn btn-success btn-fill btn-wd pull-left"
                                                            onclick="return confirm('Are you sure you want to mark as solved?');">Mark as solved</button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                    <div id="sticky-anchor"></div>
                    <div class="card" id="ticket-content">
                        <div class="content">
                            <div class="ticket-details"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('app_gen.footer')
</div>



