<?php
// script para colar dentro da raiz www/scripts dentro da King Host
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://my-finances-planner-demo.jhon.dev.br/api/cron/reset-database-demo');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
if ($response === false) {
    $error = curl_error($curl);
} else {
    echo $response;
}
curl_close($curl);