<?php
$query = new query();
$social = $query->fetchAssoc("select * from users where user_id = '$_GET[i]'");
$s_social = $social->fetch_assoc();
?>
<div class="margin-bottom-50">
    <h2>Edit social</h2>
    <form action="home.php?art=update_user&i=<?= $_GET['i'] ?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-9">
                First Name
                <input type="text" name="first_name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Name" id="l0" value="<?= $s_social['first_name'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Last Name
                <input type="text" name="last_name" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Link" id="l0" value="<?= $s_social['last_name'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Phone
                <input type="text" name="phone" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Link" id="l0" value="<?= $s_social['phone'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Password
                <input type="password" name="password" class="form-control" data-validation-message="Password must be at least 6 characters" data-validation="[L>=6]" placeholder="Link" id="l0" value="<?= $s_social['password'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Birthdate
                <input type="date" name="birthday" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Link" id="l0" value="<?= $s_social['birthday'] ?>">
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