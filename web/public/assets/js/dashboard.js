(function (win) {
    var doc = win.document,
        l = win.location;
    var baselink = 'http://localhost/schoolshepherd/';
    const basePath = baselink + 'public/assets/';
    $O.test('#noty').wait(function () {
        $noty = $('#noty');
        noty({
            theme: 'app-noty',
            text: $noty.data('message'),
            type: $noty.data('type'),
            timeout: 10000,
            layout: 'topRight',
            closeWith: ['button', 'click'],
            animation: {open: 'animated fadeInDown', close: 'animated fadeOutUp'}
        });
    });
})(window);


