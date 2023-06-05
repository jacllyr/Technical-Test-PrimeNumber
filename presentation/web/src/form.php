<?php
  // Send the data from the php form to our backend container node, the load balancer is running on port 4000.
  $url = 'http://backend_loadbalancer:4000/logic.php'; // Docker-compose node URL for backend

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
    
    // Get the current page number from the query parameter 'page'
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    // Check if the current page is the last page
    $isLastPage = ($page == $totalPages);

    // Prepare pagination links
    $paginationLinks = '';
    if (!$isLastPage) {
      $nextPage = $page + 1;
      $paginationLinks .= '<a href="form.php?primeNumber=' . $_GET['primeNumber'] . '&page=' . $nextPage . '">Next Page</a>';
    }

    $body = <<<HTML
    <div style="display: flex; justify-content: center; align-items: center; block-size: 100vh;">
      <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
        <h1><b>Prime Number</b></h1>
        <br>
        <p style="margin-block-end: 10px;"><b>Here are your results:</b></p>
        <table style="margin: 0 auto;">
          <tr>
            <td style="text-align: start; padding-inline-end: 10px;"><b>Prime numbers</b></td>
            <td style="text-align: start;">$primeNumbers</td>
          </tr>
        </table>
        <br>
        <button class="btn btn-lg btn-primary btn-block" style="margin-block-start: 10px; inline-size: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Enter another prime number</button>
        <br>
        <div class="pagination">
          $paginationLinks
        </div>
      </div>
    </div>
    HTML;
    
  } else if ($response === "INVALID") {
    $body = <<<HTML
  <div style="display: flex; justify-content: center; align-items: center; block-size: 100vh;">
    <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
      <h1><b>Invalid Input</b></h1>
      <br>
      <p>Please enter a valid number no more greater than 99999</p>
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
      <p>An error occurred. Please try again later.</p>
      <br>
      <button class="btn btn-lg btn-primary btn-block" style="margin-block-start: 10px; inline-size: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Try Again</button>
    </div>
  </div>
  HTML;
  }

  echo $header;
  echo $body;
  echo $footer;
?>
