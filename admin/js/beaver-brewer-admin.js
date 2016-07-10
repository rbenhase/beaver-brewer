(function( $ ) {
	'use strict';

  // Update button
  $(document).on("click", "a.update-automatically", function(e) {
	  
	   e.preventDefault();
	  
	  var elem = $(this);
	  var module = elem.closest(".single-module");
	  var messages = module.find(".module-messages");
	  
	  $.post(
  	  ajaxurl,
  	  {
    	  action: "beaver_brewer_auto_update",
    	  _ajax_nonce: BeaverBrewer.ajaxNonce,
    	  module: elem.data("module"),
    	  update: elem.data("update")
  	  },
  	  function(response) {
    	  module.find(".module-updates").text( response.message );
    	  if (response.success) {
      	  module.removeClass("update-available");
      	  module.removeClass("module-failed");  
      	  module.find(".module-version .version-number").text(elem.data("latest"));
    	  } else {
      	  module.removeClass("module-active");
      	  module.addClass("module-failed");
    	  }
  	  }
	  ).fail(function() {
  	 messages.addClass("failure");
     messages.removeClass("success");
     module.find(".module-updates").text(BeaverBrewer.moduleUpdateError);
   });
	  
	  module.find(".module-updates").text( "Attempting Update..." );  	  
	  
  });
 
 
  // Activate button
  $(document).on("click", "a.module-activate", function(e) {
	  
	  e.preventDefault();
	  
	  var elem = $(this);
	  var module = elem.closest(".single-module");
	  var messages = module.find(".module-messages");
	  
	  $.post(
  	  ajaxurl,
  	  {
    	  action: "beaver_brewer_activate",
    	  _ajax_nonce: BeaverBrewer.ajaxNonce,
    	  module: elem.data("module")
  	  },
  	  function(response) {
    	  
    	  $("html, body").animate({scrollTop: messages.offset().top},500);
    	  
    	  if ( response.success ) {
      	  messages.addClass("success");
      	  messages.removeClass("failure");
      	  module.removeClass("module-failed");   
      	  module.addClass("module-active");
      	  
      	  elem.addClass("module-deactivate")
      	     .removeClass("module-activate")
      	     .text("Deactivate");
      	     
    	  } else {
      	  messages.addClass("failure");
      	  messages.removeClass("success");
      	  module.removeClass("module-active");
      	  module.addClass("module-failed");
    	  }
    	  
    	  messages.html(response.message).slideDown(300);
    	  
  	  }
	  ).fail(function() {
	    messages.addClass("failure");
     messages.removeClass("success");
     module.removeClass("module-active");     
     module.addClass("module-failed"); 	  
  	  messages.html(BeaverBrewer.activationFatalError).slideDown(300);
  });  	  
  });
 
 
  // Deactivate button
  $(document).on("click", "a.module-deactivate", function(e) {
	  
	  e.preventDefault();
	  
	  var elem = $(this);
	  var module = elem.closest(".single-module");
	  var messages = module.find(".module-messages");
	  
	  $.post(
  	  ajaxurl,
  	  {
    	  action: "beaver_brewer_deactivate",
    	  _ajax_nonce: BeaverBrewer.ajaxNonce,
    	  module: elem.data("module")
  	  },
  	  function(response) {
    	  console.log(response);
    	  $("html, body").animate({scrollTop: messages.offset().top},500);
    	  
    	  if (response.success) {
      	  messages.addClass("success");
      	  messages.removeClass("failure");
      	  module.removeClass("module-failed");   
      	  module.removeClass("module-active");
      	  
      	  elem.addClass("module-activate")
      	     .removeClass("module-deactivate")
      	     .text("Activate");
      	     
    	  } else {
      	  messages.addClass("failure");
      	  messages.removeClass("success");
      	  module.removeClass("module-active");
      	  module.addClass("module-failed");
    	  }
    	  
    	  messages.html(response.message).slideDown(300);
    	  
  	  }
	  );  	  
  });

 
  // Delete button
  $(document).on("click", "a.module-delete", function(e) {
	  
	  e.preventDefault();
	  
	  var elem = $(this);
	  var module = elem.closest(".single-module");
	  var messages = module.find(".module-messages");
	  
	  if ( confirm(BeaverBrewer.moduleDeleteConfirm)) {
  	  $.post(
    	  ajaxurl,
    	  {
      	  action: "beaver_brewer_delete",
      	  _ajax_nonce: BeaverBrewer.ajaxNonce,
      	  module: elem.data("module")
    	  },
    	  function(response) {
      	  
      	  $("html, body").animate({scrollTop: messages.offset().top},500);
      	  
      	  if (response.success) {
        	  messages.addClass("success");
        	  messages.removeClass("failure");
        	  module.removeClass("module-failed");   
        	  module.removeClass("module-active");
        	  
      	  } else {
        	  messages.addClass("failure");
        	  messages.removeClass("success");
        	  module.removeClass("module-active");
        	  module.addClass("module-failed");
      	  }
      	  
      	  messages.html(response.message).slideDown(300, function() {
        	  if (response.success) {
             setTimeout( function() { module.remove(); }, 3000);
        	  }
      	  });      	  
    	  }
  	  );  	  
	  }
  });
  
  
  
  
  $(document).ready(function() {
    
    var uploader = new plupload.Uploader(BeaverBrewer.pluploadConfig);
    
    // Ensure browser supports drag and drop
    uploader.bind('Init', function(up){
      var uploaddiv = $('#installed-modules');

      if(up.features.dragdrop){
        uploaddiv.addClass('drag-drop');
          $('#module-list')
            .bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); $("#installed-modules h2").text(BeaverBrewer.dropToUploadText); })
            .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); $("#installed-modules h2").text(BeaverBrewer.installedModulesText); });

      }else{
        uploaddiv.removeClass('drag-drop');
        $('#module-list').unbind('.wp-uploader');
      }
    });

    uploader.init();
    
    // File added to queue
    uploader.bind('FilesAdded', function(up, files){
      var max = parseInt(up.settings.max_file_size, 10);

      plupload.each(files, function(file){        
        $("module-list .drag-drop-inside").before('<div class="uploading" id="' + file.id + '">Uploading ' + file.name + '...</div>').hide().slideDown(300);
      });

      up.refresh();
      up.start();
    });

    // File uploaded 
    uploader.bind('FileUploaded', function(up, file, response) {
      var response = $.parseJSON(response.response);
      console.log(response.response);
			window.location.reload();
    });

  });
  

})( jQuery );
