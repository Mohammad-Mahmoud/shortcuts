<?php
$query = new query();
$languages = $query->fetchAssoc( "select * from lang" );
$contact = $query->fetchAssoc("select * from contact where contact_id =2");
$s_contact = $contact->fetch_assoc();
?>

<div class="margin-bottom-50">
	<h2>Contact us</h2>
	<form action="home.php?art=update_contact&i=2" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
		
		<?php
		while ( $row = $languages->fetch_assoc() ) {
			$value = 'contact_desc_'.$row['code'];
		?>
		<div class="form-group">
           Contact us <?=$row['lang_name']?>
            <textarea class="summernote" name="contact_desc_<?=$row['code']?>">
                <?=$s_contact[$value];?>
            </textarea>
        </div>
        <?
		}
		?>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary width-150">Update</button>
		</div>
	</form>


</div>


<script>
	
    $(function() {
        $('.summernote').summernote({
            height: 350
        });
    });
</script>