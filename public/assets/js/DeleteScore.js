function deleteRecord(scoreId) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: "POST",
      url: "../../views/files/DeleteScore.php",
      data: { id: scoreId },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          resolve();
        } else {
          reject("Error deleting record");
        }
      },
      error: function (xhr, status, error) {
        reject("AJAX request failed: " + status + ", " + error);
      },
    });
  });
}

$(document).ready(function () {
  $(".deleteScore_").on("click", function (e) {
    e.preventDefault();
    var scoreId = $(this).data("id");
    var $deleteButton = $(this); // Store reference to the clicked button
    if (confirm("Are you sure you want to delete this record?")) {
      deleteRecord(scoreId)
        .then(function () {
          $deleteButton.closest("tr").remove();
          loadPage();
          showFlashMessage("Record deleted successfully");
        })
        .catch(function (error) {
          showFlashMessage(
            "Failed to delete record. Please try again.",
            "danger"
          );
        });
    }
  });
});
