<?php
include_once "private/keys.php";

class HCaptcha {
    // TODO
    const enabled = false;
    public function verify($verify): bool {
        if(!HCaptcha::enabled) {
            return true;
        }
        $data = array(
            'secret' => Keys::hcaptchaSecret,
            'response' => $verify
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "http://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($verify));
        return $response->success;
    }
}

$hcaptcha = new HCaptcha();