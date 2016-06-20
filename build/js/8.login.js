(function ($) {

  /**
   * Function that gets the data of the profile in case
   * thar it has already saved in localstorage. Only the
   * UI will be update in case that all data is available
   *
   * A not existing key in localstorage return null
   *
   */
  $.rokfor.getLocalProfile = function(callback){
      var profileImgSrc      = localStorage.getItem("PROFILE_IMG_SRC");
      var profileReAuthEmail = localStorage.getItem("PROFILE_REAUTH_EMAIL");
      if(profileReAuthEmail !== null && profileImgSrc !== null) {
          callback(profileImgSrc, profileReAuthEmail);
      }
  }

  /**
   * Main function that load the profile if exists
   * in localstorage
   */
  $.rokfor.loadProfile = function() {

    if(!$.rokfor.supportsHTML5Storage()) { return false; }

    $('.not-user').click(function() {
      $.rokfor.clearLocalStorageData();
      $("#profile-img").attr("src", "/assets/img/logo-small-w.svg");
      $("#inputEmail").show();
      $("#remember").show();
      $("#reauth-email").html('');
      $("#inputEmail").attr('value', '');
      $('.not-user').hide();
    })

    // we have to provide to the callback the basic
    // information to set the profile
    $.rokfor.getLocalProfile(function(profileImgSrc, profileReAuthEmail) {
        //changes in the UI
        $("#profile-img").attr("src",profileImgSrc);
        $("#reauth-email").html("Welcome back, " + profileReAuthEmail);
        $("#inputEmail").attr('value', profileReAuthEmail);
        $("#inputEmail").hide();
        $("#remember").hide();
        $('.not-user').html("I'm not " + profileReAuthEmail);
    });
  }

  /**
   * function that checks if the browser supports HTML5
   * local storage
   *
   * @returns {boolean}
   */
  $.rokfor.supportsHTML5Storage = function() {
      try {
          return 'localStorage' in window && window['localStorage'] !== null;
      } catch (e) {
          return false;
      }
  }

  /**
   * Test data. This data will be safe by the web app
   * in the first successful login of a auth user.
   * To Test the scripts, delete the localstorage data
   * and comment this call.
   *
   * @returns {boolean}
   */
  $.rokfor.addLocalStorageData = function(img, name) {
      if(!$.rokfor.supportsHTML5Storage()) { return false; }
      localStorage.setItem("PROFILE_IMG_SRC", img );
      localStorage.setItem("PROFILE_REAUTH_EMAIL", name);
  }
  
  $.rokfor.clearLocalStorageData = function() {
      if(!$.rokfor.supportsHTML5Storage()) { return false; }
      localStorage.removeItem("PROFILE_IMG_SRC");
      localStorage.removeItem("PROFILE_REAUTH_EMAIL");
  }  
  
})(jQuery);
