function deleteTeacherRecord(studentId) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: "POST",
      url: "../../views/files/DeleteTeacher.php",
      data: { id: studentId },
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
function deleteTeacher() {
  $(document).ready(function () {
    $(".deleteTeacher_").on("click", function (e) {
      e.preventDefault();
      var studentId = $(this).data("id");
      var $deleteButton = $(this);

      if (confirm("Are you sure you want to delete this record?")) {
        deleteTeacherRecord(studentId)
          .then(function () {
            $deleteButton.closest("tr").remove();
            loadPage();
            showFlashMessage("Record deleted successfully");
          })
          .catch(function (error) {
            loadPage();
            showFlashMessage("Failed to delete record. Please try again", "danger");
          });
      }
    });
  });
}

deleteTeacher();
