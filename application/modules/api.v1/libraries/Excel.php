<?php if (!defined("BASEPATH")) {
	exit("No direct script access allowed");
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
	public $ci;
	public $excel;
	public $writer;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->excel = new Spreadsheet();
		$this->writer = new Xlsx($this->excel);
		
	}

	/***********************************

	 * Method : init
	 * Creator : Dimas Hermawan (01-03-2023)
	 * description : return excel instance 

	 ************************************/
	public function init()
	{
		return ['excel' => $this->excel, 'writer' => $this->writer];
	}

	/***********************************

	 * Method : create
	 * Creator : Dimas Hermawan (01-03-2023)
	 * description : return excel report 

	 ************************************/
	public function create($payload = array(), $filename = 'file')
	{
		try {
			if (!is_array($payload)) throw new Exception("Parameter data harus array");

			$column 	= $payload["column"] ?? [];
			$data 		= $payload["data"] ?? [];

			if (empty($column)) throw new Exception("array data harus mengandung object column");
			if (empty($data)) throw new Exception("array data harus mengandung object data");

			$sheet 	= $this->excel->getActiveSheet();

			$letter = "A";
			foreach ($column as $row) {
				$cell = $letter."1";
				$sheet->setCellValue($cell, $row->name);
				$letter++;
			}

			$row_number = "2";
			foreach ($data as $row) {
				$letter = "A";

				foreach ($column as $rowcol) {
					$cell 	= $letter.$row_number;
					$col 	= $row[$rowcol->name];

					if (!is_array($col)) {
						$sheet->setCellValue($cell, $col);
					}else {
						$sheet->setCellValue($cell, json_encode($col));
					}

					$sheet->getStyle($cell)->getAlignment()->setWrapText(true);

					$letter++;
				}

				$row_number++;
			}

			foreach ($sheet->getColumnIterator() as $columns) {
				$sheet->getColumnDimension($columns->getColumnIndex())->setAutoSize(true);
			}

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment; filename={$filename}.xlsx");
			header('Cache-Control: max-age=0');

			$this->writer->save('php://output');
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage());
		}
	}
}