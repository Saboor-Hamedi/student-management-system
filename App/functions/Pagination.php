<?php

namespace Thesis\functions;

use Exception;

class Pagination
{
  public static function paginate($database, $data, $perPage = 3, $currentPage = null, $htmlGenerator = null)
  {
    // Check if $data is an array (assuming it's an array of results)
    $isArray = is_array($data);

    // Input validation
    $perPage = max(1, min(100, (int)$perPage)); // Limit perPage between 1 and 100
    $currentPage = max(1, (int)($currentPage ?? (isset($_GET['page']) ? $_GET['page'] : 1)));

    // If $data is an array, calculate total records directly
    if ($isArray) {
      $totalRecords = count($data);
    } else {
      // Execute the SQL query to get the total number of records
      $totalRecordsResult = $database->query("SELECT COUNT(*) as total FROM ($data) AS subquery");
      if (!$totalRecordsResult) {
        throw new Exception("Failed to count records: " . $database->error);
      }
      $totalRecords = $totalRecordsResult[0]['total'];
    }

    // Calculate total pages
    $totalPages = ceil($totalRecords / $perPage);

    // If the current page becomes empty after deleting a record, move to the previous page
    if ($currentPage > 1 && ($currentPage - 1) * $perPage >= $totalRecords) {
      $currentPage--;
    }

    // Calculate the offset for fetching records
    $offset = ($currentPage - 1) * $perPage;

    // If $data is an array, slice it to get the records for the current page
    if ($isArray) {
      $result = array_slice($data, $offset, $perPage);
    } else {
      // Modify the SQL query to include LIMIT and OFFSET
      $data .= " LIMIT $perPage OFFSET $offset";

      // Perform the modified query to get the records for the current page
      $result = $database->query($data);
    }

    // Check if pagination is needed
    $paginationHtml = '';
    if ($totalPages > 1) {
      // Generate pagination HTML
      $paginationHtml = is_callable($htmlGenerator) ? $htmlGenerator($currentPage, $totalPages) : self::generatePaginationHtml($currentPage, $totalPages);
    }

    // Return the pagination HTML along with the records for the current page
    return [
      'paginationHtml' => $paginationHtml,
      'records' => $result
    ];
  }

  private static function generatePaginationHtml($currentPage, $totalPages)
  {
    $html = '<nav aria-label="Page navigation example">';
    $html .= '<ul class="pagination">';

    // Add previous link if not on the first page
    if ($currentPage > 1) {
      $html .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a></li>';
    }

    // Generate page links
    for ($i = 1; $i <= $totalPages; $i++) {
      if ($i == $currentPage) {
        $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
      } else {
        $html .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
      }
    }

    // Add next link if not on the last page
    if ($currentPage < $totalPages) {
      $html .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a></li>';
    }

    $html .= '</ul>';
    $html .= '</nav>';

    return $html;
  }
}
