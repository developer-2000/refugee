<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

trait RecaptchaTraite {

    /**
     * верификация пришедшего token с фронта
     * @param $token
     * @param $ip
     * @return mixed
     */
    protected function checkRecaptcha($token, $ip) {
        $post_data = "secret=".env("RECAPTCHAV2_SECRET","")."&response=".$token."&remoteip=".$ip;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8', 'Content-Length: ' . strlen($post_data)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $googresp = curl_exec($ch);
        $response = json_decode($googresp);
        curl_close($ch);

        return $response->success;
    }

}
