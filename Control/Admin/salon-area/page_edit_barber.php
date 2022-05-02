<?php
$query = new query();
$barber = $query->fetchAssoc("select * from barbers where barber_id = '$_GET[i]'");
$barber_data = $barber->fetch_assoc();
?>


<div class="margin-bottom-50">
    <h2>Edit barber info</h2>
    <form action="home.php?art=update_barber_profile&i=<?= $_GET['i'] ?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-9">
                Name
                <input type="text" name="name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Name" id="l0" value="<?= $barber_data['name'] ?>">
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-md-9">
                Phone
                <input type="text" name="phone" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" id="l0" value="<?= $barber_data['phone'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Address
                <input type="text" name="address" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" id="l0" value="<?= $barber_data['address'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-9">
                Radius in KM for home cut
                <input type="text" name="radius" class="form-control" data-validation-message="Only numbers grater than 0" data-validation="[INTEGER, V>0]" id="l0" value="<?= $barber_data['radius'] ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-9">
                Info
                <textarea class="summernote" name="info" class="form-control" id="l0"><?= $barber_data['info'] ?></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary width-150">Update</button>
        </div>
    </form>


</div>


<script>
    $(function() {

        $('#form-validation').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-control-error',
                    errorClass: 'has-danger'
                }
            }

        });

        $('#form-validation-simple').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-control-error-list',
                    errorClass: 'has-danger'
                }
            }

        });

        $('.select2').select2();
        $('.select2-tags').select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });

    });
</script>


<script>
    $(function() {
        $('.summernote').summernote({
            height: 350,

        });
    });
</script>