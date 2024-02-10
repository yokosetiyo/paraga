<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class MY_REST_Controller extends RestController
{
	protected $http_status = ['HTTP_OK' => 200, 'HTTP_CREATED' => 201, 'HTTP_NOT_MODIFIED' => 304, 'HTTP_BAD_REQUEST' => 400, 'HTTP_UNAUTHORIZED' => 401, 'HTTP_FORBIDDEN' => 403, 'HTTP_NOT_FOUND' => 404, 'METHOD_NOT_ALLOWED' => 405, 'HTTP_NOT_ACCEPTABLE' => 406, 'HTTP_INTERNAL_ERROR' => 500];

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
		ob_start();
    }
}