  <?php 

  // Send the data from the PHP form to our backend container node, the load balancer is running on port 4000.
  $url = 'http://backend_loadbalancer:4000/logic.php'; // Docker-compose node URL for the backend

  $url .= '?primeNumber=' . urlencode($_GET['primeNumber']) . '&page=' . urlencode($_GET['page']);

  $response = file_get_contents($url);
  $body = "";

  $header = file_get_contents("header.html");
  $footer = file_get_contents("footer.html");

  // Decode the JSON response into an array
  $result = json_decode($response, true);

  if ($result !== null) {
      $primeNumbers = implode(', ', $result['primeNumbers']);
      $totalPages = $result['totalPages'];
      $primeNumber = $_GET['primeNumber'];

      // Get the current page number from the query parameter 'page'
      $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

      // Check if the current page is the last page
      $isLastPage = ($page == $totalPages);

      // Prepare pagination links
      $paginationLinks = '';

      if ($page > 1) {
          $prevPage = $page - 1;
          $paginationLinks .= '<a class="pagination-link" href="form.php?primeNumber=' . $_GET['primeNumber'] . '&page=' . $prevPage . '">Previous Page</a>';
      }

      if (!$isLastPage) {
          $nextPage = $page + 1;
          $paginationLinks .= '<a class="pagination-link" href="form.php?primeNumber=' . $_GET['primeNumber'] . '&page=' . $nextPage . '">Next Page</a>';
      }

      // Include the current page number in the response
      $currentPage = $result['currentPage'];
      $body = <<<HTML
      <div class="result-container" style="display: flex; justify-content: center; align-items: center; block-size: 100vh;">
        <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
          <h3><b>Prime Number</b></h3>
          <br>
          <br>
          <h4 style="margin-block-end: 10px;"><b>Your selected number: $primeNumber</b></h4>
          <br>
          <table style="margin: 0 auto;">
            <tr>
              <td style="text-align: start;">$primeNumbers</td>
            </tr>
          </table>
          <br>
          <p><b>Page $currentPage of $totalPages</b></p> <!-- Display the current page number -->
          <br>
          <button class="btn btn-lg btn-primary btn-block" style="margin-block-start: 10px; inline-size: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Enter another prime number</button>
          <br>
          <div class="pagination">
            $paginationLinks
          </div>
        </div>
      </div>
      HTML;
  } else {
    if (trim($response) === "INVALID") {
      $body = <<<HTML
    <div style="display: flex; justify-content: center; align-items: center; block-size: 100vh;">
      <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
        <h1><b>Invalid Input</b></h1>
        <br>
        <p>Please enter a valid number greater than 0 and less than or equal to 99999.</p>
        <br>
        <button class="btn btn-lg btn-primary btn-block" style="margin-block-start: 10px; inline-size: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Try Again</button>
      </div>
    </div>
    HTML;
    
  } else {
      $body = <<<HTML
    <div style="display: flex; justify-content: center; align-items: center; block-size: 100vh;">
      <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
        <h1><b>Error</b></h1>
        <br>
        <p>An error occurred processing the form.</p>
        <br>
        <button class="btn btn-lg btn-primary btn-block" style="margin-block-start: 10px; inline-size: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Try Again</button>
      </div>
    </div>
    HTML;
  }
  }
  echo $header;
  echo $body;
  echo $footer;

  ?>

  <style>


  @media screen and (max-width: 600px) {
    .pagination {
      flex-direction: column;
      align-items: center;
    }
    .pagination-link {
      margin: 4px 0;
    }
  }
    .pagination {
      margin-block-start: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .pagination-link {
      display: inline-block;
      padding: 8px 12px;
      margin: 4px;
      border: 1px solid #ccc;
      background-color: #f9f9f9;
      color: #333;
      text-decoration: none;
    }
    .pagination-link:hover {
      background-color: #e9e9e9;
    }
    .result-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100%;
  }
    .result-container button {
      margin-block-start: 20px;
    }
  </style>