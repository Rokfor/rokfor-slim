// Profile Page Stuff

(function ($) {
  $.rokfor.initProfile = function() {

    // Sorting: Chapters and Issues
    $('section.content').on('click', 'button', function (e) {
      e.preventDefault();
      var form = $(this).parents('form');
      var val  = form.serializeArray();
      $.rokfor.post("/rf/profile", val, function(data){
        form.find('input:password').val('');
        if (data.error) {
          $('#rfaction_error').find('.modal-title').html(data.error);
          $('#rfaction_error').find('.modal-body').html(data.message);
          $('#rfaction_error').modal({keyboard: true});
        }
        else if (data.success) {
          $('#rfaction_success').find('.modal-title').html(data.success);
          $('#rfaction_success').find('.modal-body').html(data.message);
          $('#rfaction_success').modal({keyboard: true});
        }
      });
      return false;
    });
    
    $('section.content').on('click', '.apigen', function (e) {    
      e.preventDefault();
      $(this).parents('.input-group').find('input').val($.rokfor.hat());
      return false;
    });
    
  
    
  }
})(jQuery);


