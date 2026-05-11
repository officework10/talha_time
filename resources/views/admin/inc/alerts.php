<?php if(!empty($this->session->userdata['alertType'])): 
	$alertType = $this->session->userdata['alertType'];
	$alertMsg = $this->session->userdata['alertMsg'];
?>
<div class="row">
        	<div class="col-sm-12 col-md-12">
            	<div class="alert alert-<?php echo $alertType; ?>">
                	<?php echo $alertMsg; ?>
                	<button data-dismiss="alert" class="close" type="button">×</button>
                </div>
            </div>
        </div>
<?php endif; ?>