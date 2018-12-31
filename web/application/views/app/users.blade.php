@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (count($users) == 0)
                            <div class="text-center" style="padding:80px;">
                                <img src="https://png.icons8.com/color/100/e67e22/user-folder.png">
                                <h4>No users registered yet</h4>
                            </div>
                        @else
                            <div class="header">
                                <h4 class="title">All Users ({{ count($users) }})</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $key => $user)
                                        @if (isset($user['first_name']))
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <a class="ajax-load" href="javascript:;" data-href="{{ site_url().'app/user_profile?id='.$key }}">
                                                        {{ $user['first_name'] }} {{ $user['last_name'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $user['email'] }}</td>
                                                <td>{{ $key }}</td>
                                                <td>
                                                    @if($user['photo_url'] != '')
                                                        <a href="{{ $user['photo_url'] }}" target="_blank">Click to view</a>
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



