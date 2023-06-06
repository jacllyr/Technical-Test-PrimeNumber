    <?php

    // Function to check if a number is prime
    function isPrime($number)
    {
        if ($number < 2) {
            return false;
        }

        for ($i = 2; $i <= sqrt($number); $i++) {
            if ($number % $i == 0) {
                return false;
            }
        }
        return true;
    }

    // Check if the form has been submitted
    if (isset($_GET['primeNumber'])) {
        $primeNumber = intval($_GET['primeNumber']);
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Check if the input is within the valid range
        if ($primeNumber <= 99999 && $primeNumber > 0) {
            $result = array();

            // Generate prime numbers from 2 up to the largest prime number less than or equal to the input number
            for ($i = 2; $i <= $primeNumber; $i++) {
                if (isPrime($i)) {
                    $result[] = $i;
                }
            }

            // Number of prime numbers to display per page
            $perPage = 50;
            $totalPages = ceil(count($result) / $perPage); // Calculate the total number of pages

            // Calculate the starting index and ending index of the prime numbers for the current page
            $startIndex = ($page - 1) * $perPage;
            $endIndex = $startIndex + $perPage;
            $primeNumbersPerPage = array_slice($result, $startIndex, $perPage);

            // Prepare the response data
            $responseData = array(
                'primeNumbers' => $primeNumbersPerPage,
                'totalPages' => $totalPages,
                'currentPage' => $page // Include the current page number in the response
            );

            // Send the response as JSON with HTTP status code 200 (OK)
            http_response_code(200);
            echo json_encode($responseData);
            exit;
        } else {
            // Send the "INVALID" response
            echo "INVALID";
            exit;
        }
    } else {
        // Send a 400 response for other errors (ERROR)
        http_response_code(400);
        echo "An error occurred processing the request.";
        exit;
    }
    ?>