<?php

function loginPointBlank($username, $password) {

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://www.pointblank.id/login/process",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "loginFail=0&userid=" . $username . "&password=" . $password,
    CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
    CURLOPT_HTTPHEADER => [
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Encoding: gzip, deflate, br",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Cache-Control: max-age=0",
        "Connection: keep-alive",
        "Content-Type: application/x-www-form-urlencoded",
        "Host: www.pointblank.id",
        "Origin: https://www.pointblank.id",
        "Referer: https://www.pointblank.id/login/form",
        "Sec-Fetch-Dest: document",
        "Sec-Fetch-Mode: navigate",
        "Sec-Fetch-Site: same-origin",
        "Sec-Fetch-User: ?1",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36",
        'sec-ch-ua: "Google Chrome";v="87", " Not;A Brand";v="99", "Chromium";v="87"',
        "sec-ch-ua-mobile: ?0"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    preg_match_all('/Data login yang anda masukan tidak sesuai./', $response, $isLogin);

    $isLogin = json_encode($isLogin, true);

    if(strlen($isLogin) == 4)
    {
        return true;
    } else {
        return false;
    }
}

function xmasReward($id_reward){

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://www.pointblank.id/event/xmas/reward/process?prize=" . $id_reward,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_COOKIEFILE => 'cookie.txt',
        CURLOPT_HTTPHEADER => [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
            "Accept-Encoding: gzip, deflate, br",
            "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
            "Connection: keep-alive",
            "Host: www.pointblank.id",
            "Referer: https://www.pointblank.id/event/xmas",
            "Sec-Fetch-Dest: iframe",
            "Sec-Fetch-Mode: navigate",
            "Sec-Fetch-Site: same-origin",
            "Upgrade-Insecure-Requests: 1",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36",
            'sec-ch-ua: "Google Chrome";v="87", " Not;A Brand";v="99", "Chromium";v="87"',
            "sec-ch-ua-mobile: ?0"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        switch($id_reward) {
            case 1:
                $reward = "AUG A3 X-MAS19 (7D)";
                break;
            case 2:
                $reward = "Tactilite T2 X-MAS19 (7D)";
                break;
            case 3:
                $reward = "SC2010 X-MAS19 (7D)";
                break;
            case 4:
                $reward = "Kriss S.V X-MAS2019 (15D)";
                break;
        }
            
        $response = json_decode($response, true);

        if ($response['resultCode']) {
            echo "[+] " . $response['voucher'] . " | " . $reward . "\n";
        }
    }
}

echo "[?] Username? ";
$username = trim(fgets(STDIN));

echo "[?] Password? ";
$password = trim(fgets(STDIN));

echo "[+] Login account " . $username . ". \n";
if(loginPointBlank($username, $password))
{
    echo "[+] Logged in account " . $username . " ..\n";
    echo "[+] Get rewards .. \n";
    
    $i = 1;
    
    while ($i) {
        xmasReward($i);
        if ($i == "4") {
            break;
        }
        $i++;
    }

    unlink('cookie.txt');

} else {
    echo "[-] Please login first ";
}