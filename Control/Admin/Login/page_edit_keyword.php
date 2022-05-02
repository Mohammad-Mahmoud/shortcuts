<?php
$query = new query();
$keywords = $query->fetchAssoc("select * from lang");
$keyword = $query->fetchAssoc("select * from keyword where keyword_id = '$_GET[i]'");
$s_keyword = $keyword->fetch_assoc();
?>


<div class="margin-bottom-50">
	<h2>Edit Keyword</h2>
	<form action="home.php?art=update_keyword&i=<?=$_GET['i']?>" method="post">
	<?php
		while($row=$keywords->fetch_assoc()) {
			$value = "keyword_name_".$row['code'];
			
	?>
		<div class="form-group row">
            <div class="col-md-9">
            	<?=$row['lang_name']?><input type="text" class="form-control" name="keyword_name_<?=$row['code']?>" value="<?=$s_keyword[$value]?>" id="l0">
            </div>
        </div>
    <?php
		}
	?>
        <div class="form-actions">
        	<button type="submit" class="btn btn-primary width-150">Update</button>
        </div>
	</form>
	
	
</div>
