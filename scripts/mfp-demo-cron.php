<?php
// Copiar este arquivo para a pasta www/scripts do servidor
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'PASTE ONLINE PROJECT URL HERE');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("mfp-token: PASTE TOKEN HERE"));
$response = curl_exec($curl);
if ($response === false) {
    echo curl_error($curl);
} else {
    echo $response;
}
curl_close($curl);