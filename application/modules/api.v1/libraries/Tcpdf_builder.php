<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

require_once("vendor/tecnickcom/tcpdf/tcpdf.php");

class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        // variabel
        $image_file = "assets/media/images/logo-kab-sukoharjo-resize.png";

        if ($this->setHeaderAllPage) {
            // Logo
            $this->Image($image_file, 15, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            // Set font
            $this->SetFont('times', '', 14);

            // Title
            $this->Ln(2.5);
            $this->Cell(0, 15, 'PEMERINTAH KABUPATEN SUKOHARJO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(5.5);
            $this->Cell(0, 15, 'DINAS KESEHATAN', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->SetFont('times', 'B', 14);
            $this->Ln(5.5);
            $this->Cell(0, 15, 'RSUD Ir. SOEKARNO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->SetFont('times', '', 10);
            $this->Ln(5);
            $this->Cell(0, 15, 'Jalan dr. Muwardi Nomor : 71, Kode Pos : 57514', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(3.5);
            $this->Cell(0, 15, 'Telp. ( 0271 ) 593118 / Fax  ( 0271 ) 593005', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(3.5);
            $this->Cell(0, 15, 'Website : rsud.sukoharjokab.go.id | E-mail : rsud.sukoharjokab.go.id', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(3.5);
            $this->Line(10, $this->getY(), $this->getPageWidth() - 10, $this->getY(), array('width' => 2));
            $this->SetMargins(0, 45, 0, 0);
        } else {
            if ($this->page == 1) {
                // Logo
                $this->Image($image_file, 15, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                // Set font
                $this->SetFont('times', '', 14);

                // Title
                $this->Ln(2.5);
                $this->Cell(0, 15, 'PEMERINTAH KABUPATEN SUKOHARJO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(5.5);
                $this->Cell(0, 15, 'DINAS KESEHATAN', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->SetFont('times', 'B', 14);
                $this->Ln(5.5);
                $this->Cell(0, 15, 'RSUD Ir. SOEKARNO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->SetFont('times', '', 10);
                $this->Ln(5);
                $this->Cell(0, 15, 'Jalan dr. Muwardi Nomor : 71, Kode Pos : 57514', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(3.5);
                $this->Cell(0, 15, 'Telp. ( 0271 ) 593118 / Fax  ( 0271 ) 593005', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(3.5);
                $this->Cell(0, 15, 'Website : rsud.sukoharjokab.go.id | E-mail : rsud.sukoharjokab.go.id', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(3.5);
                $this->Line(10, $this->getY(), $this->getPageWidth() - 10, $this->getY(), array('width' => 2));
                $this->SetMargins(0, 45, 0, 0);
            } else {
                $this->SetMargins(10, 10, 10, 10);
            }
        }
    }

    // Page footer
    public function Footer()
    {
        if (!empty($this->setFooterText)) {
            $this->SetFont('times', '', 8);
            $this->Cell(0, 20, $this->setFooterText, 0, false, 'L', 0, '', 0, false, 'B', 'M');
        }
    }
}

class Tcpdf_builder
{
    public $ci;
    public $tcpdf;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->tcpdf = new MYPDF();
        $this->tcpdf->SetCreator(PDF_CREATOR);
        $this->tcpdf->SetAuthor('');
        $this->tcpdf->SetTitle("");
        $this->tcpdf->SetSubject("");
        $this->tcpdf->SetKeywords("");
    }

    /***********************************
        - Function : stream output
        - Desc : return stream pdf
        - Created at : 02-02-2023
        - Created by : Bagus Dwi
     ************************************/
    public function stream(array $data = array())
    {
        $orientationPage = "L";
        if (!empty($data["orientation"])) {
            $orientationPage = $data["orientation"];
        }

        $header = false;
        $this->tcpdf->setHeaderAllPage = false;
        if (!empty($data["content"]["HEADER"]["STATUS"])) {
            $header = $data["content"]["HEADER"]["STATUS"];

            if (!empty($data["content"]["HEADER"]["ALLPAGE"])) {
                $this->tcpdf->setHeaderAllPage = $data["content"]["HEADER"]["ALLPAGE"];
            }
        }

        $footer = false;
        $this->tcpdf->setFooterText = "";
        if (!empty($data["content"]["FOOTER"]["STATUS"])) {
            $footer = $data["content"]["FOOTER"]["STATUS"];
            $footerText = "";

            if (!empty($data["content"]["FOOTER"]["TITLE"])) {
                $footerText = $data["content"]["FOOTER"]["TITLE"];
            }

            $this->tcpdf->setFooterText = $footerText;
        }

        //setting page
        $this->tcpdf->SetMargins(10, 10, 10, 10);
        $this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->tcpdf->setPrintHeader($header);
        $this->tcpdf->setPrintFooter($footer);
        $this->tcpdf->SetAutoPageBreak(TRUE, 10);
        $this->tcpdf->AddPage($orientationPage, 'mm', 'A4');

        //set cell padding form wo inspection detail
        $this->tcpdf->setCellPadding(0);
        $this->tcpdf->writeHTML($this->ci->load->view("pdf/{$data["view"]}", ["data" => $data["content"]] ?? ["data" => []], true), true, false, true, false, '');
        $this->tcpdf->Output($data["filename"] ?? "cetak_dokumen.pdf", 'I');
    }
}