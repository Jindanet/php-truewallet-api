<?php

// ให้วาง api ไว้ที่ เซิฟเวอร์ต่างประเทศ ที่ไม่ใช่ไทย
// กรณีถ้าส่งจากเซิฟเวอร์ในไทยจะโดน cloudflare block

// กรณีของผมเลือกใช้ http://tiny.host/ ฟรี

$voucher = $_GET['voucher'] ?? null; // ลิ้งซองอั่งเปาแบบเต็ม https://gift.truemoney.com/campaign/?v=xxxx
$phone = $_GET['phone'] ?? "กรอกเบอร์ กรณีไม่มีการส่งค่าอะไรมา จะใช้เบอร์ที่กรอกไว้ตรงนี้รับซอง";

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
