<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('encode_id')) {

    function encode_id($string)
    {
        $string = $string . ' ' . date('YmdHis') . random_string('alnum', 8);
        $output = false;
        /*
        * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
        */
        $security       = parse_ini_file("security.ini");
        $secret_key     = $security["encryption_key"];
        $secret_iv      = $security["iv"];
        $encrypt_method = $security["encryption_mechanism"];

        // hash
        $key    = hash("sha256", $secret_key);

        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv     = substr(hash("sha256", $secret_iv), 0, 16);

        //do the encryption given text/string/number
        $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($result);
        return $output;
    }
}

if (!function_exists('decode_id')) {

    function decode_id($string)
    {

        $output = false;
        /*
        * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
        */

        $security       = parse_ini_file("security.ini");
        $secret_key     = $security["encryption_key"];
        $secret_iv      = $security["iv"];
        $encrypt_method = $security["encryption_mechanism"];

        // hash
        $key    = hash("sha256", $secret_key);

        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv = substr(hash("sha256", $secret_iv), 0, 16);

        //do the decryption given text/string/number

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        $hasil = explode(" ", $output);
        return $hasil[0];
    }
}

function strToHex($string)
{
    $hex = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0' . $hexCode, -2);
    }
    return $hex;
}

function hexToStr($hex)
{
    $string = '';
    for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
        $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $string;
}