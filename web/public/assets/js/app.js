(function (win) {
    var doc = win.document,
        l = win.location;
    var base_url = window.location.origin;
    if (base_url == 'http://localhost')
        base_url = 'http://localhost/kinitaxi/web/';
    else
        base_url = base_url + '/';




    //checks to see if the page was reloaded
    var page = sessionStorage.getItem('page');

    //if it was reloaded, check the former page user was on

    if (page !== null){

        //construct full link
        var full_path = base_url + 'app/' + page,
            side = page.toString().slice(0,4);

        //then load the new page using ajax
        NProgress.start();
        jQuery.ajax({
            type: "GET",
            url: full_path,
            data: {
            },
            success: function (data) {

                $('.wrapper').html(data);

                $('.li').removeClass('active');
                $('#'+side).addClass('active');
                $('#'+side+'_s').addClass('active');

                NProgress.done();

                if(window.location != full_path){
                    var obj = {Page: 'page', Url: full_path};
                    history.pushState(obj, obj.Page, obj.Url);
                }
                load_javascript();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Something went wrong, contact admin');

                NProgress.done();
            }
        });



    }


    function send_data(action, data, method, redirect) {
        NProgress.start();
        jQuery.ajax({
            type: method,
            url: action,  //send to ajax controller
            data: data,
            success: function (result) {

                //determines what response to show user
                if (result.indexOf('Log In') > -1) {

                    //checks if server responded with login page meaning, user is logged out
                    location.reload();
                }
                else if (result == 'failed'){
                    show_message('error', 'Something went wrong, please contact admin');
                }
                else {

                    show_message('success', result);

                    if (redirect != false){

                        //redirects app to load new page
                        load_page(redirect, '');
                    }
                }
                NProgress.done();
            },
            error: function (xhr) {
                alert(xhr.responseText)
            }
        });
    }

    //for showing messages on the dashboard
    function show_message(type, message){
        new Noty({
            layout   : 'topRight',
            type: type,
            theme    : 'mint',
            timeout: 10000,
            force: true,
            closeWith: ['click', 'button'],
            text: message
        }).show();
    }

    //for loading new ajax pages
    function load_page(href, type){

        //redirects app to load new page

        //save state of app as reloaded
        sessionStorage.setItem('appState', 'clicked');

        NProgress.start();
        jQuery.ajax({
            type: "GET",
            url: href,
            data: {
            },
            success: function (data) {

                $('.wrapper').html(data);

                //remove all active classes
                $('li').removeClass('active');
                var $menuItemID = sessionStorage.getItem('current');
                $('#'+$menuItemID).addClass('active');

                NProgress.done();

                if(window.location != href){
                    var obj = {Page: 'page', Url: href};
                    history.pushState(obj, obj.Page, obj.Url);
                }

                //save state of app to reloaded possibility
                sessionStorage.setItem('appState', 'reloaded');

                load_javascript();
            },
            error: function (xhr) {

                alert('Something went wrong, contact admin');
                NProgress.done();

                //save state of app to reloaded possibility
                sessionStorage.setItem('appState', 'reloaded');
            }
        });
    }


    function load_javascript(){

        //for processing all form submit
        $('form').each(function(){

            var $form = $(this).closest('form'),
                $formAction = $form.attr('action'),
                $formMethod = $form.attr('method'),
                $formRedirect = false;

            $form.submit(function(e) {

                //gets the form data as object for sending
                var $formData = $form.serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});

                e.preventDefault();

                //checks if it should redirect or reload after completing submit the page
                if( $form.data().hasOwnProperty("redirect") ){
                    $formRedirect = $form.data('redirect');
                }

                //send to ajax
                send_data($formAction, $formData, $formMethod, $formRedirect);

            });
        });

        $('.ajax-load').each(function(){
            $(this).click(function(){

                var element = $(this);

                //loads data of clicked item on table
                load_page(element.data('href'),'');
            })
        });

        $('.ajax-action').each(function(){
            $(this).click(function(){

                var element = $(this);

                //loads data of clicked item on table
                send_data(element.data('href'), '', 'GET', element.data('redirect'))
            })
        });

        $('.sidebar-link').each(function(){
            $(this).click( function(){

                var element = $(this);

                //save last clicked item
                sessionStorage.setItem('current', element.parent().attr('id'));

                //loads full page of sidebar
                load_page(element.data('href'),'');
            });
        });

        //////////////
        $('.star-rating').each(function(){
            var $star_rating = $(this).find('.fa');
            $star_rating.each(function() {
                if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                    return $(this).removeClass('fa-star-o').addClass('fa-star');
                } else {
                    return $(this).removeClass('fa-star').addClass('fa-star-o');
                }
            })
        });

        /////////////
        $('.withdraw-btn').each(function(){
            $(this).click(function (){
            var initiator = $(this);
            var paid = initiator.closest('td').find('.sent');
            initiator.prop('disabled', true);
            NProgress.start();
            jQuery.ajax({
                type: "POST",
                url: base_url + "app/process_withdrawal",
                data: {
                    "payment_id": $(this).data('id'),
                    "amount": $(this).data('amount')
                },
                success: function (data) {
                    if (data == 'sent'){
                        initiator.addClass('hidden');
                        paid.removeClass('hidden');

                        show_message('success','Sent to driver successfully');
                    }
                    else{

                        show_message('error', data);
                        initiator.prop('disabled', false);
                    }
                    NProgress.done();
                },
                error: function (xhr) {
                    initiator.prop('disabled', false);
                    alert('Something went wrong, contact admin');
                    NProgress.done();
                }
            });
        })
        });

        /////////////
        $('.collect-btn').each(function(){
            $(this).click(function (){
            var initiator = $(this);
            var paid = initiator.closest('td').find('.collected');
            initiator.prop('disabled', true);
            NProgress.start();
            jQuery.ajax({
                type: "POST",
                url: base_url + "app/collect_payment",
                data: {
                    "user_id": $(this).data('id'),
                    "amount": $(this).data('amount')
                },
                success: function (data) {
                    if (data == 'collected'){
                        initiator.addClass('hidden');
                        paid.removeClass('hidden');

                        show_message('success','Payment collected successfully');
                    }
                    else{

                        show_message('error', data);
                        initiator.prop('disabled', false);
                    }
                    NProgress.done();
                },
                error: function (xhr) {
                    initiator.prop('disabled', false);
                    alert('Something went wrong, contact admin');
                    console.log(xhr.responseText);
                    NProgress.done();
                }
            });
        })
        });

        /////////////
        $O.test('.ticket').wait(function(){
            $('.main-panel').scroll(function() {

                //detach scroll
                if ($('.main-panel').scrollTop() > $('#sticky-anchor').offset().top){
                    $('#ticket-content').addClass('sticky');
                }
                else
                    $('#ticket-content').removeClass('sticky');
            });
            $('.ticket').each(function(){

                $(this).click(function (){

                    var parent = $(this).parent();
                    var template = parent.find('template');

                    $('.ticket-details').html(template.html());

                });

            });
        })
    }



})(window);

