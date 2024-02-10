<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Guzzle
{
	/***********************************
    * Method : post
    
    * @params : $url, $data
    
    * description : guzzle self post
    
    ************************************/
    
    public function self_post($url = null, $data = array())
    {
        $ci = & get_instance();
        try {       
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                $ci->config->item('api_url').$url,
                array(
                    'headers' => [],
                    'form_params' => $data,
                )
            );

			try {
				return json_decode($response->getBody()->getContents());
			} catch (\Exception $e) {
				throw new Exception("Response API tidak dikenali");
			}

        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $response_body_as_string = $response->getBody()->getContents();
            throw new Exception($response_body_as_string);
        }
    }
}