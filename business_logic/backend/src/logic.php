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
    if ($primeNumber <= 99999) {
        $result = array();

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
            'totalPages' => $totalPages
        );

        // Send the response
        echo json_encode($responseData);
        exit;
    } elseif ($primeNumber > 99999) {
        echo 'INVALID';
        exit;
    } else {
        // Invalid input - exceed maximum limit
        echo json_encode(array('error' => 'Invalid input'));
        exit;
    }
}
?>
