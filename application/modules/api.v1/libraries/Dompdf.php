<?php if (!defined("BASEPATH")) {
	exit("No direct script access allowed");
}

use Dompdf\Dompdf as PDFDOM;
use Dompdf\Options;

class Dompdf
{
	public $ci;
	public $dompdf;
	public $options;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->options = new Options();
		$this->options->setChroot(FCPATH);
		$this->options->setTempDir(sys_get_temp_dir());
		$this->options->set('isRemoteEnabled', true);
    	$this->options->set('isHtml5ParserEnabled', true);
		$this->dompdf = new PDFDOM($this->options);
		
	}

	/***********************************

	 * Method : stream

	 * description : return stream pdf

	 ************************************/
	public function stream(array $data = array())
	{
		$context = stream_context_create([ 
			'ssl' => [ 
				'verify_peer' => FALSE, 
				'verify_peer_name' => FALSE,
				'allow_self_signed'=> TRUE 
			] 
		]);
		$this->dompdf->setHttpContext($context);
		$this->dompdf->loadHtml($this->ci->load->view("pdf/{$data["view"]}", ["data" => $data["content"]] ?? ["data" => []], TRUE));
		$this->dompdf->setPaper($data["paper"] ?? "A4", $data["orientation"] ?? "portrait");
		$this->dompdf->render();
		$this->dompdf->stream($data["filename"] ?? "cetak_dokumen.pdf", array("Attachment" => false));
	}
}