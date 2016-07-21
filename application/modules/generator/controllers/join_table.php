<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Join_table extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('parser');
		$this->load->helper('file');
		$this->load->helper('harviacode');
		$this->load->model('mo_generator');
	}

	function index()
	{
		$data['title']		= 'Generator CMV to CodeIgniter';
		$data['content']	= 'form_generator_join';
		$data['tabel']		= $this->mo_generator->list_tabel();
		$this->load->view('layout/main',$data);		
	}

	function reference_tabel()
	{
		$tabel	= $this->input->post('tabel');
		$sql 	= $this->db->query("SELECT TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$tabel' ");
		if($sql->num_rows>0)
		{
			$ra = $sql->result();
			$list = array(""=>"Silahkan Pilih !!!");
			foreach($ra as $rw):
				$list[$rw->TABLE_NAME] = $rw->TABLE_NAME;
			endforeach;
			echo form_dropdown('detailtabel',$list,false,"id='detailtabel' class='form-control chosen'");
		}
		else
		{
			$detail = array(""=>"No Reference !!!");
			echo form_dropdown('detailtabel',$detail,false,"id='detailtabel' class='form-control chosen'");
		}
	}

	function field_tabel_join()
	{
		$tabel = $this->input->post('tabel');
		$dtabel = $this->input->post('detailtabel');
//		$fields = $this->db->list_fields($tabel);
		$fields = $this->db->field_data($tabel);
		$fields1 = $this->db->field_data($dtabel);
		
		$reference = '';
		echo "<tr style='background-color:#6DDF6D'><td colspan='3'>Tabel : ".$tabel."</td></tr>"; 
		foreach ($fields as $field)
		{
			if($field->primary_key == 1)
			{
				$ro = "disabled";
				$int = "<input type='hidden' name='intabel[]' checked value='".$field->name."'>";
				$inf = "<input type='hidden' name='inform[]' checked value='".$field->name."'>";
				$reference .= $field->name;
			}
			else
			{
				$ro = "";
				$int = "";
				$inf = "";
			}
			
			echo "<tr>";
			echo "<td>".$field->name."</td>";
			echo "<td><input type='checkbox' name='intabel[]' checked value='".$field->name."' ".$ro.">".$int."</td>";
			echo "<td><input type='checkbox' name='inform[]' checked value='".$field->name."' ".$ro.">".$inf."</td>";
			echo "</tr>";
		} 		

		echo "<tr style='background-color:#6DB6DF'><td colspan='3'>Tabel : ".$dtabel."</td></tr>"; 
		foreach ($fields1 as $field)
		{
			if($field->primary_key == 1)
			{
				$ro = "disabled";
				$int = "<input type='hidden' name='intabel1[]' checked value='".$field->name."'>";
				$inf = "<input type='hidden' name='inform1[]' checked value='".$field->name."'>";
			}
			else
			{
				$ro = "";
				$int = "";
				$inf = "";
			}
			
			if($field->name != $reference)
			{
				echo "<tr>";
				echo "<td>".$field->name."</td>";
				echo "<td><input type='checkbox' name='intabel[]' checked value='".$field->name."' ".$ro.">".$int."</td>";
				echo "<td><input type='checkbox' name='inform[]' checked value='".$field->name."' ".$ro.">".$inf."</td>";
				echo "</tr>";
			}
		} 		
	}

	function fnGenerateJoin()
	{
		$data['php_open']	= '<?php';
		$data['php_close']	= '?>';
		$data['base_url']	= '<?php echo base_url();?>';
		$data['site_url']	= '<?php echo site_url();?>';
		$data['tabel']		= $this->input->post('tabel');
		$data['tabel1']		= $this->input->post('detailtabel');
		$module				= 'md_'.$this->input->post('name_md');
		$nama_model			= 'mo_'.$this->input->post('name_md');
		$fieldtable			= array();
		$fieldform			= array();
		$intable			= $this->input->post('intabel');
		$inform				= $this->input->post('inform');
		$intable1			= $this->input->post('intabel1');
		$inform1			= $this->input->post('inform1');
		$select				= '';
		$aoColumns			= '';
		$inputName			= '';
		
		foreach($intable as $intable):
			$fieldtable[] 	= array(	'nama_field' => $intable	);
			$select			.= 'a.'.$intable.',';
			$aoColumns		.= "{'sName' : 'a.".$intable."'},";
		endforeach;

		foreach($intable1 as $intable1):
			$fieldtable1[] 	= array(	'nama_field' => $intable1	);
			$select			.= 'b.'.$intable1.',';
			$aoColumns		.= "{'sName' : 'b.".$intable1."'},";
		endforeach;
		
		foreach($inform as $inform):
			$fieldform[] = array(	'nama_form' => $inform	);
			$inputName		.= "$('input[name=\"".$inform."\"]').val(data[\"".$inform."\"]);";
		endforeach;

		foreach($inform1 as $inform1):
			$fieldform1[] = array(	'nama_form' => $inform1	);
			$inputName		.= "$('input[name=\"".$inform1."\"]').val(data[\"".$inform1."\"]);";
		endforeach;

		// Column Reference
		$query = $this->db->query("SELECT COLUMN_NAME,REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '".$data['tabel']."' and TABLE_NAME='".$data['tabel1']."'")->row();
		$colReA	= $query->REFERENCED_COLUMN_NAME;
		$colReB	= $query->COLUMN_NAME;
		
		$fields = $this->db->field_data($this->input->post('tabel'));
//		$data_primary = array();		
		foreach ($fields as $field)
		{
			if ($field->primary_key == '1') {
//				$data_primary[] = array('name_primary' => $field->name);
				$data_primary 	= $field->name;
			}		 
		}
		
		$data['nm_controller']	= $module;
		$data['select_field']	= trim($select,',');
		$data['where_select']	= $data_primary;
		$data['aoColumns']		= trim($aoColumns,',');
		$data['inputName']		= $inputName;
		$data['nm_model']		= $nama_model;
		$data['nm_class_c']		= ucfirst($module);
		$data['nm_class_m']		= ucfirst($nama_model);
		$data['nm_global']		= ucfirst($this->input->post('name_md'));
		
		$data['fields_tabel']	= $fieldtable;
		$data['fields_form']	= $fieldform;

		$fModule = FCPATH .APPPATH .'modules/'.$module;
		if(!is_dir($fModule))
		{
			mkdir($fModule,'0777');
			chmod($fModule,0777);

			// Pembuatan Controller
			$fController = $fModule .'/controllers';
			//$source_controller_template = $this->parser->parse('template_controller', $data, TRUE);
			$source_controller_template = $this->load->view('template_controller', $data, TRUE);
			mkdir($fController,'0777');
			chmod($fController,0777);
	        if (write_file($fController.'/'.$module.'.php', $source_controller_template)) {
	            $sukses[] = 'Folder dan File Controller sukses dibuat ;)';
	            chmod($fController.'/'.$module.'.php',0777);
	        }
			
			// Pembuatan Model
			$fModel = $fModule .'/models';
			$source_model_template = $this->load->view('template_model', $data, TRUE);
			mkdir($fModel,'0777');
			chmod($fModel,0777);
	        if (write_file($fModel.'/'.$nama_model.'.php', $source_model_template)) {
	            $sukses[] = 'Folder dan File Model sukses dibuat ;)';
	            chmod($fModel.'/'.$nama_model.'.php',0777);
	        }
	
			// Pembuatan Views
			$fView = $fModule .'/views';
			$source_view_template = $this->parser->parse('template_view', $data, TRUE);
			mkdir($fView,'0777');
			chmod($fView,0777);
	        if (write_file($fView.'/display.php', $source_view_template)) {
	            $sukses[] = 'Folder dan File View sukses dibuat ;)';
	            chmod($fView.'/display.php',0777);
	        }

	        $sukses[] = '<a href="'.site_url().'/'.$module.'" target="_blank"> Lihat</a>';
	        $this->session->set_userdata('SMSG', $sukses);
		}
		else
		{
			$this->session->set_userdata('EMSG', 'Folder dan File View sudah dibuat :(');
		}

		redirect('generator/join_table');
	}			
}
