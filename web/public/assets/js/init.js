(function($){
  $(function(){

    $('.responsive').slick({
      dots: true,
      infinite: false,
      arrows: false,
      centerMode: true,
      slidesToShow: 3.5,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            dots: false,
            centerMode: false,
            slidesToShow: 1.2,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

  }); // end of document ready
})(jQuery); // end of jQuery name space