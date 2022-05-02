<?php
$barber = $_GET['b'];
$date = $_GET['date'];
$barb_ser_id = $_GET['c'];
$hour = $_GET['h'];
$dur = $_GET['d'];
$type = $_GET['type'];

$query = new query();
$products = $query->fetchAssoc( "select * from users order by date_r DESC" );
?>

<div class="panel-body">

    <div class="row">
        <h4>Enter customer information</h4>
        <form action="home.php?art=add_self_book&u=guest" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
            <input type="hidden" name="barber" value="<?=$barber?>">
            <input type="hidden" name="date" value="<?=$date?>">
            <input type="hidden" name="service" value="<?=$barb_ser_id?>">
            <input type="hidden" name="hour" value="<?=$hour?>">
            <input type="hidden" name="dur" value="<?=$dur?>">
            <input type="hidden" name="type" value="<?=$type?>">
            <div class="form-group row">
                <div class="col-md-9">
                    <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="name" placeholder="Name" id="l0">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-9">
                    <input type="text" class="form-control" data-validation-message="This field must not be empty, or email not valid" data-validation="[NOTEMPTY, EMAIL]" name="email" placeholder="Email" id="l0">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-9">
                    <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="phone" placeholder="Phone" id="l0">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-md-9">
                    <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="address" placeholder="Address" id="l0">
                </div>
            </div>


            <div class="form-actions">
                <button id="sub" type="submit" class="btn btn-primary width-150">Add</button>
            </div>
        </form>

        <div class="col-lg-12">
            <hr>
            <h4>Or select from current customers</h4>
            <hr>
            <form id="formId" action="home.php?art=add_self_book&u=user" method="post">
                <input type="hidden" name="barber" value="<?=$barber?>">
                <input type="hidden" name="date" value="<?=$date?>">
                <input type="hidden" name="service" value="<?=$barb_ser_id?>">
                <input type="hidden" name="hour" value="<?=$hour?>">
                <input type="hidden" name="dur" value="<?=$dur?>">
                <input type="hidden" name="type" value="<?=$type?>">

                <div class="margin-bottom-50">
                <table class="table table-hover nowrap" id="users" width="100%">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>

                        <th>Select</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php
                    while ( $row = $products->fetch_assoc() ) {
                        ?>
                        <input type="hidden" name="user" value="<?=$row['user_id']?>">
                        <tr>
                            <td>
                                <?=$row['first_name']?>
                            </td>

                            <td>
                                <?=$row['last_name']?>
                            </td>
                            <td>
                                <?=$row['email']?>
                            </td>
                            <td>
                                <?=$row['phone']?>
                            </td>

                            <td>
                                <button id="button1" onclick="setUrl(<?=$row['user_id']?>)"  type="button" class="btn btn-icon btn-primary margin-inline">
                                    <i class="icmn-cursor" aria-hidden="true"></i>
                                </button>


                            </td>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    </form>


</div>

<script>
    $('#users').DataTable({
        responsive: true,
        "lengthMenu": [[25, 50, -1], [25, 50, "All"]]
    });
</script>

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
function setUrl(i)   {
    $('#formId').attr('action', 'home.php?art=add_self_book&u=user&i='+i);
    $('#formId').submit();
}
</script>
