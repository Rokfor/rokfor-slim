// Structure Stuff

(function ($) {
  $.rokfor.initStructure = function() {

    // Sorting: Books

    $('div.sortable').sortable({
      forcePlaceholderSize: true,
      items       : '.bookedit',
      axis        : 'y',
      tolerance   : 'pointer',
      containment: 'parent',
      sort: function(event, ui) {
          var $target = $(event.target);
      },
      stop: function() {
        var data = [];
        var sort = 0;
        $(this).find('.bookedit').each(function(e){
          data.push($(this).attr('id'));
          sort++;
        });
        var url = "/rf/structure/sort/book";
        $.rokfor.post(url, data, function(){
          $('#rfmenu').load('/rf/menu');
        });
      }
    })

    // Sorting: Chapters and Issues

    var tabbedsortable = function(e) {
      e.sortable({
        forcePlaceholderSize: true,
        cancel      : '',
        items       : 'tr',
        tolerance   : 'pointer',
        axis        : 'y',
        containment : 'parent',
        handle      : '.drag',
        sort: function(event, ui) {
            var $target = $(event.target);
        },
        stop: function() {
          var data = [];
          var sort = 0;
          $(this).find('tr').each(function(e){
            data.push($(this).attr('id'));
            sort++;
          });
          var type = $(this).parents('.tab-pane').hasClass('chapter') ? 'chapter'
                                                                         : ($(this).parents('.tab-pane').hasClass('issue') ? 'issue'
                                                                                                                           : 'book')
          var url = "/rf/structure/sort/" + type;
          $.rokfor.post(url, data, function(){
            $('#rfmenu').load('/rf/menu');
          });
        }
      })
    }
    tabbedsortable($('tbody.sortable'));


    // Keyup: Either Add or Rename

    $('section.content').on('keyup', 'input', function(e) {
      // Add: Control Button
      if ($(this).attr('data-button')) {
        if ($(this).val() != "") {
          $($(this).attr('data-button')).removeClass('disabled')
        }
        else {
          $($(this).attr('data-button')).addClass('disabled')
        }
      }
      // Rename trigger post on change
      else {
        if ($(this).parents('.tab-pane')) {
          var f    = $(this);
          var id   = f.parents('.idcontainer').attr('id');
          var type = f.parents('.tab-pane').hasClass('chapter') ? 'chapter'
                     :(f.parents('.tab-pane').hasClass('issue') ? 'issue'
                                                                : 'book')
          var url = "/rf/structure/rename/"+type+"/"+id;
          var val = f.val();
          $.rokfor.delay(function(){
            $.rokfor.post(url, val, function(){
              if (type=='book') {
                f.parents('.nav-tabs-custom').find('li.header').html(val);
              }
              $('#rfmenu').load('/rf/menu');
            });
          }, 1000, id );
        }
      }
    })

    // Klicks

    $('section.content').on('click', 'a.changestate, a.btn, button.btn:not(.dropdown-toggle)', function(e) {
      e.stopPropagation();
      var bt = $(this);     // Button Reference
      var action = false;   // Button Action depending on class
      var val = false;      // Post Value
      var id = false;       // Book Id for Child actions
      var type = false;     // Chapter, Issue or Book

      // Tabbed Pane Load
      if (bt.parents('.tab-pane').length > 0) {
        id   = bt.parents('.idcontainer').attr('id');
        type = bt.parents('.tab-pane').hasClass('chapter')       ? 'chapter'
               : ($(this).parents('.tab-pane').hasClass('issue') ? 'issue'
               :                                                   'book')
      }
      // Book Load (only add)
      else {
        type = 'book';
      }

      // Ajax Target
      var target  = type == 'book' ? $('.content-wrapper#list') : bt.parents('div.bookedit');

      if (bt.hasClass('btn-danger')) {
        action = "delete";
      }
      else if (bt.hasClass('btn-warning')) {
        action = "duplicate";
      }
      else if (bt.hasClass('btn-success')) {
        id = bt.parents('div.bookedit').attr('id');
        action = "add";
        val = $(bt.attr('data-input')).val();
      }
      else if (bt.hasClass('changestate')) {
        action = bt.attr("href");
      }
      else if (bt.hasClass('rights')) {
        action = bt.attr("href");
        var data = JSON.parse(bt.attr("data-rights"));
        $('#rfaction_rights').find('option').prop('selected', false);
        $(data).each(function(e,v) {
          $('#rfaction_rights').find('option#select_' + v).prop('selected', true);
        })
        var m = $('#rfaction_rights').modal({keyboard: true});
        m.modal.data = {
          action: action,
          id: id,
          type: type,
          caller: bt
        }
        return false;
      }
      else if (bt.hasClass('settingschapter') || bt.hasClass('settingsissue') || bt.hasClass('settingsbook')) {
        // Filtering Parents of Book Only
        var schema = {};

        if (bt.hasClass('settingschapter')) {
          schema = $.rokfor.configschema_chapter;
          var _book = schema.properties.parentnode.bookbyid[id];
          schema.properties.parentnode.enum = schema.properties.parentnode.idbybook[_book];
          schema.properties.parentnode.options.enum_titles = schema.properties.parentnode.labelsbybook[_book];
        }
        else if (bt.hasClass('settingsissue')) {
          schema = $.rokfor.configschema_issue;
        }
        else if (bt.hasClass('settingsbook')) {
          schema = $.rokfor.configschema_book;
        }

        var value = bt.attr("data-rights") ? JSON.parse(bt.attr("data-rights")) : {};
        var m = $('#rfaction_jsonedit_chapter').modal({keyboard: true});
        action = bt.attr("href");
        m.modal.data = {
          action: action,
          id: id,
          type: type,
          caller: bt
        }
        m.modal.editor = new JSONEditor($('#jsoneditor_chapter')[0], {
          schema: schema,
          theme: 'rokfor',
          disable_properties: true,
          disable_edit_json: true,
          disable_array_reorder: true,
          form_name_root: "Field Configuration",
          iconlib: "bootstrap3",
        });
        m.modal.editor.setValue(value);
        return false;
      }


      var url = "/rf/structure/"+action+(type ? "/"+ type : '')+(id ? "/"+ id : '');

      // Is Post
      $.rokfor.spinner.show();
      if (val) {
        $.rokfor.post(url, val, function(data){
          $.rokfor.spinner.hide();
          target.html(data);
          if (type != 'book') {
            tabbedsortable(target.find('tbody.sortable'));
            $('#rfmenu').load('/rf/menu');
          }
        });
      }
      // Is Get
      else {
        $.rokfor.get(url, function(data){
          $.rokfor.spinner.hide();
          target.html(data);
          if (type != 'book') {
            tabbedsortable(target.find('tbody.sortable'));
            $('#rfmenu').load('/rf/menu');
          }
        });
      }
      return false;
    });

    // Close Modal - store JSON
    $('#rfaction_jsonedit_chapter').find('button.rfmodal_continue').on('click', function(e) {
      e.stopPropagation();
      var m  = $(this).parents('.modal');
      var json = JSON.stringify(m.modal.editor.getValue());
      var url = "/rf/structure/"+m.modal.data.action+(m.modal.data.type ? "/"+ m.modal.data.type : '')+(m.modal.data.id ? "/"+ m.modal.data.id : '');
      $.rokfor.post(url, json, function(data){
        m.modal.data.caller.attr("data-rights", json)
        m.modal('hide');
      });
    })
    // Destroy Editor on modal close
    $('#rfaction_jsonedit_chapter').on('hidden.bs.modal', function () {
      var m = $(this);
      console.log("destroy", m.modal)
      m.modal.editor.destroy();
    });



    // Close Modal - store JSON
    $('#rfaction_rights').find('button.rfmodal_continue').on('click', function(e) {
      e.stopPropagation();
      var m  = $(this).parents('#rfaction_rights');
      var url = "/rf/structure/"+m.modal.data.action+(m.modal.data.type ? "/"+ m.modal.data.type : '')+(m.modal.data.id ? "/"+ m.modal.data.id : '');
      var val = m.find('select').serializeArray();
      var newval = [];
      for (var n in val) {
        if (val.hasOwnProperty(n)) {
          newval.push(val[n].value)
        }
      }
      console.log(url, val, newval)
      $.rokfor.post(url, val, function(data){
        m.modal.data.caller.attr("data-rights", JSON.stringify(newval))
      });
      m.modal('hide');
    })

  }
})(jQuery);
