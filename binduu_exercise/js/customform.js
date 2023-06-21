// (function ($, Drupal) {

//     $.fn.datacheck = function() {
//         alert(" form working");
//         $(".custom-form-user-details").submit();
//     };

//     // $(document).ready(function(){
//     //     $("#edit-check").click(function(){
//     //       $("#edit-temporary").hide();
//     //     });
//     //   });



//       $(document).ready(function() {

//         var checkbox = $('#edit-check');
//         var temporaryAddressFields = $('.form-item-temporary');

//         checkbox.on('change', function() {
//               if ($(this).is(':checked')) {
//             temporaryAddressFields.hide();
//           } else {

//             temporaryAddressFields.show();
//           }
//         });
//       });





// }(jQuery, Drupal));

(function($, Drupal, drupalSettings) {
  Drupal.behaviors.MyModuleBehavior = {
      attach: function(context, settings) {
          var color_body = drupalSettings.binduu_exercise.color_body;
          alert(color_body)
          $('body').css('background', color_body);
      }
  };
})(jQuery, Drupal, drupalSettings);

