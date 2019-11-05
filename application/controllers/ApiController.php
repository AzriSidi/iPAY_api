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
		$input = array(array(
			'fpxTxnId' => '1909271020250902',
			'sellerOrderNo' => '12019092700000100009000',
			),array(
				'fpxTxnId' => '1910211504400540',
				'sellerOrderNo' => '12019102100000100000145'
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
