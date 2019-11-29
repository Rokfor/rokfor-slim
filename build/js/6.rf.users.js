// Profile Page Stuff

(function ($) {
  $.rokfor.initUsers = function() {


    // Modals

    var usermodal = $('#usermodal');
    var groupmodal = $('#groupmodal');
    var tablestandards = {
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "select": false,
        "dom": '',
      };

    var initUsersTable = function(t) {
      var table = $(t).DataTable(tablestandards);

      $(t).parents('.box').find('input.search').keyup(function(){
        table.search($(this).val()).draw() ;
      });
      $(t).parents('.box').find(".paginate_left").click(function(){
        table.fnPageChange( 'previous' );
      });
      $(t).parents('.box').find(".paginate_right").click(function(){
        table.fnPageChange( 'next' );
      });
      $(t).find('a.btn-danger').click(function(e) {
        e.stopPropagation();
        if ($(this).attr('data-modal') == '#usermodal') {
          $.rokfor.get("/rf/user/delete/" + $(this).parents('tr').find('td:first-child').text(), function(data){
              console.log("repopulate user table here")
              $('table#userstable').parent('.box-body').html(data);
              initUsersTable('table#userstable');
          });
        }
        if ($(this).attr('data-modal') == '#groupmodal') {
          $.rokfor.get("/rf/group/delete/" + $(this).parents('tr').find('td:first-child').text(), function(data){
              console.log("repopulate group table here")
              $('table#groupstable').parent('.box-body').html(data);
              initUsersTable('table#groupstable');
          });
        }
        return false;
      })
      $(t).find('a.btn-warning').click(function(e) {
        e.stopPropagation();
        if ($(this).attr('data-modal') == '#usermodal') {
          $.rokfor.get("/rf/user/" + $(this).parents('tr').find('td:first-child').text(), function(data){
            usermodal.checkpw = false;
            usermodal.password = true;
            usermodal.populate(data.user, function(){usermodal.modal({keyboard: true})});
          });
        }
        if ($(this).attr('data-modal') == '#groupmodal') {
          $.rokfor.get("/rf/group/" + $(this).parents('tr').find('td:first-child').text(), function(data){
            groupmodal.populate(data.groups);
            groupmodal.modal({keyboard: true});
          });
        }
        return false;
      })
    }

    // Populate functions

    usermodal.populate = function(data, callback) {
      $(this).find('#userid').val(data.id || "");
      $(this).find('#user').val(data.username || "");
      $(this).find('#nemail').val(data.email || "");
      $(this).find('#npassword').val(data.password || "");

      $(this).find('#api').val(data.api || "");
      $(this).find('#rwapi').val(data.rwapi || "");
      $(this).find('#acl').val(data.acl || "");
      $(this).find('#corsget').val(data.corsget || "");
      $(this).find('#corspostdelput').val(data.corspostdelput || "");

      $(this).find('#assetdomain').val(data.assetdomain || "");
      $(this).find('#assetkey').val(data.assetkey || "");

      $(this).find('#role option').each(function() {
        $(this).prop('selected', data.role && (data.role == $(this).attr('value')));
      })
      var groups = $(this).find('#group');
      groups.find('option').remove();
      $(data.group).each(function(i,s) {
        groups.append( $('<option></option>').val(s.id).html(s.name).attr('selected', s.selected))
      });
      $('.select2').select2();
      if (callback) {
        callback()
      }
    }

    groupmodal.populate = function(data, callback) {
      callback = callback || function(){};
      var rbooks = $(this).find('#rbook');
      var rformats = $(this).find('#rformat');
      var rissues = $(this).find('#rissue');
      var rtemplates = $(this).find('#rtemplate');
      // This is only done if initial data is passed
      if (typeof data == "object") {
        groupmodal.data = data; // Store cache here
        var rusers = $(this).find('#ruser');
        $(this).find('#groupid').val(data.id || "");
        $(this).find('#group').val(data.name || "");
        rusers.find('option').remove();
        $(groupmodal.data.users).each(function(i,s) {
          rusers.append( $('<option></option>').val(s.id).html(s.name).attr('selected', s.selected))
        });
      }

      // Repopulating from cached data
      rbooks.find('option').remove();
      rformats.find('option').remove();
      rissues.find('option').remove();
      rtemplates.find('option').remove();

      $(groupmodal.data.books).each(function(i,s) {
        rbooks.append( $('<option></option>').val(s.id).html(s.name).attr('selected', s.selected))
        if (s.selected) {
          $(s.formats).each(function(i,f) {
            rformats.append( $('<option></option>').val(f.id).html(f.name).attr('selected', f.selected))
            if (f.selected) {
              $(f.templates).each(function(i,t) {
                rtemplates.append( $('<option></option>').val(t.id).html(t.name).attr('selected', t.selected))
              });
            }
          });
          $(s.issues).each(function(i,f) {
            rissues.append( $('<option></option>').val(f.id).html(f.name).attr('selected', f.selected))
          });
        }
      });

      if (typeof data == "object") {
        $('.select2').select2();
      }
      if (callback) {
        callback()
      }
    }

    // Reload Modal Settings after Book Change
    groupmodal.find('#rbook, #rformat').change(function(e) {

      // Activate selected books
      var bookselector = $('#rbook').serializeArray();
      var formatselector = $('#rformat').serializeArray();
      console.log(bookselector,formatselector);

      $(groupmodal.data.books).each(function(i,s) {
        var book = this
        book.selected = false;
        $(bookselector).each(function(){
          if (book.id == this.value) book.selected = true;
        })
        $(book.formats).each(function(){
          var format = this;
          format.selected = false;
          $(formatselector).each(function(){
            if (format.id == this.value) format.selected = true;
          })
        })
      });
      // Repopulate Selectors if book has changed
      groupmodal.populate(false, function() {
        $('#rformat, #rissue, #rtemplate').select2();
      });
    })

    // Sorting: Chapters and Issues
    // Activating List Table

    $('table#userstable, table#groupstable').each(function(e){
      initUsersTable(this)
    })

    $('section.content').on('click', '#useradd', function(e) {
      e.stopPropagation();
      $.rokfor.get("/rf/user/new", function(data){
        usermodal.checkpw = true;
        usermodal.populate(data.user, function(){usermodal.modal({keyboard: true})});
      });
      return false;
    });

    $('section.content').on('click', '#groupadd', function(e) {
      e.stopPropagation();
      $.rokfor.get("/rf/group/new", function(data){
        groupmodal.populate(data.groups);
        groupmodal.modal({keyboard: true});
      });
      return false;
    });

    $('#usermodal').on('click', '.apigen', function (e) {
      e.preventDefault();
      $(this).parents('.input-group').find('input').val($.rokfor.hat());
      return false;
    });

    // Close User Modal - store JSON
    usermodal.find('button.rfmodal_continue').on('click', function(e) {
      e.stopPropagation();
      var url = "/rf/user" + (usermodal.find('#userid').val() ? "/" + usermodal.find('#userid').val() : "");
      var val = usermodal.find('form').serializeArray();
      $.rokfor.post(url, val, function(data){
        usermodal.modal('hide');
        console.log("repopulate user table here")
        $('table#userstable').parent('.box-body').html(data);
        initUsersTable('table#userstable')
      });
    })

    // Close User Modal - store JSON
    groupmodal.find('button.rfmodal_continue').on('click', function(e) {
      e.stopPropagation();
      var url = "/rf/group" + (groupmodal.find('#groupid').val() ? "/" + groupmodal.find('#groupid').val() : "");
      var val = groupmodal.find('form').serializeArray();
      $.rokfor.post(url, val, function(data){
        groupmodal.modal('hide');
        console.log("repopulate group table here")
        $('table#groupstable').parent('.box-body').html(data);
        initUsersTable('table#groupstable')
      });
    })

  }
})(jQuery);
