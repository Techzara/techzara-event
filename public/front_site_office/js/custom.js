$(document).ready(function(){

    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });

  /*Footer link to boxes*/
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : sParameterName[1];
          /*setTimeout(function(){
              $('html, body').stop().animate({
                  scrollTop: $('#'+reference_poste).offset().top-100});
              return sParameterName[1] === undefined ? true : sParameterName[1];
          },1500);*/

      }
    }
  };

  var reference_poste = getUrlParameter('idref');
  if(reference_poste == 'sitevitrine' || reference_poste == 'ecommerce' || reference_poste == 'webapp' || reference_poste == 'environement'){
    $('html, body').stop().animate({
      scrollTop: $('#'+reference_poste).offset().top - 100
    },1000);
  }

$('#cometengage').addClass('front_site');


});