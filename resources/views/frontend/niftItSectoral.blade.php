<?php

$endpoint = 'https://www.nseindia.com/api/equity-stockIndices';
$index = 'NIFTY AUTO';

// Build the URL with query parameters
$url = $endpoint . '?index=' . urlencode($index);

// Initialize cURL
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Authorization: YOUR_API_KEY_HERE'
));

// Execute the cURL request
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    echo "Failed to fetch data from the API: " . curl_error($curl);
    exit;
}

// Get the HTTP status code
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($curl);

// Check if the request was successful
if ($httpCode !== 200) {
    echo "Failed to fetch data from the API. HTTP status code: " . $httpCode;
    exit;
}

// Parse the JSON response
$data = json_decode($response, true);

// Check if data is available
if (!isset($data['data']) || empty($data['data'])) {
    echo "No data available for the specified index.";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>NIFTY AUTO Stock Index</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>NIFTY AUTO Stock Index</h1>
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Company</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['data'] as $item): ?>
                <tr>
                    <td><?= $item['symbol']; ?></td>
                    <td><?= $item['companyName']; ?></td>
                    <td><?= $item['dayHigh']; ?></td>
                    <td><?= $item['dayLow']; ?></td>
                    <td><?= $item['lastPrice']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
