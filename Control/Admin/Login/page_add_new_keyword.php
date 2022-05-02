<?php
$query = new query();
$langs = $query->fetchAssoc("select * from lang");
?>


<div class="margin-bottom-50">
	<h2>Add New Keyword</h2>
	<form action="home.php?art=add_keyword" method="post">
	<?php
		while($row=$langs->fetch_assoc()) {
	?>
		<div class="form-group row">
            <div class="col-md-9">
            	<input type="text" class="form-control" name="keyword_<?=$row['code']?>" placeholder="Keyword <?=$row['lang_name']?>" id="l0">
            </div>
        </div>
    <?php
		}
	?>
       
        <div class="form-actions">
        	<button type="submit" class="btn btn-primary width-150">Add</button>
        </div>
	</form>
	
	
</div>
