
<?php
$ch = curl_init();
$headers  = [
            'Authorization:Bearer m01PwAFzTYxHYhs9saPYB537GvgACuST2nuQSi3ssgXAwEOQ2dZlo/SqKNwERVP3oCJUctFR8KrwKwbJZjAMZgb2BAUlKfsy0FWag1KcqAMLBaG7oOCSo9UnCBaE0nmsi802+gbwrq+KTc6VNXOZ0gdB04t89/1O/w1cDnyilFU=',
            'Content-Type: application/json'
        ];
$postData =' {
    "messages":[
        {
            "type":"text",
            "text":"ท่านมีตำแหน่งงานใหม่ กดที่่ลิงค์เพื่อดู"
        },
        {
            "type": "sticker",
            "packageId": "11537",
            "stickerId": "52002739"
        }
 ]   
}';


curl_setopt($ch, CURLOPT_URL,"https://api.line.me/v2/bot/message/broadcast");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);           
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result     = curl_exec ($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo $result;
echo $statusCode;
?>