<?php
$lang = new lang();
?>
<div class="margin-bottom-50">
	<h2>Edit Language</h2>
	<form action="home.php?art=update_lang&i=<?=$_GET['i']?>" method="post">
		<div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" name="name" placeholder="Language Name" id="l0" value="<?=$lang->getLangRow('lang_name')?> ">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" name="code" placeholder="Language Code" id="l0" value="<?=$lang->getLangRow('code')?>">
            </div>
        </div>
       
        <div class="form-actions">
        	<button type="submit" class="btn btn-primary width-150">Update</button>
        </div>
	</form>
	
	
</div>
