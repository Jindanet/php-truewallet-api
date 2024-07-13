<?php
function giftcode($hash = null, $phone = null) {
  if (is_null($hash) || is_null($phone)) return false;
  $ch = curl_init();
  @$hash = explode('?v=', $hash)[1];
  $headers  = [
    'Content-Type: application/json',
    'Accept: application/json'
  ];
  $postData = [
    'mobile' => $phone,
    'voucher_hash' => $hash
  ];
  curl_setopt($ch, CURLOPT_URL,"https://gift.truemoney.com/campaign/vouchers/$hash/redeem");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_SSLVERSION, 7);
  curl_setopt($ch, CURLOPT_USERAGENT, "aaaaaaaaaaa");
  $response = curl_exec($ch);
  echo $response;
  return $response;
}

$hash = $_GET["link"];
$phone = "เบอร์โทรศัพท์ที่ต้องการรับเงินจากซอง";

$gift = giftcode($hash, $phone);

/** 
 GET = https://yourdomain.com/truewallet.php?link=https://gift.truemoney.com/campaign/?v=xxxxxx
**/
?>
