// Contributions Stuff

(function ($) {
  $.rokfor.initContributions = function() {
  
    var selection = {
      contributions: [],  // Stored Id's for multi actions
      rows: []            // Stored row id's from tables
    };
    
  
    // Activating List Table
    
  
    var table = $('#rftable').DataTable({
      "paging": false,
      "order": $.rokfor.ctorder,
      "lengthChange": false,
      "searching": true,
      "ordering": ($('#rftable').parents('section.content').attr('data-path') && $('#rftable').parents('section.content').attr('data-path').indexOf('search') == -1) ? true : false,
      "rowReorder": ($('#rftable').parents('section.content').attr('data-path') && $('#rftable').parents('section.content').attr('data-path').indexOf('search') == -1) 
                    ? {
                      selector: 'td:first-child',
                      update: true
                    }
                    : false,
      "info": false,
      "autoWidth": false,
      "dom": 'rtp',
      "select": true,
      "columnDefs": [ 
                      {
                        "targets": 5,
                        "render": function(data) {
                          return ('<input class="form-control nameedit" type="text" rows="1" value="' + data + '"><span style="display:none;">' + data + '</span>');
                        }
                      }
                    ]    
    });
  
    // External Search Field
  
    $('#table_search').keyup(function(){
      table.bulkaction = true;
      table.search($(this).val()).draw() ;
    });

    // Reorder Action, Selection Event 

    table
      .on( 'order.dt', function ( e, diff, edit ) {
        $.rokfor.ctorder = [[ edit[0].col, edit[0].dir ]]
      })
      .on( 'row-reordered', function ( e, diff, edit ) {
        console.log(e, diff, edit);
        if (table.bulkaction == undefined) {
          var data = {
            action: "reorder",
            id: []
          };

          for (var i = 0; i < diff.length; i++) {
            data.id.push({id:diff[i].node.id, sort:diff[i].newData});
          };
          
          /*
          table.column(0).nodes().each( function (d,x,y) {
            data.id.push({id:$(d).parents('tr').attr('id'), sort:$(d).text()});
          });
          */
          if ($(this).parents('section.content').attr('data-path') && $(this).parents('section.content').attr('data-path').indexOf('search') == -1)
            $.rokfor.contributions.bulkaction($(this).parents('section.content').attr('data-path'), data);
        }
        else
          table.bulkaction = undefined;
      })
      .on( 'deselect', function (  e, dt, type, indexes  ) {
        $.rokfor.contributions.select(  e, dt, type, indexes  );
      })
      .on( 'select', function (  e, dt, type, indexes  ) {
        $.rokfor.contributions.select(  e, dt, type, indexes  );
      });
    
      $('#rftable tr').on("dblclick", function (e) {
        e.stopPropagation();
        if ($(this).attr('id')) {
          $.rokfor.contribution.edit($(this).attr('id'));
        }
        return false;
      });

    /* Selection Action */

    $.rokfor.contributions.select = function(e, dt, type, indexes) {
      var c = table.rows('.selected').data().length;
      selection.rows = table.rows('.selected');
      selection.contributions = [];
      if (c > 0) {
        $('#rf_bulk_action').removeClass('disabled') ;
        selection.contributions = selection.rows.data().pluck('DT_RowId').splice(0,c);      
      }
      else {
        $('#rf_bulk_action').addClass('disabled');
      }
    }
    
    /* Release Date Action */
    $(".rfreleasemask").click(function(){
      if (!this.hasmask) {
        this.hasmask = true;
        $(this).inputmask()
          .on("keyup", function(){
            if ($(this).inputmask("isComplete")){
              $.rokfor.contribution.releasedate($(this).parents('tr').attr('id'),$(this).val());
            }
          });
        }
    });
    
    /* Open Click Button */
    
    $('.opencontribution').on("click", function (e) {
      e.stopPropagation();
      var row = $(this).closest('#rftable tr');
      if (row.attr('id')) {
        $.rokfor.contribution.edit(row.attr('id'));
      }
      return false;
    });


    /* Row Editor Field */
  
    $('#rftable td')
      .on('dblclick', 'a', function(e) {
        e.stopPropagation();
        return false;
      })
      .on('click', 'a', function(e) {
        e.stopPropagation();
        var id = $(this).parents('tr').attr('id');
        var translations = JSON.parse($(this).attr('data-status'));
        var action = $(this).attr('href').split("/").pop();      
        var bt_class = false;
        switch (action) {
          case 'Close':
            bt_class = 'btn-primary';
            action = 'Open';
          break;
          case 'Draft':
            bt_class = 'btn-success';
            action = 'Close';
          break;          
          case 'Open':
            bt_class = 'btn-warning';
            action = 'Draft';
          break;
        }
        if (bt_class) {
          if ($(this).parents('section.content').attr('data-path')) {
            $.rokfor.contributions.bulkaction($(this).parents('section.content').attr('data-path') , {action: action, id: [id]});
            $(this)
              .attr('href', '/rf/contributions/'+ action)
              .removeClass('btn-success btn-primary btn-warning')
              .addClass(bt_class)
              .text(translations[action]);
          }
        }
        return false;
      })
      .on('click dblclick', 'input', function(e) {
        e.stopPropagation();
        return false;    
      })
      .on('keyup', 'input.nameedit', function(e) {
        $(this).next().html($(this).val());
        $.rokfor.contribution.rename($(this).parents('tr').attr('id'),$(this).val());
      })

  
    // Clicks on a in dropdowns with .rfselector class
    // Ajax Call, send data as post, update csrf on return
  
    $('.rfselector a').click(function (e) {
      e.stopPropagation();
      var text = $(this).html();
      var action = $(this).attr('href').split("/").pop();
      // Nasty workaround: tables fire order events on every draw
      // setting table.bulkaction prohibits firing the next order event
      table.bulkaction = true;

      // Callback after Action
      var cb = function(data) {
        var action = data.action
        var bt_class = false;
        switch (action) {
          case 'clone':
            $.rokfor.refreshList();
          break;
          case 'Close':
            bt_class = 'btn-success';
          break;
          case 'Draft':
            bt_class = 'btn-warning';
          break;
          case 'Open':
            bt_class = 'btn-primary';
          break;
          case 'Deleted':
            bt_class = 'btn-danger';
          break;            
          case 'Trash':
            $('#rf_bulk_action').addClass('disabled');
            table
              .rows( '.selected' )
              .remove()
              .draw();
          break;            
        }
        if (bt_class) {
          for (var n in selection.rows[0]) {
            if (selection.rows[0].hasOwnProperty(n)) {
              $(table.cell( selection.rows[0][n], 5 ).node()).children('a')
                .attr('href', '/rf/contributions/'+ action)
                .removeClass('btn-primary btn-success btn-danger')
                .addClass(bt_class)
                .text(text);
  //            table.draw();
            }
          }
          table
              .rows( '.selected' )
              .deselect()
              .draw();
          selection.contributions = [];
          selection.rows = [];
        }
      }    
    
      //Perform ajax call
      if ($(this).parents('section.content').attr('data-path')) {
        $.rokfor.contributions.bulkaction($(this).parents('section.content').attr('data-path') , {action: action, id: selection.contributions}, cb);
      }


      $('#rf_bulk_action').trigger("click");
      return false;
    });
  
    // New Contributions Click
    $('#add_contribution').click(function(e){
      $('#rfmodalnew').modal({keyboard: true}).on('shown.bs.modal', function () {
        $(this).find('input').focus();
      });
    });

    // Modal Continue Action

    var newContrib = function() {
      var button = $('#rfmodalnew').find('button.btn-default');
      var name = button.closest('.modal-content').find('input').val();
      var template = button.closest('.modal-content').find('select').val();
      console.log(button, name, template);
      if (template && name) {
        $('#rfmodalnew').modal('hide');
//        $('#rfmodalnew').modal('hide').on('hidden.bs.modal', function () {
          $.rokfor.contributions.bulkaction($('#rfmodalnew').prev().attr('data-path') , {
            action: 'new', 
            name: name,
            template: template
          }, function (data) {
            var d = data;
            $.rokfor.refreshList(function(){
              $.rokfor.showDetail();
              $('.content-wrapper#detail').html(d);
            });
          });
//        });
      }
      else {
        $('#rfmodal').modal({keyboard: true});
      }
    }

    $('#rfmodalnew').find('button.btn-default').on('click', function(e) {
      e.stopPropagation();
      newContrib();
      return false;      
    })
    $('#rfmodalnew').find('form').on('submit', function(e) {
      e.stopPropagation();
      newContrib();
//      $('#rfmodalnew').find('button.btn-default').trigger('click');
      return false;
    });

    // Check if the tree is really open
    $.rokfor.recursivetree($('section.content').attr('data-path'));
    
  }
})(jQuery);

