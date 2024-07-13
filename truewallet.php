<?php
declare(strict_types=1);

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
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($ch, CURLOPT_USERAGENT, "aaaaaaaaaaa");

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        // Handle cURL error
        $error_msg = curl_error($ch);
        curl_close($ch);
        echo "cURL error: $error_msg";
        return null;
    }

    curl_close($ch);
    echo $response;
    return $response;
}

$hash = $_GET["hash"] ?? null;
$phone = "เบอร์ที่ต้องการรับซอง";

if ($hash) {
    $gift = giftcode($hash, $phone);
}
?>
