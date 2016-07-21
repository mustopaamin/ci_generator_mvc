<?php
$html = "<!-- load css dan js -->
<link rel=\"stylesheet\" href=\"<?php echo base_url('asset/plugins/datatables/dataTables.bootstrap.css');?>\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo base_url('asset/plugins/datatables/jquery.dataTables.min.js');?>\"></script>
<script src=\"<?php echo base_url('asset/plugins/datatables/dataTables.bootstrap.min.js');?>\"></script>
<script src=\"<?php echo base_url('asset/plugins/datatables/fnPagingInfo.js');?>\"></script>
<script src=\"<?php echo base_url('asset/plugins/datatables/fnReloadAjax.js');?>\"></script>";
if(in_array('select',$type_form, true))
{
$html .="
<link rel=\"stylesheet\" href=\"<?php echo base_url('asset/plugins/select2/select2.min.css');?>\" rel=\"stylesheet\" type=\"text/css\"/>
<script src=\"<?php echo base_url('asset/plugins/select2/select2.min.js');?>\"></script>";
}
$html .="\n<!-- end load css dan js -->";

$html .="\n\n<section class=\"content-header\">
	<h1>
		Data $nm_global
		<small>it all $nm_global</small>
	</h1>
	<ol class=\"breadcrumb\">
            <li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\"><?php echo \$this->uri->segment(1);?></a></li>
            <li class=\"active\">Start</li>
          </ol>
</section>";

$html .="\n\n<section class=\"content\">
	<div class=\"box box-info\"> <!-- start .box -->
		<div class=\"box-header\"> <!-- start .box-header -->
			<a class=\"btn btn-sm btn-primary\" id=\"add".$nm_global."\"><i class=\"fa fa-plus\"></i> Tambah</a>&nbsp;&nbsp;
			<a class=\"btn btn-sm btn-warning\" id=\"edit".$nm_global."\"><i class=\"fa fa-pencil\"></i> Ubah</a>&nbsp;&nbsp;
			<a class=\"btn btn-sm btn-danger\" id=\"del".$nm_global."\"><i class=\"fa fa-trash-o\"></i> Hapus</a>
		</div> <!-- end .box-header -->
		
		<div class=\"box-body\"> <!-- start .box-body -->
			<table id=\"table".$nm_global."\" class=\"table datares\">
				<thead>
					<tr>";

foreach($thead as $thead):				
$html .="				
						<th>".$thead."</th>";
endforeach;

$html .="\n				</tr>
				</thead>
			</table>
			<br/>
			<form name=\"frm".$nm_global."\" id=\"frm".$nm_global."\" method=\"post\" class=\"form-horizontal\">";

foreach($fields_form as $k => $v):
if($type_form[$k] == 'hidden')
{
$html .="
\t\t\t\t<input type=\"hidden\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" value=\"\" >";
}
if($type_form[$k] == 'text')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><input type=\"text\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" class=\"form-control\" placeholder=\"".$label_form[$k]." ...\" value=\"\" ></div>
				</div>";
}
if($type_form[$k] == 'password')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><input type=\"password\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" class=\"form-control\" placeholder=\"".$label_form[$k]." ...\" value=\"\" ></div>
				</div>";
}
if($type_form[$k] == 'datepicker')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><input type=\"text\" name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" class=\"form-control\" placeholder=\"".$label_form[$k]." ...\" value=\"\" ></div>
				</div>";
}
if($type_form[$k] == 'select')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\">
					<?php
						\$dataTes = array(1=>'Satu',2=>'Dua',3=>'Tiga',4=>'Empat',);
						echo form_dropdown('".$v['nama_form']."',\$dataTes,2,'id=\"".$v['nama_form']."\" class=\"form-control select\"');
					?>
					</div>
				</div>";
}
if($type_form[$k] == 'textarea')
{
$html .="
				<div class=\"form-group\">
					<label class=\"col-md-2\" style=\"padding-top:7px;\">".$label_form[$k]."</label>
\t\t\t\t\t<div class=\"col-md-6\"><textarea name=\"".$v['nama_form']."\" id=\"".$v['nama_form']."\" placeholder=\"".$label_form[$k]."\" rows=\"3\" class=\"form-control\"></textarea></div>
				</div>";
}
endforeach;
				
$html .="	
				<div class=\"col-md-8\" align=\"center\" id=\"fnButton\"></div>
			</form>

		</div> <!-- end .box-body -->
		<div class=\"box-footer\" align=\"right\"> <!-- start box-footer -->
		  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div> <!-- end .box-footer-->
	</div> <!-- end .box -->
</section><!-- /.content -->

<script>
var oTable;
$(document).ready(function(){
	$('#frm".$nm_global."').hide();
	oTable = $('#table".$nm_global."').dataTable({
		\"processing\": true,
		\"serverSide\": true,
		\"sAjaxSource\": \"<?php echo site_url();?>/".$nm_controller."/fnDataJson\",
		\"sServerMethod\": \"POST\",
		\"aoColumns\": [ 
			$aoColumnsnull
		],
		\"fnRowCallback\": function (nRow, aData, iDisplayIndex, DisplayIndexFull) {
		  var page		= this.fnPagingInfo().iPage;
		  var lengt		= this.fnPagingInfo().iLength;
		  var index 	= (page * lengt + (iDisplayIndex +1));
		  $('td:eq(0)', nRow).html(index+'<input type=\"hidden\" id=\"id".$nm_global."'+iDisplayIndex+'\" value=\"'+aData[0]+'\" >');
/*
		    $(nRow).click( function () {
		        var iPos = oTable.fnGetPosition( nRow );
		        var aData = oTable.fnGetData( iPos );
		        var iId = aData[0];
		        if ( jQuery.inArray(iId, selected) == -1 )
		        {
		            selected[selected.length++] = iId;
		        }
		        else
		        {
		            selected = jQuery.grep(selected, function(value) {
		                return value != iId;
		                            } );
		        }
		 
		        $(nRow).toggleClass('selected');
		    });
		    return nRow;
*/
		}
	});
	$(\".dataTables_filter input\").attr(\"placeholder\",\"Cari Kata disini ...\");

	$('#table".$nm_global." tbody').on( 'click', 'tr', function () {
		//select one row
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            oTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
		// select multi
//		$(this).toggleClass('selected');
    } );

	$('#add".$nm_global."').click(function()	{
		$('#table".$nm_global."_wrapper').hide();
		$('.box-header').hide();
		$('#frm".$nm_global."').trigger(\"reset\");
		$('#frm".$nm_global."').show();
		$('#fnButton').html('<input type=\"submit\" name=\"submit\" value=\"Save\" id=\"btnSave\" class=\"btn btn-success\" />&nbsp;&nbsp;&nbsp;<a onClick=\"fnBack()\" class=\"btn btn-danger\"> Cancel</a>');
	});

	$('#edit".$nm_global."').click(function()	{
		var row = $('#table".$nm_global." tr.selected').length;

		if(row > 1)
		{
			alert('Pilih data dulu !!!');
		}
		else
		{
			var anSelected = fnGetSelected( oTable );
			var iRow = oTable.fnGetPosition( anSelected[0] );
			var aData = oTable.fnGetData(iRow);
			var idRow = $('#id".$nm_global."'+iRow).val();
			var x = aData[1];
			$('#table".$nm_global."_wrapper').hide();
			$('.box-header').hide();
			$('#frm".$nm_global."').show();

			var urlUpdate='<?php echo site_url();?>/".$nm_controller."/fnDataId/'+idRow;
			$.getJSON( urlUpdate, function(data){
$inputName\t\t\t});
			$('#fnButton').html('<input type=\"submit\" name=\"submit\" value=\"Ubah\" id=\"btnUpdate\" class=\"btn btn-warning\" />&nbsp;&nbsp;&nbsp;<a onClick=\"fnBack()\" class=\"btn btn-danger\"> Cancel</a>');
		}
	});

	$('#del".$nm_global."').click(function()	{
		var row = $('#table".$nm_global." tr.selected').length;

		if(row > 1)
		{
			alert('Pilih data dulu !!!');
		}
		else
		{
			var anSelected = fnGetSelected( oTable );
			var iRow = oTable.fnGetPosition( anSelected[0] );
			var aData = oTable.fnGetData(iRow);
			var idRow = $('#id".$nm_global."'+iRow).val();
			var urlUpdate='<?php echo site_url();?>/".$nm_controller."/fnDelete/'
			$.post(urlUpdate,{id : idRow},function(html){
				if(html== 'TRUE') { oTable.fnReloadAjax();} 
				else { alert(html); } 
			});
		}
	});";

if(in_array('select',$type_form, true))
{
$html .="\n
	var \$select = $('.select'); 
    \$select.select2();
";
}

if(in_array('datepicker',$type_form, true))
{
foreach($fields_form as $k => $v):
if($type_form[$k] == 'datepicker')
{
$html .="
	$('#".$v['nama_form']."').datepicker({
		dateFormat: \"yy-mm-dd\",
		regional: \"id\"
	});
";
}
endforeach;
}
$html .="
});

// Menyimpan data
$('#frm".$nm_global."').submit(function(e){
	e.preventDefault();
	var rec = $('#frm".$nm_global."').serialize();
	if($('input[name=\"submit\"]').val()=='Save'){
		// Insert
		$.ajax({
			'url': \"<?php echo site_url();?>/".$nm_controller."/fnSave/\",
			'type': \"POST\",
			'data': rec,
			'dataType': 'json',
			'success': function(html){
				if(html.msg==true) { $('#frm".$nm_global."').hide(); $('.box-header').show(); $('#table".$nm_global."_wrapper').show(); oTable.fnReloadAjax();} 
			},
			'error': function(html){ 
				if(html.status==500){ alert('Terjadi duplicate AccountName atau Email.'); }
				console.log(html); 
			}
		});	
	} else {
		// Update
		$.ajax({
			'url': \"<?php echo site_url();?>/".$nm_controller."/fnUpdate/\"+$('#".$where_select."').val(),
			'type': \"POST\",
			'data': rec,
			'dataType': 'json',
			'success': function(html){
				if(html.msg==true) { $('#frm".$nm_global."').hide(); $('.box-header').show(); $('#table".$nm_global."_wrapper').show(); oTable.fnReloadAjax(); } 
			},
			'error': function(html){ 
				if(html.status==500){ alert('Terjadi duplicate AccountName atau Email.'); }
				console.log(html); 
			}
		});	
	}
	
});

function fnBack()
{
	$('#frm".$nm_global."').trigger(\"reset\");
	$('#frm".$nm_global."').hide();	
	$('#table".$nm_global."_wrapper').show();
	$('.box-header').show();
	$('#table".$nm_global." tr').removeClass('selected');
}

function fnGetSelected( oTableLocal )
{
	return oTableLocal.$('tr.selected');
}
</script>
";
echo $html;
?>



