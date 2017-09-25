// Contribution Stuff

(function ($) {
  $.rokfor.initContribution = function() {

    // Location Picker

    $('.rfpicker').each(function(i,n) {
      var picker = $(this);
      picker.locationpicker({
        location: {latitude: picker.attr('data-lat'), longitude: picker.attr('data-long')},
        radius: 10,
        enableReverseGeocode: true,
        enableAutocomplete: true,
        inputBinding: {
          locationNameInput: picker.parents('div.form-group').prev().find('input.location'),
          latitudeInput: picker.parents('div.form-group').prev().find('input.lat'),
          longitudeInput: picker.parents('div.form-group').prev().find('input.long')
        },
        oninitialized: function() {
          picker.locationpicker('autosize');
        },
        onchanged: function(currentLocation, radius, isMarkerDropped) {
          $.rokfor.contribution.store(picker.attr('id'), JSON.stringify([currentLocation.latitude,currentLocation.longitude]));
        }
      })
    });

    // File Upload

    $('.rfuploader').each(function(i,n) {
      var uploader = $(this);
      var supress_submission = false;
      uploader.dmUploader({
        url: '',
        dataType: 'json',
        allowedTypes: '*',
        extraData: {},
        onBeforeUpload: function(queue,settings){
          // Tweak here: Setting upload url per field id and set csrf string
          settings.url = '/rf/field/' + this.attr('id');
          settings.extraData = {
            csrf_name:  $.rokfor.csrf_name,
            csrf_value: $.rokfor.csrf_value,
            data: JSON.stringify({action: "add"})
          };
          $.rokfor.progressbar.init();
          uploader.closest('.box').find('.overlay').css('display','block');
        },

        onUploadProgress: function(id, percent){
          var percentStr = percent + '%';
          $.rokfor.progressbar.set(percent/100);
        },
        onUploadSuccess: function(id, data){
          $.rokfor.progressbar.hide();
          uploader.closest('.box').find('.overlay').css('display','none');
          // Update csrf string
          $.rokfor.csrf_name  = data.name;
          $.rokfor.csrf_value = data.value;
          if (data.success) {
//            var t = this.next().find('table').DataTable();
            table.positions = false;
            var template = [];
            template.push(data.newindex);
            template.push('<a class="rfimagetablepreview" href="' + data.relative + '?backend=true" target="_blank"><img data-file="' + data.original + '" src="' + data.thumb + '?backend=true"></a>');
            for (var i = 0; i < table.columns().nodes().length - 2; i++) {
              if (typeof data.caption == "object" && data.caption[i])
                template.push(data.caption[i]);
              else
                template.push(data.caption);
            }
            supress_submission = true;
            if (data.growing) {
              table.row.add(template).draw();
            }
            else {
              if (table.row( 0 ) == undefined || table.row( 0 ).length == 0)
                table.row.add(template).draw();
              else
                table.row( 0 ).data(template).draw();
            }
          }
        },
        onUploadError: function(id, message){
          $.rokfor.progressbar.hide();
          uploader.closest('.box').find('.overlay').css('display','none');
          console.log("Upload Error", id, 'error', message);
        }
      });



      var serialize = function(){};

      var table = uploader.next('.box-footer').find('table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "rowReorder": {
          selector: 'td:first-child',
          update: true
        },
        "info": false,
        "drawCallback": function( settings ) {
          if (supress_submission === true) {
            supress_submission = false;
          }
          else {
            serialize(true);
          }
        },
        "autoWidth": false,
        "dom": 'rtp',
        "columnDefs": [
                        {
                          "targets": 0,
                          "defaultContent": '',
                          "render": function(data) {
                            return ('<span class="rowhandle btn btn-xs fa fa-bars">' + data + '</span>');
                          },
                          "orderDataType": "dom-span-text",
                          "width": "0.1em"
                        },
                        {
                          "targets": 1,
                          "defaultContent": '',
                          "render": function(data) {
                            return (data);
                          },
                          "width": "80px"
                        },
                        {
                          "targets": -1,
                          "defaultContent": '',
                          "render": function(data) {
                            return ('<a class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>');
                          },
                          "width": "0.1em"
                        },
                        {
                          "targets": '_all',
                          "defaultContent": '',
                          "render": function(data) {
                            return ('<textarea name="caption[][]" class="rowedit">' + data + '</textarea>');
                          },
                          "width": "auto"
                        }
                      ]
        })
        .on('click', 'a.btn-danger', function(e){
            e.stopPropagation();
            var row = table.row($(this).parents('tr'));
            row.remove().draw();
            return false;
        })
        .on('click', 'a.rfimagetablepreview', function(e){
          e.stopPropagation();
        })
        .on('mousedown', 'a.rfimagetablepreview', function(e){
          e.stopPropagation();
        })
        .on('keyup', 'textarea', function(e){
          $(this).next().html($(this).val());
          e.stopPropagation();
          serialize(false)
          return false;
        });

        var serialize = function(force) {
          force = force || false;   // Force: Store without timeout
          // Output the data for the visible rows to the browser's console
//          var api = tbl.api();
//          console.log( table.rows().data() );
//          var data = table.$('img, textarea').serialize();
//          console.log(data)

          var cols = table.columns().nodes().length;
          var d = [];
          var row_pointer;
          var oldrow;

          table.cells().every( function ( rowIdx, cellIdx) {
            if (rowIdx !== oldrow) {
              row_pointer = row_pointer + 1 || 0;
            }
            d[row_pointer] = d[row_pointer] || [];
            if (cellIdx > 0) {
              if (cellIdx==1) {
                d[row_pointer][1] = $(this.node()).find('img').attr('data-file') || false;
//                console.log($(this.node()).find('img').attr('data-file'));
              }
              else {
                // Storing captions: either in d[0] as string or array if multiple legends are selected
                if (cellIdx < cols - 1) {
                  var v = $(this.node()).find('textarea').val() || false;
                  // If rows have more than 4 cols there must be
                  // multiple captions
                  if (cols>4) {
                    d[row_pointer][0] = d[row_pointer][0] || [];
                    d[row_pointer][0][cellIdx-2] = v;
                  }
                  else {
                    d[row_pointer][0] = v;
                  }
                }
              }
            }
            oldrow = rowIdx;
          });

          $.rokfor.contribution.store(
            uploader.attr('id'),
            JSON.stringify({
              action: "modify",
              data: d
            }),
            false,
            force ? 1 : 2000
          );
        }

        /*
      var serialize = function(tbl, diff, force) {
        force = force || false;   // Force: Store without timeout
        diff  = diff || false;    // Delta after Re-Sort
        // Re-Sort if diff has more than 0 elements
        tbl.positions = tbl.positions || false;
        if (!tbl.positions) {
          tbl.positions = [];
          tbl.rows().every( function(rowId) {
            tbl.positions.push(rowId);
          })
        }
        if (diff) {
          for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            tbl.positions[diff[i].oldPosition] = diff[i].newPosition;
          }
        }


        var d = [];
        var cols = $(tbl.row(0).node()).children('td').length;
//        console.log(this.cols(0).data())
        tbl.cells().every( function ( OrigrowIdx, cellIdx) {
          console.log("cell", OrigrowIdx, cellIdx, $(this.node()).find('img').attr('data-file'), $(this.node()).find('textarea').val());
          rowIdx = tbl.positions[OrigrowIdx];
          d[rowIdx] = d[rowIdx] || [];

          if (cellIdx > 0) {
            if (cellIdx==1) {
              var v = $(this.node()).find('img').attr('data-file');
              d[rowIdx][1] = (v ? v : false);
            }
            else {
              // Storing captions: either in d[0] as string or array if multiple legends are selected
              if (cellIdx < cols - 1) {
                var v = $(this.node()).find('textarea').val();
                // If rows have more than 4 cols there must be
                // multiple captions
                if (cols>4) {
                  if (d[rowIdx][0] == undefined) d[rowIdx][0] = [];
                  d[rowIdx][0][cellIdx-2] = (v ? v : false);
                }
                else {
                  d[rowIdx][0] = (v ? v : false);
                }
              }
            }
          }
        });

        $.rokfor.contribution.store(
          uploader.attr('id'),
          JSON.stringify({
            action: "modify",
            data: d
          }),
          false,
          force ? 1 : 2000
        );
      }
        */
    });

    // Slider

    $(".rfslider").ionRangeSlider()
      .on("change", function () {
        $.rokfor.contribution.store($(this).attr('id'), $(this).prop("value"));
      });

    // Matrix

  	$('.rfmatrix').each(function() {
      var t = $(this);
      t.range2DSlider({
  		  grid:false,
        axis:[
            [0,100],
            [0,100]
        ],
        printValue:function( val ){
          $.rokfor.contribution.store(t.attr('id'), JSON.stringify(val[0]));
        }
  	  }).range2DSlider('value',t.attr("value") ? JSON.parse(t.attr("value")) : 0);
    });

    // TypologySelect
    $(".modal2")
      .select2()
      .on("change", function(){

      });

    // TypologySelect
    $(".rfselect")
      .select2()
      .on("change", function(){
        $.rokfor.contribution.store($(this).attr('id'), JSON.stringify($(this).val()));
      });

    // Select 2
    $(".rfkeyword")
      .select2Sortable()
      .on("change", function(){
        $.rokfor.contribution.store($(this).attr('id'), JSON.stringify($(this).val()));
      });

    // Input Masks (date)
    $(".rfmask").inputmask()
      .on("keyup", function(){
        if ($(this).inputmask("isComplete")){
          $.rokfor.contribution.store($(this).attr('id'), $(this).val());
        }
      });

    // Input Masks (date)
    $(".rfnumeric").inputmask()
      .on("keyup", function(){
        $.rokfor.contribution.store($(this).attr('id'), $(this).val());
      });

    // Regular Textareas
    // Regular Inputs

    $("textarea.rfeditor, input.rfeditor")
      .on("keyup", function(){
        $.rokfor.calcMaxInput(this);
        $.rokfor.contribution.store($(this).attr('id'), $(this).val());
      });

    // Multi Areas

    $("textarea.rfmultieditor")
      .on("keyup", function(){
        var v = [];
        $.rokfor.calcMaxInput(this);
        $(this).parents('.form-horizontal').find('textarea').each(function(i,x) {
          v.push($(x).val());
        });
        $.rokfor.contribution.store($(this).attr('id'), JSON.stringify(v));
      });

    $("textarea.rfeditor, input.rfeditor, textarea.rfmultieditor").each(function(i,x){
       $.rokfor.calcMaxInput(this);
    });

    // Summernote

    /*$(".rtftextarea").summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height','fullscreen']]
      ],
      height: 300,                 // set editor height
      minHeight: 150,             // set minimum height of editor
      maxHeight: '100%',             // set maximum height of editor
      callbacks: {
        onInit: function(contents) {
          $.rokfor.calcMaxInput($(this), $(this).next().find('.note-editable'));
        },
        onChange: function(contents) {
          $.rokfor.contribution.store($(this).attr('id'), contents);
          $.rokfor.calcMaxInput($(this), $(this).next().find('.note-editable'));
        }
      }
    })
    */
    /*
    var wysihtml5ParserRules = {
      tags: {
        h1:     {},
        strong: {},
        b:      {},
        i:      {},
        em:     {},
        br:     {},
        p:      {},
        ul:     {},
        ol:     {},
        li:     {},
        iframe: {},
        a:      {
          set_attributes: {
            rel:    "nofollow"
          },
          check_attributes: {
            href:   "href"
          }
        }
      }
    };
    */
    var wysihtml5ParserRulesDefaults = {
        "blockLevelEl": {
            "keep_styles": {
                "textAlign": /^((left)|(right)|(center)|(justify))$/i,
                "float": 1
            },
            "add_style": {
                "align": "align_text"
            },
            "check_attributes": {
                "id": "any"
            }
        },

        "makeDiv": {
            "rename_tag": "div",
            "one_of_type": {
                "alignment_object": 1
            },
            "remove_action": "unwrap",
            "keep_styles": {
                "textAlign": 1,
                "float": 1
            },
            "add_style": {
                "align": "align_text"
            },
            "check_attributes": {
                "id": "any"
            }
        }
    };

    $.rokfor.clearAssets();

    wysihtml.commands.pasteRaw = {
      exec: function(composer, command, param) {
        if (wysihtml.browser.pasteFromWord == null)
          wysihtml.browser.pasteFromWord = false;

        wysihtml.browser.pasteFromWord = !wysihtml.browser.pasteFromWord;

      },
      state: function(composer, command) {
         return wysihtml.browser.pasteFromWord;
      }
    };

    wysihtml.dom.getPastedHtml = function(event) {
      var html;
      if (wysihtml.browser.pasteFromWord === true) {
        var breakTag = '<br>';
        html = String(event.clipboardData.getData('text/plain')).replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
      }
      else {
        if (wysihtml.browser.supportsModernPaste() && event.clipboardData) {
          if (wysihtml.lang.array(event.clipboardData.types).contains('text/html')) {
            html = event.clipboardData.getData('text/html');
          } else if (wysihtml.lang.array(event.clipboardData.types).contains('text/plain')) {
            html = wysihtml.lang.string(event.clipboardData.getData('text/plain')).escapeHTML(true, true);
          }
        }
      }
      return html;
    };


    $(".rtftextarea").each(function(i,n) {
        var e = $(this);
        e.data('editor', new wysihtml.Editor(e[0], {
          toolbar: 'editor-toolbar_' + e.attr('id'),
          /*pasteParserRulesets: [
            {
                type_definitions: {
                    text_color_object: {
                      styles: {
                        color: true
                      }
                    },
                },
                tags: {
                  strong: {},
                  b:      {},
                  i:      {},
                  em:     {},
                  br:     {},
                  p:      {},
                  ul:     {},
                  u:      {},
                  h1:     wysihtml5ParserRulesDefaults.blockLevelEl,
                  h2:     wysihtml5ParserRulesDefaults.blockLevelEl,
                  h3:     wysihtml5ParserRulesDefaults.blockLevelEl,
                  h4:     wysihtml5ParserRulesDefaults.blockLevelEl,
                  a:      {
                      "check_attributes": {
                          "target": "any",
                          "href": "href" // if you compiled master manually then change this from 'url' to 'href'
                      },
                      "set_attributes": {
                          "rel": "nofollow"
                      }
                  },
                  comment: { remove: 1 },
                  style: { remove: 1 }
                }
              }
          ],*/
          parserRules:  {
            type_definitions: {
                text_color_object: {
                  styles: {
                    color: true
                  }
                },
            },
            tags: {
              strong: {},
              b:      {},
              i:      {},
              em:     {},
              br:     {},
              p:      {},
              div:    {},
              ul:     {},
              u:      {},
              ol:     {},
              li:     {},
              sup:    {},
              blockquote: {
                  "keep_styles": {
                      "textAlign": 1,
                      "float": 1
                  },
                  "add_style": {
                      "align": "align_text"
                  },
                  "check_attributes": {
                      "cite": "url",
                      "id": "any"
                  }
              },
              h1:     wysihtml5ParserRulesDefaults.blockLevelEl,
              h2:     wysihtml5ParserRulesDefaults.blockLevelEl,
              h3:     wysihtml5ParserRulesDefaults.blockLevelEl,
              h4:     wysihtml5ParserRulesDefaults.blockLevelEl,
              a:      {
                  "check_attributes": {
                      "target": "any",
                      "href": "href" // if you compiled master manually then change this from 'url' to 'href'
                  },
                  "set_attributes": {
                      "rel": "nofollow"
                  }
              },
              span: {
                  one_of_type: {
                      text_color_object: 1
                  },
                  keep_styles: {
                      color: 1
                  },
                  remove_action: "unwrap"
              },
              comment: { remove: 1 }
            }
          },
          showToolbarDialogsOnSelection: false,
          useLineBreaks: true,
          doubleLineBreakEscapesBlock: true,
        }).on("interaction", function(x,y,z) {

          // Jsonize if RTF Editor is part of multi form
          if (e.hasClass('rtfmultieditor')){
            var v = [];
            $.rokfor.calcMaxInput(e, e);
            e.parents('.form-horizontal').find('.rtftextarea').each(function(i,x) {
              var _e = $(x).data('editor');
              v.push(_e.getValue());
            });
            $.rokfor.contribution.store(e.attr('data-fieldid'), JSON.stringify(v));
          }
          // Store directly
          else {
            var _e = e.data('editor');
            $.rokfor.contribution.store(e.attr('id'), _e.getValue());
            $.rokfor.calcMaxInput(e, e);
          }
        }));

        $.rokfor.addAssets(e.data('editor'));
        $.rokfor.calcMaxInput(e, e);
      });

    // Markdown Editor


    marked.setOptions({
      gfm: true,
      breaks: true
    });

    $(".mdtextarea").each(function(i,n) {
      var e = $(this);
//      var editor = new Pen(e[0]);
      e.markdown({
        autofocus:false,
        savable:false,
        iconlibrary: 'fa',
        fullscreen: false,
        onChange: function(el){
           console.log("Changed!")
          // Jsonize if RTF Editor is part of multi form
          if (e.hasClass('mdmultieditor')){
            var v = [];
            e.parents('.form-horizontal').find('.mdtextarea').each(function(i,x) {
              v.push($(x).val());
            });
            $.rokfor.contribution.store(e.attr('id'), JSON.stringify(v));
          }
          // Store directly
          else {
            $.rokfor.contribution.store(e.attr('id'), e.val());
          }
          $.rokfor.calcMaxInput(e);
         }
      })
      $.rokfor.calcMaxInput(e);
    });


    /* Create an array with the values of all the input boxes in a column, parsed as numbers */
    $.fn.dataTable.ext.order['dom-span-text'] = function  ( settings, col )
    {
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            return $('span', td).text();
        } );
    }

    // Tables

    $('.rftable').each(function(i,n) {
      var table = $(this);
      var addbutton = table.next('a');
      var serialize = function(){};

      var dt = table.DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "rowReorder": {
            selector: 'td:first-child',
            update: true
        },
        "info": false,
        "autoWidth": false,
        "dom": 'rtp',
        "drawCallback": function( settings ) {
          var api = this.api();
          serialize();
        },
        "columnDefs": [
                        {
                          "targets": 0,
                          "defaultContent": '',
                          "render": function(data) {
                            return ('<span class="rowhandle btn btn-xs fa fa-bars">' + data + '</span>');
                          },
                          "orderDataType": "dom-span-text",
                          "width": "0.1em"
                        },
                        /*{
                          "targets": 0,
                          "defaultContent": '',
                          "render": function(data) {
                            return (data);
                          }
                        },*/
                        {
                          "targets": -1,
                          "defaultContent": '<a class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>',
                          "render": function(data) {
                            return (data);
                          },
                          "width": "0.1em"
                        },
                        {
                          "targets": '_all',
                          "defaultContent": '',
                          "render": function(data) {
                            return ('<textarea class="rowedit">' + data + '</textarea>');
                          },
                          "width": "auto"
                        }
                      ]
      });
      dt.on('keyup', 'textarea', function(){
        $(this).next().html($(this).val());
        serialize();
      });
      dt.on('click', 'a', function(e){
        e.stopPropagation();
        dt.row($(this).parents('tr')).remove().draw();
        return false;
      });
      addbutton.click(function(e){
        e.stopPropagation();
        dt.row.add([dt.rows().count()]).draw();
        return false;
      });

      var serialize = function() {
        var d = [];
        var cols = $(dt.row(0).node()).children('td').length;
        var row_pointer;
        var oldrow;
        dt.cells().every( function ( rowIdx, cellIdx) {
          if (rowIdx !== oldrow) {
            row_pointer = row_pointer + 1 || 0;
          }
          d[row_pointer] = d[row_pointer] || [];
          var v = $(this.node()).find('textarea').val() || false;
          if(cellIdx > 0 && cellIdx < cols - 1)
            d[row_pointer][cellIdx - 1] = v;
          oldrow = rowIdx;
        });
        $.rokfor.contribution.store( table.attr('id'), JSON.stringify(d));
      }



    });

    $('.closebutton').click(function(e){
      e.stopPropagation();
      $.rokfor.contribution.close();
      return false;
    })

    // Drop Down Actions

    $('#contributionaction a').each(function() {
      var button = $(this)
      button.on('click', function(e) {
        e.stopPropagation();
        var m = $('#' + $(this).attr('data-modal')).modal({keyboard: true});
        return false;
      })

      // Modal Continue Action

      $('#' + $(this).attr('data-modal')).find('button.btn-default').on('click', function(e) {
        e.stopPropagation();
        var modal  = $(this).parents('.modal');
        var stored_path = $('.content-wrapper#detail').find('section.content').attr('data-path');
        $.rokfor.contribution.modify(
          modal.attr('data-action'),
          modal.attr('data-contribution'),
          modal.find('select').select2('val'),
          function(data) {
            var html = data
            modal.modal('hide').on('hidden.bs.modal', function () {
              $('.content-wrapper#detail').html(html);
              var new_path = $('.content-wrapper#detail').find('section.content').attr('data-path');
              if (new_path != stored_path) {
                // If the Path of the current contribution has changed (i.e after a change of chapter and issue)
                // we need to reload the list in the background and reset the scroll position to top
                $.rokfor.get(new_path, function(data){
                  $('.content-wrapper#list').html(data);
                  $.rokfor.scrollpos = 0;
                });
              }
            });
          }
        );
        return false;
      })
    })

    // Tooltips

    $('[data-toggle="tooltip"]').tooltip();

  }
})(jQuery);
