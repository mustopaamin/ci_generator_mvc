<link rel="stylesheet" href="<?php echo base_url();?>/asset/plugins/select2/select2.min.css">
<script src="<?php echo base_url();?>/asset/plugins/select2/select2.min.js"></script>
<script src="<?php echo base_url('asset/plugins/form/jquery.validate.js');?>"></script>
<style>
table thead > tr > th { text-align:center;}
.tdCk { text-align:center;}
</style>
<section class="content-header">
  <h1>
	<?php echo $title;?>
	<small>it all starts here</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="#">Welcome</a></li>
	<li class="active">Start</li>
  </ol>
</section>

<section class="content">
<?php
if($this->session->userdata('SMSG'))
{
	echo '<div class="alert alert-success"><center>';
	$data_error = $this->session->userdata('SMSG');
	for($i=0;$i< count($data_error);$i++)
	{
		echo $data_error[$i].br();
	}	
	echo '</center></div>';
	$this->session->unset_userdata('SMSG');
}
if($this->session->userdata('EMSG'))
{
	echo '<div class="alert alert-danger"><center>'.$this->session->userdata('EMSG').'</center></div>';
	$this->session->unset_userdata('EMSG');
}
?>
  <!-- Default box -->
  <div class="box box-info">
	<div class="box-header with-border">
	  <h3 class="box-title">Use Database : <?php echo $this->db->database;?></h3>
	</div>
	<form id="fgenerate" action="<?php echo site_url();?>/generator/fnGenerate" method="post">
	<div class="box-body">
		
		<div class="form-group">
			<div class="col-md-2"><label style="padding-top:7px;">Tabel</label></div>
			<div class="col-md-6">
			<?php
				echo form_dropdown('tabel',$tabel,false,"id='tabel' class='form-control chosen'");
			?>	
			</div>
		</div>
		<br/><br/>
		<div class="form-group">
			<div class="col-md-2"><label style="padding-top:7px;">Nama Modul</label></div>
			<div class="col-md-6"><input type="text" name="name_md" id="name_md" class="form-control" placeholder="Nama Modul ..."></div>
		</div>
		<br/><br/>

		<table class="table table-bordered table-striped" id="datafield">
			<thead>
				<tr>
					<th rowspan="2" style="vertical-align:inherit">Fiel Tabel</th>
					<th colspan="2">In Datatables</th>
					<th colspan="3">In Form</th>
				</tr>
				<tr>
					<th>View</th>
					<th>Label Thead</th>
					<th>Input</th>
					<th>Label</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<br>
		<div id="tgenerate"></div>
	</div><!-- /.box-body -->
	</form>
	<div class="box-footer" align="right">
	  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
	</div><!-- /.box-footer-->
  </div><!-- /.box -->

</section><!-- /.content -->

<script>
$(function(){
	$('.chosen').select2();
	$('#fgenerate').validate({
        errorClass: 'help-block col-xs-12',
		errorElement: 'span',
		highlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}
	});

	$("#tabel").change(function(){
			$.post("<?php echo site_url()?>/generator/field_tabel",{tabel : $(this).val()}, function(msg){
					if(msg)
					{
						$('#datafield tbody').html(msg);
						$('#tgenerate').html('<input type="submit" name="generate" id="generate" value="generate" class="btn btn-success">');
					}
					else
					{
						alert('NO FIELD !!!');
					}
				}
			);
		});
		
	$("#fgenerate").submit(function(){
			var cb = $("#fgenerate input:checked").length;
			var nm = $("#name_md").val();
			if(cb == 0 || nm == '')
			{
				alert("Isi Nama Modul / Ceklist Terlebih dahulu !!!");
				return false
			}
			else
			{
				return true;
			}
		});	
	$(':checkbox[readonly=readonly]').click(function(){
		return false;
	});		

});

function thead(x)
{
	var c = $('.c'+x);
	var t = c.parent().next().find('.text'+x);
	if(c.prop("checked"))
	{
		$(t).attr("disabled", false);
	}
	else
	{
		$(t).attr("disabled", true);
	}
}

function labelf(x)
{
	var t = $('.text'+x);
	var ft = t.parent().next().next().find('.ftext'+x);
	$(ft).val($(t).val());
}

function finput(x)
{
	var d = $('.d'+x);
	var ft = d.parent().next().find('.ftext'+x);
	var ty = d.parent().next().next().find('.type'+x);
	if(d.prop("checked"))
	{
		$(ft).attr("disabled", false);
		$(ty).attr("disabled", false);
	}
	else
	{
		$(ft).attr("disabled", true);
		$(ty).attr("disabled", true);
	}	
}
</script>
