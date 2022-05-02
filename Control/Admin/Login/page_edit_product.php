<?php
$query = new query();
$lang = $query->fetchAssoc("select * from lang");
$langs = $query->fetchAssoc("select * from lang");
$product = $query->fetchAssoc("select * from product where product_id = '$_GET[i]'");
$sproduct = $product->fetch_assoc();

?>


<div class="margin-bottom-50">
	<h2>Edit product "<?=$sproduct['product_name_en']?>"</h2>
	<form action="home.php?art=update_product&i=<?=$_GET['i']?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
	<?php
		while($row=$lang->fetch_assoc()) {
			$value = "product_name_".$row['code'];
			
	?>
		<div class="form-group row">
            <div class="col-md-9">
            	Name <?=$row['lang_name']?><input type="text" class="form-control" name="product_name_<?=$row['code']?>" value="<?=$sproduct[$value]?>" id="l0">
            </div>
        </div>
      
        
    <?php
		}
	?>
        <div class="form-group row">
            <div class="col-md-9">
            	Price<input type="text" class="form-control" name="price" value="<?=$sproduct['price']?>" data-validation-message="This field must not be empty, accept only numbers" data-validation="[NOTEMPTY],NUMERIC" id="l0">
            </div>
        </div>
         
        
      
       
       <?php
		while ( $row = $langs->fetch_assoc() ) {
			$desc = "product_desc_".$row['code'];
		?>
		<div class="form-group">
           product description <?=$row['lang_name']?>
            <textarea class="summernote" name="<?=$desc?>">
                <?=$sproduct[$desc]?>
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
	$( function () {

		$( '#form-validation' ).validate( {
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger'
				}
			}

		} );

		$( '#form-validation-simple' ).validate( {
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error-list',
					errorClass: 'has-danger'
				}
			}

		} );

		$( '.select2' ).select2();
		$( '.select2-tags' ).select2( {
			tags: true,
			tokenSeparators: [ ',', ' ' ]
		} );

	} );
	
	
	
    $(function() {
        $('.summernote').summernote({
            height: 350
        });
    });
</script>
