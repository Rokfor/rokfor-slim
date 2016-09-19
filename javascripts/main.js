$(function() {
  var wrap = $("#menu");
  console.log(wrap);
  $(document).on("scroll", function(e) {
    if ($(document).scrollTop() > 147) {
      wrap.addClass("fix");
    } else {
      wrap.removeClass("fix");
    }
  });
  
  $('#toggle').click(function() {
    $('#menu').toggleClass('toggled');
  })
});