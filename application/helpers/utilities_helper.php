<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

use Carbon\CarbonImmutable;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

if (!function_exists("cast_to_native_type")) {
    function cast_to_native_type($data, $column)
    {
        try {
            $data_type = gettype($data[0]);
            // Convert StdClass /Object to Array
            if (is_object($data)) {
                $data   = json_decode(json_encode($data), true);
            }

            $column = json_decode(json_encode($column), true);

            $data = array_map(function ($data)  use ($column) {
                foreach ($column as $c) {
                    $column_name = $c["name"];

                    switch ($c["type"]) {
                            // String
                        case 1:
                            $data[$column_name] =  trim(strval($data[$column_name]));
                            break;
                            // Integer Number
                        case -5:
                        case 4:
                            $data[$column_name] =  (int) $data[$column_name];
                            break;
                        case 2:
                        case 3: //Decimal / Float
                            $data[$column_name] =  floatval($data[$column_name]);
                            break;
                        default:
                            $data[$column_name] =  trim(strval($data[$column_name]));
                            break;
                    }
                }
                return $data;
            }, $data);

            if ($data_type == "object") {
                return (object) $data; //Convert To StdClass / Object
            } else {
                return $data;
            }
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (!function_exists("build_param_model")) {
    function build_param_model($type = "array")
    {
        switch ($type) {
            case "array":
                $default = array();
                break;
            case "string":
                $default = "";
                break;
        }

        $array = array(
            "filter" => $default,
            "fields" => $default,
            "limit"  => $default,
            "start"  => $default,
            "sort"   => $default,
            "group " => $default,
        );

        return $array;
    }
}

if (!function_exists("encrypt_pass_format")) {
    function encrypt_pass_format($data)
    {
        $axh = 0;
        $asc = 0;
        $jc = strlen($data);
        $bw = strrev($data);
        $c[] = $jc;
        $n[] = $jc;

        for ($axh = 0; $axh < $jc; $axh++) {
            $c[$axh] = substr($bw, $axh, $jc);
            if ((strlen($c[$axh]) > 0) || (strlen($c[$axh]) <= $jc)) {
                $asc = ord($c[$axh][0]);
            }
            if ($asc > 31 && $asc <= 126) {
                if ($asc > 79) {
                    $n[$axh] = chr(strval(($asc - 47)));
                } else {
                    $n[$axh] = chr(strval(($asc + 47)));
                }
            }
        }

        return join("", $n);
    }
}

if (!function_exists("decrypt_pass_format")) {
    function decrypt_pass_format($data)
    {
        $axh         = 0;
        $asc         = 0;
        $jc         = strlen($data);
        $bw         = strrev($data);
        $c[]         = $jc;
        $n[]         = $jc;
        $decrypt     = "";

        for ($axh = 0; $axh < $jc; $axh++) {
            $c[$axh] = substr($bw, $axh, $jc);
            if ((strlen($c[$axh]) > 0) || (strlen($c[$axh]) <= $jc)) {
                $asc = ord($c[$axh][0]);
            }
            if ($asc > 31 && $asc <= 126) {
                if ($asc < 79) {
                    $n[$axh] = chr(strval(($asc + 47)));
                } else {
                    $n[$axh] = chr(strval(($asc - 47)));
                }
            }

            $decrypt .= $n[$axh];
        }

        return $decrypt;
    }
}

if (!function_exists("check_user_session")) {
    function check_user_session()
    {
        $ci = &get_instance();

        $redirect = base_url($_SERVER["REQUEST_URI"]);

        if (empty($ci->session->userdata("USER_SESSION"))) {
            if ($ci->input->is_ajax_request()) {
                $ci->response([
                    "status"    => false,
                    "code"      => 403,
                    "message"   => "Session expired",
                    "redirecTo" => site_url("role")
                ], 403);
                exit;
            }

            redirect("role/auth" . "?redirect={$redirect}", "refresh");
        }
    }
}

if (!function_exists("get_date_now")) {
    function get_date_now($type = null)
    {
        $carbon = CarbonImmutable::now("Asia/Jakarta");

        switch ($type) {
            case "noreg":
                return $carbon->format("ymd");
                break;
            case "date":
                return $carbon->format("Y-m-d");
                break;
            case "month":
                return $carbon->format("m");
                break;
            case "year":
                return $carbon->format("y");
                break;
            case "year_month":
                return $carbon->format("Ym");
                break;
            case "standard_timestamp":
                return $carbon->format("d-m-Y H:i:s");
            default:
                return $carbon->format("Y-m-d H:i:s");
                break;
        }
    }
}

if (!function_exists("validate_date")) {
    function validate_date($date, $format)
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}

if (!function_exists("convert_standard_date")) {
    function convert_standard_date($date)
    {
        if (validate_date($date, "Y-m-d H:i:s")) {
            $dt     = DateTime::createFromFormat("Y-m-d H:i:s", $date);
            $data   = $dt->format("d-m-Y");
            return $data;
        } elseif (validate_date($date, "Y-m-d")) {
            $dt     = DateTime::createFromFormat("Y-m-d", $date);
            $data   = $dt->format("d-m-Y");
            return $data;
        } elseif (validate_date($date, "Y/m/d")) {
            $dt     = DateTime::createFromFormat("Y/m/d", $date);
            $data   = $dt->format("d-m-Y");
            return $data;
        } elseif (validate_date($date, "d/m/Y")) {
            $dt     = DateTime::createFromFormat("d/m/Y", $date);
            $data   = $dt->format("d-m-Y");
            return $data;
        } elseif (validate_date($date, "Ymd")) {
            $dt     = DateTime::createFromFormat("Ymd", $date);
            $data   = $dt->format("d-m-Y");
            return $data;
        }

        return $date;
    }
}

if (!function_exists("convert_mysql_date")) {
    function convert_mysql_date($date)
    {
        if (validate_date($date, "d-m-Y")) {
            $dt     = DateTime::createFromFormat("d-m-Y", $date);
            $data   = $dt->format("Y-m-d");
            return $data;
        } elseif (validate_date($date, "d/m/Y")) {
            $dt     = DateTime::createFromFormat("d/m/Y", $date);
            $data   = $dt->format("Y-m-d");
            return $data;
        } elseif (validate_date($date, "d-m-Y H:i")) {
            $dt     = DateTime::createFromFormat("d-m-Y H:i", $date);
            $data   = $dt->format("Y-m-d H:i:s");
            return $data;
        } elseif ($date == "") {
            $data = "0000-00-00";
            return $data;
        }

        return $date;
    }
}

if (!function_exists("convert_noreg_date")) {
    function convert_noreg_date($date)
    {
        if (validate_date($date, "d-m-Y")) {
            $dt     = DateTime::createFromFormat("d-m-Y", $date);
            $data   = $dt->format("ymd");
            return $data;
        } elseif (validate_date($date, "d/m/Y")) {
            $dt     = DateTime::createFromFormat("d/m/Y", $date);
            $data   = $dt->format("ymd");
            return $data;
        } elseif (validate_date($date, "d-m-Y H:i")) {
            $dt     = DateTime::createFromFormat("d-m-Y H:i", $date);
            $data   = $dt->format("ymd");
            return $data;
        } elseif (validate_date($date, "Y-m-d")) {
            $dt     = DateTime::createFromFormat("Y-m-d", $date);
            $data   = $dt->format("ymd");
            return $data;
        } elseif ($date == "") {
            $data = "000000";
            return $data;
        }

        return $date;
    }
}

if (!function_exists("convert_noreg_to_custom_date")) {
    function convert_noreg_to_custom_date($date, $format)
    {
        if (!validate_date($date, "ymd")) {
            throw new Exception("Format tanggal tidak sesuai");
        }

        switch ($format) {
            case "noreg_full_year":
                $dt     = DateTime::createFromFormat("ymd", $date);
                $data   = $dt->format("Ymd");
                return $data;
            default:
                break;
        }

        return $date;
    }
}

if (!function_exists("convert_date_custom_format")) {
    function convert_date_custom_format($date, $type = null)
    {
        $carbon = CarbonImmutable::parse($date);

        switch ($type) {
            case "weekday_number":
                return (int)$carbon->dayOfWeek;
            default:
                break;
        }

        return $date;
    }
}

if (!function_exists("compare_days")) {
    function compare_days($date_one, $date_two)
    {
        $one = CarbonImmutable::parse($date_one);
        $two = CarbonImmutable::parse($date_two);

        return intval($one->diffInDays($two));
    }
}

if (!function_exists("base64_to_image")) {
    function base64_to_image($b64, $path = false, $identitas = false)
    {
        $ci = &get_instance();
        $ci->load->library("Mime_type_detection");

        if (!$path)
            $path = sys_get_temp_dir();

        $path = $path . "/" . get_date_now("year_month");

        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }

        $base64 = explode(",", $b64);

        $data = base64_decode($base64[1] ?? $b64);

        $type = $ci->mime_type_detection->detect($data);

        if ($data === false) {
            throw new \Exception("base64_decode failed");
        }

        $filename = $identitas != false ? $identitas . "_" . rand() : rand() . "_" . rand();
        $fullpath = str_replace("\\", DIRECTORY_SEPARATOR, "{$path}" . DIRECTORY_SEPARATOR . "{$filename}.{$type}");
        file_put_contents($fullpath, $data);

        return array(
            "filename"  => "{$filename}.{$type}",
            "fullpath"  => str_replace("./", "", $fullpath),
        );
    }
}

if (!function_exists('getColumnTable')) {
    function getColumnTable($table)
    {
        if (!$table) return [];
        $this->db->select('COLUMN_NAME');
        $this->db->from('INFORMATION_SCHEMA.COLUMNS');
        $this->db->where('TABLE_NAME', $table);
        $this->db->where_not_in('COLUMN_NAME', array('ID', 'NOREG', 'CREATED_AT', 'CREATED_BY', 'UPDATED_AT', 'UPDATED_BY', 'DELETED_AT', 'DELETED_BY'));
        $query = $this->db->get()->result();
        return array_map(fn ($e) => $e->COLUMN_NAME, $query);
    }
}
if (!function_exists('uploadFile')) {
    function uploadFile($name, $path, $identitas = false, $fileExt = null, $maxSize = null)
    {
        $ci = &get_instance();
        $ci->load->library('upload');

        $timestamp         = get_date_now();

        $dest_folder     = "upload/" . $path . "/" . get_date_now("year_month");

        if (!file_exists($dest_folder)) {
            mkdir($dest_folder, 0700, true);
        }




        $config['upload_path'] = $dest_folder;

        $config['overwrite'] = false;

        $config['file_name'] = rand() . "{$timestamp}";
        if ($identitas) {
            $config['file_name'] = "{$identitas}_{$timestamp}";
        }

        if (!empty($fileExt)) {
            $config['allowed_types'] = $fileExt;
        } else {
            $config['allowed_types'] = "jpg|png|jpeg|bmp";
        }

        if (!empty($maxSize)) {
            $config['max_size'] = $maxSize;
        } else {
            $config['max_size'] = 500;
        }

        $ci->upload->initialize($config);

        if ($ci->upload->do_upload($name)) {
            $upload_data = $ci->upload->data();
            $upload_data["uploaded_path"] = $dest_folder . "/" . $upload_data['file_name'];
            return $upload_data;
        } else {
            $error = $ci->upload->display_errors();

            switch (true) {
                case strstr($error, "The filetype you are attempting to upload is not allowed."):
                    $error = "Jenis file yang diupload tidak diperbolehkan, untuk foto hanya boleh png,jpg. Untuk file dokumen hanya diperbolehkan pdf";
                    break;

                case strstr($error, "The file you are attempting to upload is larger than the permitted size."):
                    $size = $maxSize ?? 500;
                    $error = "Ukuran file maksimal yang boleh diunggah adalah {$size} KB.";
                    break;

                default:
                    $error = $error;
                    break;
            }

            throw new Exception($error);
        }
    }
}

if (!function_exists("convert_readable_json")) {
    function convert_readable_json($string = null)
    {
        try {
            $decode = json_decode($string);

            return (json_last_error() == JSON_ERROR_NONE) == true ? $decode : false;
        } catch (\Exception $ex) {
            return false;
        }
    }
}

// Get nama bulan
if (!function_exists("get_nama_bulan")) {
    function get_nama_bulan($bulan)
    {
        $b = array(
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        );

        if (strlen($bulan) == 1) {
            $bulan = "0" . $bulan;
        }

        return $b[$bulan];
    }
}



if (!function_exists("ConvertGroupingAlergi")) {

    function ConvertGroupingAlergi($data)
    {
        if ($data == null) return '';
        $grouped_data = [];

        foreach ($data as $item) {
            $select_val = $item->SELECT_VAL;
            $text_val = $item->TEXT_VAL;

            if (!isset($grouped_data[$select_val])) {
                $grouped_data[$select_val] = [];
            }

            $grouped_data[$select_val][] = $text_val;
        }

        // Mengonversi hasil ke dalam format teks
        $result_text = '';
        foreach ($grouped_data as $select_val => $text_vals) {
            $result_text .= $select_val . " : " . implode(", ", $text_vals) . " ; ";
        }

        return $result_text;
    }
}
if (!function_exists("TampilTanggalHariJam")) {
    function TampilTanggalHariJam($datetime, $hari_ini = false)
    {
        if (isset($datetime)) {
            return date('d/m/Y H:i', strtotime($datetime));
        } else {
            if ($hari_ini) {
                return date('d/m/Y H:i');
            } else {
                return '';
            }
        }
    }
}

if (!function_exists("encode_id")) {


    function encode_id($string)
    {
        $string = $string . " " . date("YmdHis") . random_string("alnum", 8);
        $output = false;
        /*
        * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
        */
        $ci = &get_instance();
        $secret_key     = $ci->config->item("encryption_key");
        $secret_iv      = $ci->config->item("iv");
        $encrypt_method = $ci->config->item("encryption_mechanism");

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

if (!function_exists("decode_id")) {

    function decode_id($string)
    {

        $output = false;
        /*
        * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
        */

        $ci = &get_instance();
        $secret_key     = $ci->config->item("encryption_key");
        $secret_iv      = $ci->config->item("iv");
        $encrypt_method = $ci->config->item("encryption_mechanism");

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

if (!function_exists("format_number_id")) {
    function format_number_id($number = 0, $decimal = 0)
    {
        $output = number_format($number, $decimal, ",", ".");
        return $output;
    }
}

// helper untuk membuat fungsi terbilang
if (!function_exists('penyebut')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}

if (!function_exists('terbilang')) {
    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }
}

if (!function_exists("get_user_session_value")) {
    function get_user_session_value($key)
    {
        $ci = &get_instance();

        return $ci->session->userdata("USER_SESSION")[$key] ?? '';
    }
}

if (!function_exists("is_user_has_valid_role_name_access")) {
    function is_user_has_valid_role_name_access($rolename)
    {
        $ci = &get_instance();

        if (is_array($rolename)) {
            if (!in_array($ci->session->userdata("USER_SESSION")["ROLE_NAME"], $rolename)) {
                return false;
            }
        } else {
            if ($ci->session->userdata("USER_SESSION")["ROLE_NAME"] !== $rolename) {
                return false;
            }
        }



        return true;
    }
}

if (!function_exists('getHari')) {
    function getHari($tanggal)
    {
        if (!$tanggal) return '';
        $dateObj = new DateTime($tanggal);
        $nama_hari = $dateObj->format('l');

        // Array mapping English day names to Indonesian day names
        $translations = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        // Map English day name to Indonesian day name
        $translated_hari = isset($translations[$nama_hari]) ? $translations[$nama_hari] : '';

        return $translated_hari;
    }
}

if (!function_exists('hitung_umur')) {
    function hitung_umur($tanggal_lahir)
    {
        if (!$tanggal_lahir) return $tanggal_lahir;
        $tgl = explode('/', $tanggal_lahir);
        if (count($tgl) == 3) {
            $tgl = $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
        } else {
            $tgl = $tanggal_lahir;
        }

        $birthDate = new DateTime($tgl);
        $today = new DateTime("today");
        if ($birthDate > $today) {
            exit("0 tahun 0 bulan 0 hari");
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        return $y . " tahun " . $m . " bulan " . $d . " hari";
    }
}

if (!function_exists('hitung_selisih_tgl')) {
    function hitung_selisih_tgl($tgl_awal, $tgl_akhir)
    {
        if (!$tgl_awal) return $tgl_awal;
        if (!$tgl_akhir) return $tgl_akhir;
        $tgl = explode('/', $tgl_awal);
        if (count($tgl) == 3) {
            $tgl = $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
        } else {
            $tgl = $tgl_awal;
        }

        $tgl2 = explode('/', $tgl_akhir);
        if (count($tgl2) == 3) {
            $tgl2 = $tgl2[2] . '-' . $tgl2[1] . '-' . $tgl2[0];
        } else {
            $tgl2 = $tgl_akhir;
        }

        $date1 = new DateTime($tgl);
        $date2 = new DateTime($tgl2);
        if ($date1 > $date2) {
            exit("0 tahun 0 bulan 0 hari");
        }
        $y = $date2->diff($date1)->y;
        $m = $date2->diff($date1)->m;
        $d = $date2->diff($date1)->d;
        return $y . " tahun " . $m . " bulan " . $d . " hari";
    }
}

if (!function_exists('formatharitanggal')) {
    function formatharitanggal($waktu)
    {
        $hari_array = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        $hr = date('w', strtotime($waktu));
        $hari = $hari_array[$hr];

        $tanggal = date('j', strtotime($waktu));

        $bulan_array = [
            1 => 'Januari',
            2 => 'February',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $bl = date('n', strtotime($waktu));
        $bulan = $bulan_array[$bl];
        $tahun = date('Y', strtotime($waktu));

        return "$hari, $tanggal $bulan $tahun";
    }
}

if (!function_exists('konversi_nip')) {
    function konversi_nip($nip, $batas = " ")
    {
        $nip = trim($nip, " ");
        $panjang = strlen($nip);

        if ($panjang == 18) {
            $sub[] = substr($nip, 0, 8); // tanggal lahir
            $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
            $sub[] = substr($nip, 14, 1); // jenis kelamin
            $sub[] = substr($nip, 15, 3); // nomor urut

            return $sub[0] . $batas . $sub[1] . $batas . $sub[2] . $batas . $sub[3];
        } elseif ($panjang == 15) {
            $sub[] = substr($nip, 0, 8); // tanggal lahir
            $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
            $sub[] = substr($nip, 14, 1); // jenis kelamin

            return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
        } elseif ($panjang == 9) {
            $sub = str_split($nip, 3);

            return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
        } else {
            return $nip;
        }
    }
}

if (!function_exists('create_qr_code')) {
    function create_qr_code($data)
    {
        $writer = new PngWriter();

        $qrCode = QrCode::create($data)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);

        return $result->getDataUri();
    }
}

if (!function_exists('cekValueAda')) {
    function cekValueAda($val)
    {
        if (!trim($val)) return '-';

        return ucwords(strtolower($val));
    }
}

if (!function_exists('convertToIndonesianDate')) {
    function convertToIndonesianDate($dateString)
    {

        if (!$dateString) return '';
        $date = new DateTime($dateString);
        $months = array(
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $formattedDate = $date->format('d ') . $months[$date->format('n') - 1] . $date->format(' Y');
        return $formattedDate;
    }
}


if (!function_exists('convertToIndonesianLongDate')) {
    function convertToIndonesianLongDate($dateString)
    {

        if (!$dateString) return '';
        $parts = explode('/', $dateString);
        $day = $parts[0];
        $month = $parts[1];
        $year = $parts[2];

        // Define array for month names in Indonesian
        $bulan_indonesia = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        // Convert month number to Indonesian month name
        $month_indonesia = $bulan_indonesia[$month];

        // Format the date in the desired format
        $tanggal_indonesia = $day . ' ' . $month_indonesia . ' ' . $year;

        return $tanggal_indonesia;
    }
}

if (!function_exists('convertToIndonesianDateTime')) {
    function convertToIndonesianDateTime($datetime)
    {
        if (!$datetime) return '';
        $timestamp = strtotime($datetime);
        $formattedDate = date('d F Y H:i:s', $timestamp);
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        $formattedDate = strtr($formattedDate, $months);

        return $formattedDate;
    }
}

if (!function_exists('zero_front_value')) {
    function zero_front_value($number, $count = 6)
    {
        $sumValue    = strlen($number);
        $sumZero   = $count - $sumValue;
        $zero = "";
        if ($sumZero > 0) {
            for ($i = 1; $i <= $sumZero; $i++) {
                $zero .= '0';
            }
        }

        return $zero . $number;
    }
}

if (!function_exists('nol_front_value')) {
    function nol_front_value($number, $count = 6)
    {
        $sumValue    = strlen($number);
        $sumZero   = $count - $sumValue;
        $zero = "";
        if ($sumZero > 0) {
            for ($i = 1; $i <= $sumZero; $i++) {
                $zero .= '0';
            }
        }

        return $zero . $number;
    }
}