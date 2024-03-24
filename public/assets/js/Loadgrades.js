$(document).ready(function () {
    'use strict';
    var div = document.getElementById('search-results3');
    var selectedTeacherIdField = $('#student_grade_id');
    // Event listener for input changes
    $('#student_subject_name').on('input', function () {
        var query = $(this).val().trim();

        if (query !== '') {
            // Make an AJAX call to the PHP file to get the search results
            $.ajax({
                url: '../../views/files/Loadgrades.php',
                method: 'POST',
                data: { name: query },
                dataType: 'json',
                cache: false,
                success: function (data) {
                    div.innerHTML = ''; // clear the div
                    if (data.length > 0) {
                        var html = '<ul>'; // create an unordered list
                        data.forEach(function (all_grades, index) {
                            // Append each all_grades's data to the list
                            html += '<li data-student_grade_id="' + all_grades.id + '">' + all_grades.name + ' (ID: ' + all_grades.id + ')</li>';
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
        var teacherId = $(this).data('student_grade_id');
        var teacherName = $(this).text().split(' (ID:')[0]; // Extract the teacher name from the list item text
        $('#student_subject_name').val(teacherName);
        selectedTeacherIdField.val(teacherId);
        $('#student_subject_name').focus();
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
