<?php

	function menu() {
		$this->db->join('productdetail pd', 'pd.productid = product.id');
		$data = $this->db->get('product');
		if ($data->num_rows() > 0){
			foreach ($data->result() as $row) {
				$product['product.id'] = $row->product.id;
				$product['product.deskripsi'] = $row->product.deskripsi;
				$product['product.harga'] = $row->product.harga;
				$product['pd.namagambar'] = $row->pd.namagambar;
				$product['pd.urlgambar'] = $base_url_photo.$row->pd.urlgambar;
			}		
		}
		
		if ($data != NULL) {
			$response = array('error' => false, 'msg' => 'Sukses.', 'data' => $data);
		}
		else{
			$response = array('error' => true, 'msg' => 'Data Product kosong.');
		}
		
		echo json_encode($response);
	}
	
	function pesanan() {
		$this->MSessionLogin->session_login();
	    $customer_id = $this->session->userdata('id');
		$product_no = $this->input->post('productno');
		$telephone = $this->input->post('telephone');
		$alamat = $this->input->post('alamat');
		$note = $this->input->post('notes');
		$totaldiskon = $this->input->post('diskon');
		
		
		$this->db->select('orderno');
		$this->db->where('left(orderno,11)', $product_no);
		$order_no = $this->db->get('order');
		
		$this->db->select('harga');
		$harga = $this->db->get('product');
		
		$i = 1;
		
		if($order_no->num_rows() > 0)
		{
			foreach($order_no->num_rows() as $key)
			{
				$i++;
			}
			$orderno = $product_no . date("dmy") .$i;
		}
		else
		{
			$orderno = $product_no . date("dmy") .$i;
		}
		
		$query = $this->db->insert('order', array(
		'customerid' => $customer_id,
		'orderno' => $orderno,
		'telephone' => $telephone,
		'alamat' => $alamat,
		'notes' => $note,
		'totalhargaorder' => $harga,
		'totaldiskonorder' => $totaldiskon,
		'orderstatus' => 'DIPESAN',
		'createdby' => $customer_id
		));
		
		if ($query) {
			echo "Sukses";
		}else{
			echo $query->error();
		}
	}
	
	function konfirmasiorder() {
		$adminid = $this->input->post('adminid');
		$orderno = $this->input->post('orderno');
		$kuririd = $this->input->post('kuririd');
		
		$this->db->select('orderstatus');
		$this->db->where('orderno',$orderno);
		$status_order = $this->db->get('order');
		
		
		$this->db->select('shipmentno');
		$this->db->where('left(shipmentno,11)', $product_no);
		$shipment_no = $this->db->get('shipment');
		
		$i = 1;
		
		if($status_order == 'DIPESAN')
		{
			$query = $this->db->update('order',array(
				'orderstatus' => 'DIPROSES',
				'lastmodifiedtime' => date("dmy"),
				'lastmodifiedby' => $adminid
			));
			
			if ($query) {
				echo "Sukses";
			}else{
				echo $query->error();
			}
		}
		elseif($status_order == 'DIPROSES')
		{
			$query = $this->db->update('order',array(
				'orderstatus' => 'DIKIRIM',
				'lastmodifiedtime' => date("dmy"),
				'lastmodifiedby' => $adminid
			));
			
			$this->db->select('id');
			$this->db->where('orderno',$orderno);
			$order_id = $this->db->get('order');
			
			if($shipment_no->num_rows() > 0)
			{
				foreach($shipment_no->num_rows() as $key)
				{
					$i++;
				}
				$shipment_no = $product_no . date("dmy") .$i;
			}
			else
			{
				$shipment_no = $product_no . date("dmy") .$i;
			}
			
			$query = $this->db->insert('shipment', array(
			'orderid' => $order_id,
			'kuririd' => $kuririd,
			'telephone' => $telephone,
			'alamat' => $alamat,
			'notes' => $note,
			'totalhargaorder' => $harga,
			'totaldiskonorder' => $totaldiskon,
			'orderstatus' => 'DIPESAN',
			'createdby' => $customer_id
			));
			if ($query) {
				echo "Sukses";
			}else{
				echo $query->error();
			}
		}
		elseif($status_order == 'DIKIRIM')
		{
			$query = $this->db->update('order',array(
				'orderstatus' => 'DITERIMA',
				'lastmodifiedtime' => date("dmy"),
				'lastmodifiedby' => $kuririd
			));
			
			if ($query) {
				echo "Sukses";
			}else{
				echo $query->error();
			}
		}
	}
?>
