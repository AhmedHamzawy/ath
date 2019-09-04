$(document).ready(function(){
$('.button-right').click(function(){
    $('.sidebar').toggleClass('fliph');
});

$('.dropdown-toggle').on('click', function (e) {
	$(this).next().toggle();
  });

  $('.navbar-nav>li>a').on('click', function(){
    $('.navbar-collapse').collapse('hide');
});

$(".fa-th").click(function () {
    $(this).toggleClass("fa-stop");
});

$(".carousel-control-next").css("left", "0");

var delay = 500;
$(".progress-bar").each(function(i){
    $(this).delay( delay*i ).animate( { width: $(this).attr('aria-valuenow') + '%' }, delay );

    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: delay,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now)+'%');
        }
    });
});


$('#printInvoice').click(function(){
    Popup($('.invoice')[0].outerHTML);
    function Popup(data) 
    {
        window.print();
        return true;
    }
});

});


