<link rel="stylesheet" href="<?php echo base_url();?>/asset/plugins/chosen/chosen.bootstrap.min.css">
<script src="<?php echo base_url();?>/asset/plugins/chosen/chosen.jquery.min.js"></script>
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
	<form id="fgenerate" action="<?php echo site_url();?>/generator/fnGenerateJoin" method="post">
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
			<div class="col-md-2"><label style="padding-top:7px;">Join Tabel</label></div>
			<div class="col-md-6">
			<?php
				$detail = array(""=>"Pilih Tabel Dulu !!!");
				echo form_dropdown('detailtabel',$detail,false,"id='detailtabel' class='form-control chosen'");
			?>	
			</div>
		</div>
		<br/><br/>
		<div class="form-group">
			<div class="col-md-2"><label style="padding-top:7px;">Nama Modul</label></div>
			<div class="col-md-6"><input type="text" name="name_md" id="name_md" class="form-control" placeholder="Nama Modul ..."></div>
		</div>
		<br/><br/>

		<table class="table table-bordered" id="datafield">
			<thead>
				<tr>
					<th>Fiel Tabel</th>
					<th>In Datatables</th>
					<th>In Form</th>
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
	$('.chosen').chosen();
	$("#tabel").change(function(){
			$.post("<?php echo site_url()?>/generator/reference_tabel",{tabel : $(this).val()}, function(data){
					if(data)
					{
						$("#detailtabel").html(data);
						$("#detailtabel").trigger("chosen:updated");
					}
					else
					{
						alert('NO REFERENCE !!!');
					}
				}
			);
		});

	$("#detailtabel").change(function(){
			var dtabel = $("#tabel").val();
			$.post("<?php echo site_url()?>/generator/field_tabel_join",{tabel:dtabel,detailtabel : $(this).val()}, function(msg){
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
</script>
