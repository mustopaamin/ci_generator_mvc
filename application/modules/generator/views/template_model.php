<?php
$html = "<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class " . $nm_class_m . " extends CI_Model {

	function getDataId(\$id)
	{
		\$sql = \$this->db->get_where('$tabel',array('$where_select'=> \$id))->row_array();
		return \$sql;
	}

	function saveData()
	{
		\$data = array(
";

foreach($fields_form as $ff):
$html .= "\t\t\t\t'".$ff['nama_form']."' => \$this->input->post('".$ff['nama_form']."'),\n";
endforeach;

$html .= "\t\t);
		\$sql = \$this->db->insert('$tabel',\$data);
		return \$sql;
	}

	function updateData(\$id)
	{
		\$data = array(
";

foreach($fields_form as $ff):
$html .= "\t\t\t\t'".$ff['nama_form']."' => \$this->input->post('".$ff['nama_form']."'),\n";
endforeach;

$html .= "\t\t);

		\$this->db->where('$where_select',\$id);
		\$sql = \$this->db->update('$tabel',\$data);
		return \$sql;		
	}

	function deleteData(\$id)
	{
		\$this->db->where('$where_select',\$id);
		\$sql = \$this->db->delete('$tabel');
		return \$sql;		
	}
	
	function comboData()
	{
		\$sql = \$this->db->get('$tabel');
		if(\$sql)
		{
			foreach(\$sql->result() as \$r):
				\$list[\$r->$where_select] = \$r->$where_select;
			endforeach;
		}
		return \$list;
	}
}

/* End of file $nm_model.php */
/* Location: ./application/modules/$nm_controller/models/$nm_model.php */";

echo $html;
?>
	

	


