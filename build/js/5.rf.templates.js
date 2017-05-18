// Template Editor Stuff

(function ($) {
  $.rokfor.initTemplates = function() {

    // Sorting: Chapters and Issues
  
    var fieldsortable = function(e) {
      e.sortable({
        forcePlaceholderSize: true,
        items       : 'div.panel',
        tolerance   : 'pointer',
        axis        : 'y',
        containment: 'parent',
        handle      : '.drag',
        cancel      : '',        
        sort: function(event, ui) {
            var $target = $(event.target);
        },



        stop: function() {
          var data = [];
          var sort = 0;
          var f = $(this);
          f.find('div.panel').each(function(e){
            data.push($(this).attr('id'));
            sort++;
          });      
          var templateid = f.parents('div.bookedit').attr('id');
          var url = "/rf/templates/field/sort/" + templateid;
          $.rokfor.post(url, data, function(data){
            console.log(data)
            $.rokfor.configschema = data.schema;
            $.rokfor.fieldspertemplate[templateid] = data.fieldinfo;
          });
        }
      })
    }
    fieldsortable($('div.sortable'));

    // Json Editor
    $('section.content').on('click', '.rfconfigopen', function(e) {
      // Loading Fields for this Template. Stored directly in HTML Code after Sortable
      var thisFields = $.rokfor.fieldspertemplate[$(this).parents('div.bookedit').attr('id')];
      // Loading current schema and overwrite fieldnames. They could have changed in teh meantime
      var schema = $.rokfor.configschema;
      schema.properties.lengthinfluence.items.properties.fieldname.enum = thisFields.id;
      schema.properties.lengthinfluence.items.properties.fieldname.options.enum_titles = thisFields.label;

      e.stopPropagation();
      var data = $(this).find('input');
      var value = $.parseJSON(data.val());
      var m = $('#rfaction_jsonedit').modal({keyboard: true});
      m.modal.data = data
      m.modal.editor = new JSONEditor($('#jsoneditor')[0], {
        schema: schema,
        theme: 'rokfor',
        disable_properties: true,
        disable_edit_json: true,
        disable_array_reorder: true,
        form_name_root: "Field Configuration",
        iconlib: "bootstrap3",
      });
      m.modal.editor.setValue(value);
      
      console.log(value);
      
      // Close Modal - store JSON
      $('#rfaction_jsonedit').find('button.rfmodal_continue').on('click', function(e) {
        e.stopPropagation();
        var m  = $(this).parents('.modal');
        var json = m.modal.editor.getValue();
        console.log(json);
        m.modal.data.val(JSON.stringify(json));
        m.modal('hide');
        m.modal.data.trigger('change');
      })
      // Destroy Editor on modal close
      m.on('hidden.bs.modal', function () {
        m.modal.editor.destroy();
      });
      return false;
    })        

    // Keyup: Either Add or Rename Template
  
    $('section.content').on('keyup', 'input.onchange', function(e) {
      // Add: Control Button
      if ($(this).attr('data-button')) {
        if ($(this).val() != "") {
          $($(this).attr('data-button')).removeClass('disabled')
        }
        else {
          $($(this).attr('data-button')).addClass('disabled')
        }
      }
      // Rename trigger post on change: Rename Template
      else {
        if ($(this).parents('.tab-pane').hasClass('name')) {
          var f    = $(this);
          var id   = f.parents('div.bookedit').attr('id');
          var url = "/rf/templates/rename/"+id;
          var val = f.val();
          $.rokfor.delay(function(){
            $.rokfor.post(url, val, function(data){
              $.rokfor.configschema = data.schema;
              f.parents('.nav-tabs-custom').find('li.header').html(val);
            });
          }, 1000, "r"+id );
        }
        else if ($(this).parents('.tab-pane').hasClass('fields')) {
          var f    = $(this);
          var id   = f.parents('.fieldtemplate').attr('id');
          var url = "/rf/templates/field/rename/"+id;
          var val = f.val();
          $.rokfor.delay(function(){
            $.rokfor.post(url, val, function(data){
              $.rokfor.configschema = data.schema;
              $.rokfor.fieldspertemplate[f.parents('div.bookedit').attr('id')] = data.fieldinfo;
            });
          }, 1000, "r"+id );
        }        
      }
    })
    
    // Template Form
    
    var templatemodify = function(e) {
      e.stopPropagation();
      var f    = $(this);
      var val  = f.parents('form.access').serializeArray();
      var id   = f.parents('div.bookedit').attr('id');
      var url = "/rf/templates/update/"+id;
      $.rokfor.delay(function(){
        $.rokfor.post(url, val, function(data){
          $.rokfor.configschema = data.schema;
          $(['books','formats','rights']).each(function(i,e){
            var b = f.parents('form.access').find('select.' + e)
            b.find('option').remove();
            $(data.template[e]).each(function(i,s) {
              b.append( $('<option></option>').val(s.id).html(s.name).attr('selected', s.selected))
            });
          })
        });
      }, 1000, "u"+id );
    }
    $('section.content').on('keyup', 'form.access input', templatemodify );
    $('section.content').on('change', 'form.access select, form.access textarea', templatemodify );
    $('section.content').on('click', 'form.access input[type=checkbox]', templatemodify );
    
    
    // Field Form
    
    var fieldmodify = function(e,d) {
      e.stopPropagation();
      var f    = $(this);
      var val  = f.parents('form.fields').serializeArray();
      var id   = f.parents('div.fieldtemplate').attr('id');
      var url  = "/rf/templates/field/update/"+id;

      if (e.data.delay === false) {
        f.parents('form.fields').find('button.rfconfigopen').attr("disabled", true);
        $.rokfor.post(url, val, function(data){
          f.parents('form.fields').find('input[type=hidden]').val(data.newconfig);
          f.parents('form.fields').find('button.rfconfigopen').removeAttr("disabled");
        });
      }
      else {
        $.rokfor.delay(function(){
          $.rokfor.post(url, val, function(data){
            // Store new settings in configuration button. probably changed
            // the field type
            f.parents('form.fields').find('input[type=hidden]').val(data.newconfig);
          });
        }, 1000, "u"+id );
      }
    }
    $('section.content').on('keyup', 'form.fields input', {delay:true}, fieldmodify );
    $('section.content').on('change', 'form.fields select', {delay:false}, fieldmodify );
    $('section.content').on('change', 'form.fields input[type=hidden]', {delay:false}, fieldmodify );    
    
    
    // Klicks: Template Actions

    $('section.content').on('click', '.templateaction', function(e) {
      e.stopPropagation();
      var bt = $(this);     // Button Reference
      var action = false;   // Button Action depending on class
      var val = false;      // Post Value
      var id = false;       // Book Id for Child actions

      // Tabbed Pane Load
      if (bt.parents('.bookedit').length > 0) {
        id   = bt.parents('.bookedit').attr('id');
      }
      // Action Switch based on colors
      if (bt.hasClass('btn-danger')) {
        action = "delete";
      }
      else if (bt.hasClass('btn-warning')) {
        action = "duplicate";
      }    
      else if (bt.hasClass('btn-success')) {
        action = "add";
        val = $(bt.attr('data-input')).val();
      }

      var url = "/rf/templates/"+action+(id ? "/"+ id : '');

      // Is Post
      $.rokfor.spinner.show();
      if (val) {
        $.rokfor.post(url, val, function(data){
          $('.content-wrapper#list').html(data);
          $.rokfor.spinner.hide();
        });      
      }
      // Is Get
      else {
        $.rokfor.get(url, function(data){
          $('.content-wrapper#list').html(data);
          $.rokfor.spinner.hide();
        });      
      }      
      return false;
    });
    
    // Klicks: Field Actionds

    $('section.content').on('click', '.fieldaction', function(e) {
      e.stopPropagation();
      var bt = $(this);     // Button Reference
      var action = false;   // Button Action depending on class
      var val = false;      // Post Value
      var id = false;       // Book Id for Child actions

      // Tabbed Pane Load
      if (bt.parents('.fieldtemplate').length > 0) {
        id   = bt.parents('.fieldtemplate').attr('id');
      }
      // Action Switch based on colors
      if (bt.hasClass('btn-danger')) {
        action = "delete";
      }
      else if (bt.hasClass('btn-warning')) {
        action = "duplicate";
      }    
      else if (bt.hasClass('btn-success')) {
        action = "add";
        id = bt.parents('div.bookedit').attr('id');
        val = $(bt.attr('data-input')).val();
      }

      var target = bt.parents('div.bookedit');

      var url = "/rf/templates/field/"+action+(id ? "/"+ id : '');

      // Is Post
      $.rokfor.spinner.show();
      if (val) {
        $.rokfor.post(url, val, function(data){
          target.html(data);
          $.rokfor.spinner.hide();          
          fieldsortable(target.find('div.sortable'));
        });      
      }
      // Is Get
      else {
        $.rokfor.get(url, function(data){
          target.html(data);
          $.rokfor.spinner.hide();
          fieldsortable(target.find('div.sortable'));
        });      
      }      
      return false;
    });    
    
  }
})(jQuery);


