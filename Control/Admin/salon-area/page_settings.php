<?php
admin::deletePastClosingDays();
$query = new query();
$salon_id = admin::getSalonData('salon_id');

$working_days = $query->fetchAssoc("select * from working_days where salon_id='$salon_id' order by working_days_id");

$closing_days = $query->fetchAssoc("select * from closing_days where salon_id = '$salon_id' order by date");

$closing_days_count = query::numRows("select * from closing_days where salon_id = '$salon_id'");

$no_close = ($closing_days_count == 0 ? 'No closing days added yet.' : '');

$type = admin::getSalonData('type');

$o_type = $type == 'salon' ? 'salon' : 'home';

$opening_hours = $query->fetchAssoc("select * from opening_hours where salon_id = '$salon_id' and type='$o_type'");
$opening_hours_data = $opening_hours->fetch_assoc();

$opening_hours_home = $query->fetchAssoc("select * from opening_hours where salon_id = '$salon_id' and type='home'");
$opening_hours_home_data = $opening_hours_home->fetch_assoc();




?>
<h1> Edit settings</h1>
<form action="home.php?art=update_settings" method="post">

    <div class="form-actions">
        <h3>Working days</h3>
        <?php
        while ($row = $working_days->fetch_assoc()) {
            $checked = ($row['active'] == 1 ? 'checked' : '');
        ?>
            <div class="checkbox margin-left-10">
                <label>
                    <input type="checkbox" id="c<?= $row['working_days_id'] ?>" name="<?= $row['working_days_id'] ?>" <?= $checked ?>>
                    <?= $row['day'] ?>
                </label>
            </div>

        <?php
        }
        ?>
        <div class="row padding-10">
            <button type="submit" id="sub" class="btn btn-primary width-150">Save</button>
        </div>


    </div>
</form>
<div class="form-actions">
    <h3>Closing days / Holidays</h3>
    <?php
    while ($row = $closing_days->fetch_assoc()) {
        echo '<p>' . $row['date'] . '<a class="margin-left-5" href="home.php?art=delete_closing_day&i=' . $row['closing_days_id'] . '"><i class="left-menu-link-icon icmn-bin"></i></a></p>';
    }
    ?>
    <p><?= $no_close ?></p>
    <i class="left-menu-link-icon icmn-plus2"></i>
    <a href="home.php?art=add_new_closing_day">Add new closing day</a>


</div>

<?php
if($type == 'salon') {
?>

<div class="form-actions">
    <h3>Opening Hours (Home)
      
    </h3>

    <div class="checkbox margin-left-10">
        <label>
            <b>Open:</b>
            <?= substr($opening_hours_home_data['open'], 0, -3) ?>
        </label>
    </div>
    <div class="checkbox margin-left-10">
        <label>
            <b>Close:</b>
            <?= substr($opening_hours_home_data['close'], 0, -3) ?>
        </label>
    </div>
    <p>

        <i class="left-menu-link-icon icmn-pencil"></i>
        <a href="#" data-toggle="modal" data-target="#open_hours1">Change opening hours</a>

    </p>

    <div class="modal fade modal-size-medium" id="open_hours1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                    <h4 class="modal-title" id="myModalLabel">Change opening hours</h4>
                </div>
                <div class="modal-body text-center">

                    <form action="home.php?art=change_open_time&i=<?=$opening_hours_home_data['opening_hours_id']?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="open">Open</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" name="open" id="open">
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                        if ($i < 10) {
                                            $h = '0' . $i . ':00';
                                        } else {
                                            $h = $i . ':00';
                                        }
                                        echo '<option value=' . $h . '>' . $h . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="close">Close</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" name="close" id="close" disabled=>
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                        if ($i < 10) {
                                            $h = '0' . $i . ':00';
                                        } else {
                                            $h = $i . ':00';
                                        }
                                        echo '<option value=' . $h . '>' . $h . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" id="sub" class="btn btn-primary width-150">Save</button>
                        </div>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>


<div class="form-actions">
    <h3>Opening Hours
        <?php
        echo $type == 'salon' ? '(Salon)' : '';
        ?>
    </h3>

    <div class="checkbox margin-left-10">
        <label>
            <b>Open:</b>
            <?= substr($opening_hours_data['open'], 0, -3) ?>
        </label>
    </div>
    <div class="checkbox margin-left-10">
        <label>
            <b>Close:</b>
            <?= substr($opening_hours_data['close'], 0, -3) ?>
        </label>
    </div>
    <p>

        <i class="left-menu-link-icon icmn-pencil"></i>
        <a href="#" data-toggle="modal" data-target="#open_hours">Change opening hours</a>

    </p>

    <div class="modal fade modal-size-medium" id="open_hours" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                    <h4 class="modal-title" id="myModalLabel">Change opening hours</h4>
                </div>
                <div class="modal-body text-center">

                    <form action="home.php?art=change_open_time&i=<?=$opening_hours_data['opening_hours_id']?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="open">Open</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" name="open" id="open1">
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                        if ($i < 10) {
                                            $h = '0' . $i . ':00';
                                        } else {
                                            $h = $i . ':00';
                                        }
                                        echo '<option value=' . $h . '>' . $h . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="close">Close</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" name="close" id="close1" disabled=>
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                        if ($i < 10) {
                                            $h = '0' . $i . ':00';
                                        } else {
                                            $h = $i . ':00';
                                        }
                                        echo '<option value=' . $h . '>' . $h . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" id="sub" class="btn btn-primary width-150">Save</button>
                        </div>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    


</div>









<script>
    $("#sub").click(function() {

        var total = $('[id^=c]:checked').length;


        if (total === 0) {
            alert("You have to choose at least one working day");
            //event.preventDefault();
            return false;
        }


    });
</script>

<script>
    $("#open").change(function() {
        $("#close").removeAttr("disabled");

    });
    $("#open1").change(function() {
        $("#close1").removeAttr("disabled");

    });
</script>