$(document).ready(function () {
    'use strict';
    var div = document.getElementById('search-results1');
    var inputField = $('#subject_names'); // Cache the input field for easy access
    var isThrottled = false;
    var throttleTimeout;

    // Event listener for input changes
    inputField.on('input', function () {
        if (!isThrottled) {
            isThrottled = true;

            throttleTimeout = setTimeout(function () {
                isThrottled = false;

                var query = inputField.val().trim();
                if (query !== '') {
                    $.ajax({
                        url: '../../views/files/loadSubject.php',
                        method: 'POST',
                        data: { name: query },
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            div.innerHTML = ''; // clear the div
                            if (data.length > 0) {
                                var html = '<ul>';
                                data.forEach(function (subject, index) {
                                    html += '<li data-subject_id="' + subject.id + '">' + subject.name + ' (ID: ' + subject.id + ')</li>';
                                });
                                html += '</ul>';
                                div.innerHTML = html;
                                div.style.display = 'block';
                            } else {
                                div.innerHTML = 'No matching subjects found';
                                div.style.display = 'block';
                            }
                        },
                        error: function () {
                            div.innerHTML = 'No matching subjects found';
                        }
                    });
                } else {
                    $('#search-results1').empty();
                    if (div !== null) {
                        div.style.display = "none";
                    }
                }
            }, 300); // Adjust the throttle interval as needed
        }
    });
    // Event delegation to handle click on list items
    $('#search-results1').on('click', 'li', function () {
        var selectedValue = $(this).text().split(' (ID: ')[0]; // Extract subject name from the clicked item
        inputField.val(selectedValue); // Set input value
        inputField.focus(); // Set focus to input field
        if (div !== null) {
            div.style.display = "none";
        }
    });

    // Close the search results when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search-results1').length && !$(e.target).is(inputField)) {
            if (div !== null) {
                div.style.display = "none";
            }
        }
    });
});
