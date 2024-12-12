<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = 'http://127.0.0.1:8000/contact-api/';
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message']
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo 'Error submitting the form.';
    } else {
        echo $result;
    }
}
?>
