(function($){

  $(function() {

    // Refresh statuses
    $('.wp-mail-manager-refresh').click(function(){
      var button = $(this);
      button.addClass('refreshing');

      jQuery.get( '/wp-json/bda-cli/v2/get-mail-status', { to: 'tests@plugins.belovdigital.agency' } )
        .done(function( result ) {
          button.removeClass('refreshing');

          var adminBarFlashlight = document.querySelector('#wp-admin-bar-wp-mail-manager > div > span'),
              mailExistsStatus = document.querySelector('#wp-admin-bar-wp-mail-manager-is-phpmail-exists > div > span'),
              mailWorkingStatus = document.querySelector('#wp-admin-bar-wp-mail-manager-is-phpmail-working > div > span'),
              smtpEnabledStatus = document.querySelector('#wp-admin-bar-wp-mail-manager-is-smtp-enabled > div > span');
              
          if (result.mailExists && result.mailWorking) {
            adminBarFlashlight.className = 'flashlight ok';
          } else {
            adminBarFlashlight.className = 'flashlight not-ok';
          }

          if (result.mailExists) {
            mailExistsStatus.className = 'ok';
            mailExistsStatus.innerHTML = window.wpMailManagerI18n.mailExists;
          } else {
            mailExistsStatus.className = 'not-ok';
            mailExistsStatus.innerHTML = window.wpMailManagerI18n.mailNotExists;
          }

          if (result.mailWorking) {
            mailWorkingStatus.className = 'ok';
            mailWorkingStatus.innerHTML = window.wpMailManagerI18n.mailWorking;
          } else {
            mailWorkingStatus.className = 'not-ok';
            mailWorkingStatus.innerHTML = window.wpMailManagerI18n.mailNotWorking;
          }

          if (result.smtpEnabled) {
            smtpEnabledStatus.className = 'ok';
            smtpEnabledStatus.innerHTML = window.wpMailManagerI18n.enabled;
          } else {
            smtpEnabledStatus.className = 'not-ok';
            smtpEnabledStatus.innerHTML = window.wpMailManagerI18n.disabled;
          }

        });
    });

  });

})(jQuery);