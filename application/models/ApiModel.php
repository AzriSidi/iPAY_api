<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiModel extends CI_Model{
	
	public function payDetail($input){
		$result = false;
		$column = "trxid,amaun,status";

		$this->db->select("$column");
		$this->db->where('fpx_sellerOrderNo', $input['sellerOrderNo']);
		$this->db->where('fpx_fpxTxnId', $input['fpxTxnId']);
		$this->db->where('status', "SUCCESSFUL");
		$query = $this->db->get('payment');
		$row = $query->row();
		
		if($query->num_rows() > 0){
			$result = $this->trxDetail($query->result_array());
		}else{
			$result = array(
				array(
					"fpxTxnId"=>$input['fpxTxnId'],		
					"sellerOrderNo"=>$input['sellerOrderNo'],
					"error"=>"Data not exist"
				));
		}

		return $result;
	}

	public function trxDetail($data){
		$mgs = "";

		foreach($data as $pay){			
			$this->db->select('trx_id');
			$this->db->select_sum('amaun');
			$this->db->where('trx_id', $pay['trxid']);

			$total = $this->db->get('trxid');
			$trx = $total->row();
			
			if($pay['amaun'] == $trx->amaun){
				$this->db->select('trx_id,no_akaun,amaun');
				$this->db->from('trxid');
				$this->db->where('trx_id', $pay['trxid']);	
				$query = $this->db->get();

				if($query->num_rows() > 0){
					$mgs = $query->result();
				}else{
					$mgs = array(
						array(
							"trxid"=>$pay['trxid'],
							"error"=>"Data not match"							
						));
				}
			}else{
				$mgs = array(
					array(
						"trxid"=>$pay['trxid'],
						"error"=>"Amount not match"						
					));
			}

			return $mgs;
		}
	}
}
