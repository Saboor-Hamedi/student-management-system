$(function () {
    'use strict';
    var div = document.getElementById('search-results3');
    var selectedTeacherIdField = $('#student_profile_id');
    // Event listener for input changes
    $('#search_student_profile_name').on('input', function () {
        var query = $(this).val().trim();

        if (query !== '') {
            // Make an AJAX call to the PHP file to get the search results
            $.ajax({
                url: '../../views/files/Makestudentprofile.php',
                method: 'POST',
                data: { roles_id: query },
                dataType: 'json',
                cache: false,
                success: function (data) {
                    div.innerHTML = ''; // clear the div
                    if (data.length > 0) {
                        var html = '<ul>'; // create an unordered list
                        data.forEach(function (teacher, index) {
                            // Append each teacher's data to the list
                            html += '<li data-student_profile_id="' + teacher.id + '">' + teacher.username + ' (ID: ' + teacher.id + ')</li>';
                        });
                        html += '</ul>'; // Close the list
                        div.innerHTML = html; // Set the content of the results container
                        div.style.display = 'block';
                    } else {
                        div.innerHTML = 'No matching subjects found';
                        div.style.display = 'block';
                    }
                },
                error: function () {
                    // Handle errors if necessary
                    div.innerHTML = 'No matching teachers found';
                }
            });
        } else {
            // Clear the results container if the input is empty
            $('#search-results3').empty();
            selectedTeacherIdField.val(''); // Clear the hidden input value
            if (div !== null) {
                div.style.display = "none";
            }
        }
    });

    // Event delegation to handle click on list items
    $('#search-results3').on('click', 'li', function () {
        var teacherId = $(this).data('student_profile_id');
        var teacherName = $(this).text().split(' (ID:')[0]; // Extract the teacher name from the list item text
        $('#search_student_profile_name').val(teacherName);
        selectedTeacherIdField.val(teacherId);
        $('#search_student_profile_name').focus();
        if (div !== null) {
            div.style.display = "none";
        }
    });
    // Close the search results when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search-results3').length) {
            if (div !== null) {
                div.style.display = "none";
            }
        }
    });
});
