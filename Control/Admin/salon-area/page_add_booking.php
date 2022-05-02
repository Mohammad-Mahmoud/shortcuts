<?php
$query = new query();
$salon_id = admin::getSalonData('salon_id');
$barbers = $query->fetchAssoc("select * from barbers where salon_id = ".$salon_id);

?>
<form action="home.php?art=select_service" method="post">
    <div class="form-group">
        <label>Select Barber</label>
        <select class="form-control" name="barbers">
            <?php
            while($row = $barbers->fetch_assoc()){
                ?>
                <option value="<?=$row['barber_id']?>"><?=$row['name']?></option>
            <?php } ?>
        </select>
    </div>

<input type="submit" class="btn btn-primary" value="Next">
</form>

