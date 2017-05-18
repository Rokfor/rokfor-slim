/*
 * Rokfor Client Side Extensions
 * -----------------------------
 */

(function ($) {
  
  if (typeof console === "undefined" || typeof console.log === "undefined") {
    console = {};
    console.log = function(msg) {};
  }

  // Some JSON Editor Default Changes
  JSONEditor.defaults.editors.select.prototype.setupSelect2 = function() { 
    this.select2 = null;
  }

  JSONEditor.defaults.themes.rokfor = JSONEditor.defaults.themes.bootstrap3.extend({
    getButton: function(text, icon, title) {
      var el = this._super(text, icon, title);
      el.className += 'btn btn-default btn-flat';
      return el;
    },

    getIndentedPanel:  function() {
      var el = document.createElement('div');
      el.className = '';
      el.style.paddingBottom = 0;
      return el;
    },
    
    getTable: function() {
      var el = document.createElement('table');
      el.className = 'table table-striped';
      el.style.width = '100%';
      el.style.maxWidth = 'none';
      return el;
    }
    
    
  });

  // Some Modal Overrules if a select 2 is within a modal
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};

  $.rokfor = {

    // CSRF Strings

    csrf_value: '',
    csrf_name: '',
  
    // Drop Down Icon
  
    dd_icon: '<span class="fa fa-caret-down"></span>',
  
    // scroll position
  
    scrollpos: 0,
  
    // store timers
  
    timer: [],
    savecount: {},
    stateInterval: false,
    
    // contributions order
    ctorder: [[ 0, "asc" ]]
  
  
  };
  
  // State Checker
  if ($.rokfor.stateInterval) {
    clearInterval($.rokfor.stateInterval);
  }
  $.rokfor.stateInterval = setInterval(function(){
    var s = Object.keys($.rokfor.savecount).length;
    if (s == 0) {
      $('#savestate')
        .html('Saved')
        .removeClass('label-danger')
        .addClass('label-success');
    }
    else {
      $('#savestate')
        .html('Unsafed (' + s + ')')
        .addClass('label-danger')
        .removeClass('label-success');
    }    
  }, 500);  
  
  // Progressbar
  
  $.rokfor.progressbar = {
    init: function() {
      this.set(0);
      $('#loadbar').css('display', 'block');
    },    
    set: function(s) {
      $('#loadbar').css('width', (s*100)+'%').attr('aria-valuenow', (s*100));    
    },
    hide: function() {
      $('#loadbar').css('display', 'none');
      this.set(0);
    }
  }
  
  // Load Spinner for Blocking Calls

  $.rokfor.spinner = {  
    show: function() {
      $('#ovw').removeClass('hidden').addClass('show');
    },
    hide: function() {
      $('#ovw').removeClass('show');     
      setTimeout(function() {
          $('#ovw').addClass('hidden');
      }, 500);
    }
  };

  
  // XHR Callback, in POST and GET Function
  
  $.rokfor.xhr = function() {
    
    // Keep Default on IE9
    if (/msie/.test(navigator.userAgent.toLowerCase()))
      return window.XMLHttpRequest && window.location.protocol !== "file:" || window.ActiveXObject ?
        new window.XMLHttpRequest() :
        new window.ActiveXObject("Microsoft.XMLHTTP");

    // Implement Progress Bar on other Browsers
    var xhr = new window.XMLHttpRequest();
    //Upload progress
    xhr.upload.addEventListener("progress", function(evt){
      if (evt.lengthComputable) {
        $.rokfor.progressbar.set(evt.loaded / evt.total);
//        console.log("Send: ", evt.loaded, evt.total);
      }
    }, false);
    //Download progress
    xhr.addEventListener("progress", function(evt){
      if (evt.lengthComputable) {
        $.rokfor.progressbar.set(evt.loaded / evt.total);
//        console.log("Download: ", evt.loaded, evt.total);
      }
    }, false);
    return xhr;
  };

  // General Post function

  $.rokfor.post = function(url, post, callback) {
    var cb = function(){};
    if (callback)
      cb = callback; 
    console.log("Executing POST: ", url, post);
    $.rokfor.progressbar.init();
    $.ajax({
          xhr: $.rokfor.xhr,
          method: "POST",
          url: url,
          data: {
            csrf_name:  $.rokfor.csrf_name,
            csrf_value: $.rokfor.csrf_value,
            data: post
          },
          success: function(data){
            $.rokfor.progressbar.hide();
          }
        }).done(function( data ) {
            if (typeof data == "string") {
              console.log("Received:", data.substring(0,10));
            }
            // Update CSRV global
            if (data.name && data.value) {
              $.rokfor.csrf_name = data.name;
              $.rokfor.csrf_value = data.value;
              console.log("updated csrf");
            }
            // Update Trigger data in all tags with the corresponding class
            if (data.trigger) {
              for (var n in data.trigger) {              
                if (data.trigger.hasOwnProperty(n)) {
                  $('.' + n).html(data.trigger[n])
                }
              }
            }
            cb(data);
        });
  }
  
  // General GET Function
  
  $.rokfor.get = function(url, callback) {
    var cb = function(){};
    if (callback)
      cb = callback;     
    $.rokfor.progressbar.init();    
    console.log("Executing GET: ", url);
    $.ajax({
          xhr: $.rokfor.xhr,
          method: "GET",
          url: url,
          success: function(data){
            $.rokfor.progressbar.hide();
          }
        }).done(function( data ) {
            if (typeof(data)=="string")
              console.log("Received:", data.substring(0,100));
            cb(data);
        });    
  }

  $.rokfor.refreshList = function(callback) {
    var cb = function(){};
    if (callback)
      cb = callback;
    var list = $('.content-wrapper#list');
    $.rokfor.get(list.find('section.content').attr('data-path'), function(data){
      console.log("Refreshing List")
      list.html(data);
      cb();
    });
  };
  
  // Clears some js assets loaded in the detail form
  
  $.rokfor.clearAssets = function() {
    $.rokfor.rtfeditors = $.rokfor.rtfeditors || [];
    $($.rokfor.rtfeditors).each(function(i,e){e.destroy();})
    $.rokfor.rtfeditors = [];
  }
  

  // Adds an asset to the rokfor object storage

  $.rokfor.addAssets = function(obj) {
    $.rokfor.rtfeditors.push(obj);
  }
  

  // Displays Form instead of List, scrolls to top

  $.rokfor.showDetail = function() {
    // Store List Scroll Position if the list is still visible
    if ($('.content-wrapper#list').css('display') != 'none') {
      $.rokfor.scrollpos = $(document).scrollTop();
    }
    $(document).scrollTop(0);
    $('.content-wrapper#list').css('display','none');
    $('.content-wrapper#detail').css('display','block');
  }

  // Displays List instead of form

  $.rokfor.showList = function(offset) {
    if (offset == undefined)
      offset = 0;
    $.rokfor.scrollpos = $(document).scrollTop();
    $(document).scrollTop(offset);
    $('.content-wrapper#detail')
      .text('')
      .css('display','none');
    $('.content-wrapper#list').css('display','block');
    $.rokfor.clearAssets();
  }

  // Delay Function after keystrokes

  $.rokfor.delay = (function(){
    return function(callback, ms, id){
      if ($.rokfor.timer[id] == undefined)
        $.rokfor.timer[id] = 0;
      clearTimeout ($.rokfor.timer[id]);
      $.rokfor.timer[id] = setTimeout(callback, ms);
    };
  })();

  /* Contributions Bulk Actions: reorder, state */

  $.rokfor.contributions = {
    bulkaction: function(command, data, callback) {
      console.log(command, data, callback);
      $.rokfor.post(command, data, callback);      
    }
  }  
  
  /* Contribution Actions: rename, store field */

  $.rokfor.contribution = {
    rename: function(id, value) {
      $.rokfor.delay(function(){
        /* Executes a ajax call, updates csrf globals on success */
        $.rokfor.post('/rf/contribution/rename/'+id, value); 
      }, 250 );
    },
    releasedate: function(id, value) {
      $.rokfor.delay(function(){
        /* Executes a ajax call, updates csrf globals on success */
        $.rokfor.post('/rf/contribution/releasedate/'+id, value); 
      }, 250 );
    },    
    modify: function(action, id, value, callback) {
      $.rokfor.post('/rf/contribution/' + action + '/' + id, value, callback);
    },    
    edit: function(id) {
      /* Executes a ajax call, updates csrf globals on success, injects form */
      $.rokfor.get('/rf/contribution/' + id, function (data) {
        console.log("Edit: ", id);
        $('.content-wrapper#detail').html(data);
        $.rokfor.showDetail();
      });
    },     
    close: function() {
      $.rokfor.showList($.rokfor.scrollpos)
    },
    store: function(id, value, callback, delay) {
      delay = delay || 2000;
      $.rokfor.savecount[id] = true;
      cb = function(_c, _i) {
        delete $.rokfor.savecount[_i];
        if (typeof _c == "function")
          _c();
      }
      $.rokfor.delay(function(timer){
        /* Executes a ajax call, updates csrf globals on success */        
        $.rokfor.post('/rf/field/' + id, value, cb(callback, id));
      }, delay, id );
    }
  }
  
  /* Checks Length and sets counter and overlength class */
  $.rokfor.calcMaxInput = function(e, target)  {
    var div = target ? true : false;
    var e = $(e);
    if (!e.attr('data-maxlength')) {
      return false;
    }
    var t = target ? $(target) : e;
    var val = div ? t.text().length : t.val().length;
    if (val > e.attr('data-maxlength'))
      t.addClass('overlength')
    else
      t.removeClass('overlength')
    if (e.attr('data-counter'))
      $(e.attr('data-counter')).html(e.attr('data-maxlength') + '/' + val);
  }
  
  /* recursively opens the tree from a child element, returns false if no string is passed */
  $.rokfor.recursivetree = function(d) {
    if (d == undefined) return false;
    var e = $('#chapter_' + d.replace(/\//gi,'_'));
    var m = e.parents('ul#rfmenu');
    if (!e.hasClass('active')) {
      m.find('li').removeClass('active');
      m.find('ul.treeview-menu').removeClass('menu-open').css('display','none');
      e = e.parents('li');
      do {
        console.log("add", e, "active")
        e.addClass('active');
        e.parents('ul.treeview-menu').addClass('menu-open').css('display','block');
        e = e.parents('li');        
      } while (e.length > 0);
    }
  }
  
  // Ajax Load Actions: turn all links with the class .ajaxload
  // into xhr get calls
  $(document).on('click', '.ajaxload', function (e) {
    console.log(this);
    e.preventDefault();
    var target = $($(this).attr('target'));
    var detail = $(this).attr('target') == '.content-wrapper#detail';
    
    if ($(this).attr('data-close-dropdown')) {
      $($(this).attr('data-close-dropdown')).removeClass('open');
    }
    
    //Perform ajax call
    $.rokfor.get($(this).attr('href'), function(data){
      target.html(data);
      if (detail)
        $.rokfor.showDetail();
      else 
        $.rokfor.showList(0);
    })
    return false;
  });
  
  // Dropdown Action:
  // Store the selected link in the parent div
  $(document).on('click', '.rf-copy-dropdown + ul a', function(e) {
    e.stopPropagation();
    $(this).parents('.dropdown-menu').prev()
      .html($(this).html() + '&nbsp;' + $.rokfor.dd_icon)
      .attr('value', $(this).attr('href'))
      .trigger("click");
    return false;
  });

  // Main Search action
  $(document).on('submit', 'form#mainsearch', function(e) {
    e.stopPropagation();
    $.rokfor.post($(this).attr('action'), $(this).find('input').val(), function(data) {
      $('.content-wrapper#list').html(data);
      $.rokfor.showList(0);
    });
    return false;
  });
  
  // Direct add function
  $(document).on('click', 'input#directname', function(e) {
    e.stopPropagation();
    return false;
  })
  $(document).on('click', 'a#directtoggle', function(e) {
    $(this).next().find('input#directname').focus();
  })  
  $(document).on('click', 'a.directshortcut', function(e) {
    e.stopPropagation();
    var val = $(this).parents('ul').find('input#directname').val()
    if (val) {
      $.rokfor.recursivetree($(this).attr('href'));
      $.rokfor.contributions.bulkaction($(this).attr('href') , {
        action: 'new', 
        name: val,
        template: $(this).attr('data-template')
      }, function (data) {
        $.rokfor.showDetail();
        $('.content-wrapper#detail').html(data);
      });
    }
    return false;
  })   

//  $('ul.menu-force').prev().unbind();

})(jQuery);