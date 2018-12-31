@include('app_gen.reloader')
@include('app_gen.sidebar')

<div class="main-panel">
    @include('app_gen.navbar')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="content">
                            <form method="POST" action="{{ site_url().'app/app_settings' }}">

                                <h4 class="title">Fare and Billing</h4>
                                <hr>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Base Fare</label>
                                                    <input type="text" name="base_fare" class="form-control border-input" placeholder="Base fare" value="{{ $setting['base_fare'] }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Distance Fare</label>
                                                    <input type="text" name="distance_fare" class="form-control border-input" placeholder="Distance fare" value="{{ $setting['distance_fare'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Stop Fare</label>
                                                    <input type="text" name="stop_fare" class="form-control border-input" placeholder="Stop fare" value="{{ $setting['stop_fare'] }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time Fare</label>
                                                    <input type="text" name="time_fare" class="form-control border-input" placeholder="Time fare" value="{{ $setting['time_fare'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sms-bal text-center">
                                            <h3>{{ $smsbal }} UNITS</h3>
                                            <p>SMS Balance</p>
                                            <a href="https://smartsmssolutions.com/" target="_blank">Click here to top-up</a>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="title">Ride Settings</h4>
                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>KiniTaxi Charges - in %</label>
                                            <input type="text" name="drivers_percentage" class="form-control border-input" placeholder="Charge" value="{{ 100 - $setting['drivers_percentage'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Driver Radius Limit - in KM</label>
                                            <input type="number" name="driver_radius_limit" class="form-control border-input" placeholder="Distance fare" value="{{ $setting['driver_radius_limit'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Notification Timeout - in seconds</label>
                                            <input type="text" name="timeout" class="form-control border-input" placeholder="Timeout" value="{{ $setting['timeout'] }}">
                                        </div>
                                    </div>
                                </div>

                                <h4 class="title">General Settings</h4>
                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Notification Key</label>
                                            <input type="text" readonly name="notification_key" class="form-control border-input" placeholder="Notification key" value="{{ $setting['notification_key'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>App Version</label>
                                            <input type="text" name="version" class="form-control border-input" placeholder="Version" value="{{ $setting['version'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Force Update</label>
                                            <select id="exampleInputEmail1" name="force_update" class="form-control border-input">
                                                <option value="yes" @if ($setting['force_update'] == 'yes')selected @endif>Yes</option>
                                                <option value="no" @if ($setting['force_update'] == 'no')selected @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">SMS Gateway</label>
                                            <select id="exampleInputEmail1" name="sms_gateway" class="form-control border-input">
                                                <option value="twilio" @if ($setting['sms_gateway'] == 'twilio')selected @endif>Twilio</option>
                                                <option value="smartsms" @if ($setting['sms_gateway'] == 'smartsms')selected @endif>SmartSMS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>App Version Driver</label>
                                            <input type="text" name="version_d" class="form-control border-input" placeholder="Version" value="{{ $setting['version_d'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Force Update Driver App</label>
                                            <select id="exampleInputEmail1" name="force_update_d" class="form-control border-input">
                                                <option value="yes" @if ($setting['force_update_d'] == 'yes')selected @endif>Yes</option>
                                                <option value="no" @if ($setting['force_update_d'] == 'no')selected @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="title">Promo Settings</h4>
                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Registration Bonus</label>
                                            <input type="text" name="registration_bonus" class="form-control border-input" placeholder="Registration Bonus" value="{{ $setting['registration_bonus'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-info btn-fill btn-wd">Update</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('app_gen.footer')
</div>



