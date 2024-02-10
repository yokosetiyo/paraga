<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] 	= array();

$autoload['libraries'] 	= array('database', 'form_validation', 'session');
// $autoload['libraries'] 	= array('database', 'form_validation', 'session', 'dompdf', 'tcpdf_builder', 'excel');

$autoload['helper'] 	= array();

$autoload['language'] 	= array('api');

$autoload['config'] 	= array('rest');

$autoload['model'] 		= array('common_model');