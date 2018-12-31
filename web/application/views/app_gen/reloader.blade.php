<script>
    //determine which page user was on ajax
    var base_url = window.location.origin;
    if (base_url == 'http://localhost')
        base_url = 'http://localhost/kinitaxi/web/';
    else
        base_url = base_url + '/';

    console.log(base_url);

    var  l = window.location;

    if (l.toString().indexOf('app/') !== -1 && sessionStorage.getItem('appState') !== 'clicked'){

        //know where to start cut from
        var from = l.toString().indexOf(('app/')),
                to = l.toString().length;

        page = l.toString().slice(from + 4, to);

        sessionStorage.setItem('page', page);

        window.location = base_url + 'app'
    }
</script>