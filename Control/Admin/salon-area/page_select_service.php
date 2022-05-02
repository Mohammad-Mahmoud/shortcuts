<?php
$q = "select* from barbers_services b, services s where b.service_id = s.service_id and barber_id = '$_POST[barbers]'";
$query = new query();
$services = $query->fetchAssoc($q);
?>
<form action="home.php?art=select_date&b=<?=$_POST['barbers']?>" method="post">
    <div class="form-group">
        <label>Select Sevice</label>
        <select class="form-control" name="services">
            <?php
            while($row = $services->fetch_assoc()){
                if($row['type'] == 'both') {
                ?>
                <option value="h<?=$row['barb_ser_id']?>"><?=$row['name']?> - Home</option>
                <option value="s<?=$row['barb_ser_id']?>"><?=$row['name']?> - Salon</option>
            <?php }
                    else {
             ?>
            <option value="<?=$row['type'][0].$row['barb_ser_id']?>"><?=$row['name']?> - <?=$row['type']?></option>
            <?php
                    }
            }
            ?>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" value="Next">
</form>
