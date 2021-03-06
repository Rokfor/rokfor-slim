// Route Hooks Stuff

(function ($) {
  $.rokfor.initRouteHooks = function() {
    // Modals
    var addmodal = $('#addmodal');

    $('section.content').on('click', '.btn-danger', function (e) {
      e.preventDefault();
      var button = $(this);
      $.rokfor.post(button.attr('href'), 'Delete', function(data){
        $('section.content').html(data);
      });
    });

    $('section.content').on('click', '#routeadd', function(e) {
      e.stopPropagation();
      addmodal.modal({keyboard: true});
      return false;
    });

    // Close User Modal - store JSON
    addmodal.find('button.rfmodal_continue').on('click', function(e) {
      e.stopPropagation();
      var val = addmodal.find('form').serializeArray();
      $.rokfor.post('/rf/routehooks', val, function(data){
        addmodal.modal('hide');
        $('section.content').html(data);
      });
    })

  }
})(jQuery);
