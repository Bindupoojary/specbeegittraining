(function (window, document, drupalSettings) {
  function datacheck() {
    console.log("form working");
    document.querySelector(".custom-form-user-details").submit();
  }

  var checkbox = document.getElementById("edit-check");
  var temporaryAddressFields = document.querySelectorAll(".form-item-temporary");

  checkbox.addEventListener("change", function () {
    if (this.checked) {
      temporaryAddressFields.forEach(function (field) {
        field.style.display = "none";
      });
    } else {
      temporaryAddressFields.forEach(function (field) {
        field.style.display = "block";
      });
    }
  });

  var colorBody = drupalSettings.binduu_exercise.color_body;
  document.body.style.background = colorBody;
})(window, document, drupalSettings);
