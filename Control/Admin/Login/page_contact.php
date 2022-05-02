<?php
$query = new query();
$languages = $query->fetchAssoc( "select * from lang" );
$contact = $query->fetchAssoc("select * from contact where contact_id ='$_GET[i]'");
$s_contact = $contact->fetch_assoc();
switch($_GET['i']) {
	case 1:
		$name = 'Contact Us';
		break;
	case 2:
		$name = "Home Page";
		break;
	case 3:
		$name = "About Us";
		break;
}
?>

<div class="margin-bottom-50">
	<h2><?=$name?></h2>
	<form action="home.php?art=update_contact&i=<?=$_GET['i']?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
		
		<?php
		while ( $row = $languages->fetch_assoc() ) {
			$value = 'contact_desc_'.$row['code'];
		?>
		<div class="form-group">
           <?=$name?> <?=$row['lang_name']?>
            <textarea class="summernote" name="contact_desc_<?=$row['code']?>">
                <?=$s_contact[$value];?>
            </textarea>
        </div>
        <?php
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