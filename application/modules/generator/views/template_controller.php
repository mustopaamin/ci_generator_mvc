<?php
$html = "<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class " . $nm_class_c . " extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        \$this->load->model('$nm_model');
        \$this->load->library('form_validation');
    }";

$html .="\n\n\tpublic function index()
    {
        \$data['title']		= 'Module $nm_global';
        \$data['content']	= 'display';
        \$this->load->view('layout/main', \$data);
    }";

$html .="\n\n\tpublic function fnDataJson()
	{
		\$this->load->library('datatables');
		\$this->datatables->select('$select_field');
		\$this->datatables->from('$tabel');
		
		echo \$this->datatables->generate();		
	}";        

$html .="\n\n\tpublic function fnDataId()
	{
		\$id 	= \$this->uri->segment(3);
		\$data	= \$this->".$nm_model."->getDataId(\$id);
		echo json_encode(\$data);		
	}";        

$html .="\n\n\tpublic function fnSave()
	{
		if(\$this->".$nm_model."->saveData())
		{
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}";

$html .="\n\n\tpublic function fnUpdate()
	{
		\$id = \$this->uri->segment(3);
		if(\$this->".$nm_model."->updateData(\$id))
		{
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}";

$html .="\n\n\tpublic function fnDelete()
	{
		\$id = \$this->input->post('id');
		if(\$this->".$nm_model."->deleteData(\$id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';;
		}		
	}";
   

$html .= "\n\n}\n\n/* End of file $nm_controller.php */
/* Location: ./application/modules/$nm_controller/controllers/$nm_controller.php */";

echo $html;
?> 
