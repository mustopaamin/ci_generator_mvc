<?php
$this->load->view('layout/header');
$this->load->view('layout/sidebar');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php
$this->load->view($content);
echo "</div><!-- /.content-wrapper -->";
$this->load->view('layout/footer');
?>
