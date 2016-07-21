<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mo_generator extends CI_Model {

	function list_tabel()
	{
		$tables = $this->db->list_tables();
		
		$list[""] = "-- Pilih Tabel --";
		foreach ($tables as $table)
		{
		   $list[$table] = $table;
		}
		
		return $list;
	}

	public function blank()
	{
		$data['title']		= 'AdminLTE 2 | Blank Page';
		$data['content']	= 'layout/blank';
		$this->load->view('layout/main',$data);
	}
}

/* End of file mo_generate.php */
/* Location: ./application/controllers/mo_generate.php */
