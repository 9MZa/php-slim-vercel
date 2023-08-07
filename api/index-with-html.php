<?php

function lookupWord($keyword) {
    $curl = curl_init();

    $data = array(
        'word' => $keyword,
        'funcName' => 'lookupWord',
        'status' => 'lookup'
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dictionary.orst.go.th/func_lookup.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_SSL_VERIFYPEER => false,
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        return 'cURL Error: ' . curl_error($curl);
    } else {
        return $response;
    }

    curl_close($curl);
}

// Handle the API request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];

    if (empty($keyword)) {
        echo 'Keyword is required.';
    } else {
        $result = lookupWord($keyword);
        echo $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dictionary API</title>
</head>
<body>
    <form method="post" action="">
        Keyword: <input type="text" name="keyword">
        <input type="submit" value="Search">
    </form>
</body>
</html>
