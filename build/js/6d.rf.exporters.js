// Route Hooks Stuff

(function ($) {
  $.rokfor.initExporters = function() {
    $(".rfselect")
      .select2()
      .on("change", function(e){
        var href = $(this).attr('data-mode') + "/" + $(this).val()
        e.preventDefault();
        //Perform ajax call
        $.rokfor.get(href, function(data){
          $(".content-wrapper#detail").html(data);
          $.rokfor.showDetail();
        })
        return false;


      });
  }
})(jQuery);
