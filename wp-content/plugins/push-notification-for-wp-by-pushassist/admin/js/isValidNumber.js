var telInput = jQuery("#pushassist_contact"),
  errorMsg = jQuery("#error-msg"),
  hidden_error_msg = jQuery("#hidden_psa_error_msg");

// initialise plugin
telInput.intlTelInput({
  utilsScript: "../wp-content/plugins/push-notification-for-wp-by-pushassist/admin/js/utils.js"
});

var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
};

// on blur: validate
telInput.blur(function() {
  reset();
  if (jQuery.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      errorMsg.addClass("hide");
	  hidden_error_msg.val(1);
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("hide");
	  hidden_error_msg.val(0);
    }
  }
});

// on keyup / change flag: reset
telInput.on("keyup change", reset);