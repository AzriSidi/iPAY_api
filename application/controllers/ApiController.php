<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';
use api\libraries\REST_Controller;

class ApiController extends REST_Controller {

	public function __construct(){
		parent::__construct();
		// Your own constructor code
		$this->load->model('ApiModel');
	}

	public function index_get(){
		echo "this is controller";
	}

    public function payDetail_get(){
		$input = array(array(
			'fpxTxnId' => 'string',
			'sellerOrderNo' => 'string',
			),array(
				'fpxTxnId' => 'string',
				'sellerOrderNo' => 'string'
			));
		$this->response($input);		
	}	

    function payDetail_post(){
        $items = json_decode(json_encode($this->post()));
        foreach($items as $item){			
			$input['fpxTxnId'] = $item->fpxTxnId;
			$input['sellerOrderNo'] = $item->sellerOrderNo;
			$data[] = $this->ApiModel->payDetail($input);
		}
		$data = array_filter((array) $data);
		$output = array("result"=>$data);
		$this->response($output);
    }
}
