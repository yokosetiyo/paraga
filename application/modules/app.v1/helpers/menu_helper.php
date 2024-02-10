<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function load_menu()
{
    $data = '';
    $ci = &get_instance();
    $menu = $ci->session->userdata('menu');
    foreach($menu[1] as $val_1){
        if(empty($val_1->link)){
            $data .= '
                <li class="nav-item">
                    <a href="#">
                        <i class="bx '.$val_1->icon.'"></i>
                        <span class="menu-title" data-i18n="'.ucwords($val_1->nama).'">'.ucwords($val_1->nama).'</span>
                    </a>
                    <ul class="menu-content">
            ';
            if(!empty($menu[2][$val_1->id_menu])){ 
                foreach($menu[2][$val_1->id_menu] as $val_2){
                    if(empty($val_2->link)){
                        $data .= '
                            <li>
                                <a href="#">
                                    <i class="bx bx-right-arrow-alt"></i>
                                    <span class="menu-item" data-i18n="'.ucwords($val_2->nama).'">'.ucwords($val_2->nama).'</span>
                                </a>
                                <ul class="menu-content">
                        ';
                        if(!empty($menu[3][$val_2->id_menu])){
                            foreach($menu[3][$val_2->id_menu] as $val_3){
                                $data .= '
                                    <li>
                                        <a id="'.$val_3->id_menu.'" '.check_menu_url($val_3).'>
                                            <i class="bx bx-right-arrow-alt"></i>
                                            <span class="menu-item" data-i18n="'.ucwords($val_3->nama).'">'.ucwords($val_3->nama).'</span>
                                        </a>
                                    </li>
                                ';
                            }
                        }
                        $data .= '
                                </ul>
                            </li>
                        ';
                    }else{
                        $data .= '
                            <li class="'.set_active_menu($val_2).'">
                                <a id="'.$val_2->id_menu.'" '.check_menu_url($val_2).'>
                                    <i class="bx bx-right-arrow-alt"></i>
                                    <span class="menu-item" data-i18n="'.ucwords($val_2->nama).'">'.ucwords($val_2->nama).'</span>
                                </a>
                            </li>
                        ';
                    }
                }
            }
            $data .= '
                    </ul>
                </li>
            ';
        }else{
            $data .= '
                <li class="'.set_active_menu($val_1).' nav-item">
                    <a id="'.$val_1->id_menu.'" '.check_menu_url($val_1).'>
                        <i class="bx '.$val_1->icon.'"></i>
                        <span class="menu-title">'.ucwords($val_1->nama).'</span>
                    </a>
                </li>
            ';
        }
    }
    return $data;
}

function check_menu_url($val)
{
    if($val->tipe_link == 'system'){
        $val = ' href="'.base_url($val->link).'" ';
    }else{
        $val = ' target="_blank" href="'.$val->link.'" ';
    }
    return $val;
}

function set_active_menu($val)
{
    $ci = &get_instance();
    $active = str_replace('app/v1/','',$val->link);
    $active = explode('/',$active);
    if($ci->uri->segment(3) == $active[0]) {
        $val = 'active';
    } else {
        $val = '';
    }
    return $val;
}

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