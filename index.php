<?php

$voucher = $_GET['v'] ?? null;
$phone = $_GET['phone'] ?? "0617584255";

function giftcode(string $hash, string $phone): ?string {
    if (empty($hash) || empty($phone)) {
        return null;
    }
    
    // Extract the voucher hash from the URL parameter
    $hashParts = explode('?v=', $hash);
    if (count($hashParts) > 1) {
        $hash = $hashParts[1];
    }

    $ch = curl_init();

    $headers = [
        'Content-Type: application/json',
        'Accept: application/json'
    ];
    $postData = [
        'mobile' => $phone,
        'voucher_hash' => $hash
    ];

    curl_setopt($ch, CURLOPT_URL, "https://gift.truemoney.com/campaign/vouchers/$hash/redeem");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_3);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36 Edg/84.0.522.52");

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        // Handle cURL error
        $error_msg = curl_error($ch);
        curl_close($ch);
        return null;
    }

    curl_close($ch);
    return $response;
}


$response = giftcode($voucher, $phone);
print_r($response);
return $response;


?>
