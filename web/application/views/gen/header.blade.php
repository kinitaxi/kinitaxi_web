<nav class="navbar navbar-expand-lg bg-white fixed-top ">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="{{ site_url() }}" rel="tooltip" title="Kinitaxi Home" data-placement="bottom">
                <img src="{{ base_url().'img/kini.png' }}" style="width:20%;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" data-color="orange">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ site_url().'home/choose' }}">
                        <i class="now-ui-icons objects_support-17"></i>
                        <p>Why Choose KiniTaxi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary" href="http://blog.kinitaxi.com/drive-with-kini" target="_blank">
                        <p>Drive for KiniTaxi</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
