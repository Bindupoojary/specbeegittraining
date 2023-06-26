(function ($, Drupal , drupalSettings) {

    $.fn.datacheck = function() {
        console.log(" form working");
        $(".custom-form-user-details").submit();
    };

    // $(document).ready(function(){
    //     $("#edit-check").click(function(){
    //       $("#edit-temporary").hide();
    //     });
    //   });



      $(document).ready(function() {

        var checkbox = $('#edit-check');
        var temporaryAddressFields = $('.form-item-temporary');

        checkbox.on('change', function() {
              if ($(this).is(':checked')) {
            temporaryAddressFields.hide();
          } else {

            temporaryAddressFields.show();
          }
        });
      });

      Drupal.behaviors.MyModuleBehavior = {
        attach: function(context, settings) {
          // get color_body value with "drupalSettings.mymodule.color_body"
            var color_body = drupalSettings.binduu_exercise.color_body;
            console.log(color_body)
            $('body').css('background', color_body);
        }
    };




}(jQuery, Drupal, drupalSettings));



