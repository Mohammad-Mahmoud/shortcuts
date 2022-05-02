<?php
$query = new query();
$salon_id = admin::getSalonData('salon_id');
$q = "SELECT * FROM actual_booking a, barbers b where 
                    a.barber_id = b.barber_id and b.salon_id = '$salon_id' and hidden_salon = 0 order by date DESC";

$n = query::numRows($q);
if($n==0) {
    echo 'No booking';
}
else {
$bookings = $query->fetchAssoc($q);


?>
<script>
    function confirmDelete(id) {

        if(confirm('You are about to delete this booking, are you sure?')) {


            location.replace('home.php?art=delete_booking&i='+id)

        }

        else {

            return false;
        }
    }

</script>

<div class="panel-body">

    <div class="row">

        <div class="heading-buttons pull-left margin-bottom-20">

            <a href="home.php?art=add_booking" class="btn btn-primary">
                <i class="icmn-plus3"></i>
                Book self
            </a>
        </div>

        <div class="col-lg-12">


            <h4>Bookings</h4>


            <div class="margin-bottom-50">
                <table class="table table-hover nowrap" id="example2" width="100%">
                    <thead>
                    <tr>
                        <th>Booking time</th>
                        <th>Barber</th>
                        <th>Service</th>
                        <th>Customer Details</th>
                        <th>Service type</th>

                        <th>Delete</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $date_now = date("Y-m-d");
                    $hour_now = date('G');

                    while ( $row = $bookings->fetch_assoc() ) {
                        $hour = date('G', $row['hour']);


                        if( $date_now > $row['date']) {
                            $style = 'style="background-color:lavender"';
                        } else if($date_now == $row['date']) {
                           if($hour_now > $hour) {
                                $style = 'style="background-color:lavender"';
                            } else {
                                $style = '';

                            }
                        }
                        if($row['status'] == 1){
                            $canceled = '<span style="color: #fff">Canceled</span>';
                            $style = 'style="background-color: red;"';

                        } else {
                            $canceled = '';
                            $style = '';
                        }
                        $query::update("update actual_booking set readen = 1 where barber_id = ".$row['barber_id']);
                        $service = $query::returnSingleValue('barbers_services','service_id','barb_ser_id='.$row['barb_ser_id']);
                        $service_name = $query::returnSingleValue("services","name","service_id= '".$service."'");
                        if($row['type'] == '') {
                            $type = $query::returnSingleValue('barbers_services','type','barb_ser_id='.$row['barb_ser_id']);
                        } else {
                            $type = $row['type'];
                        }
                        if($row['guest'] == 1){
                            $user_details = $query->extract2DArrayFromQuery('guest', ['name','phone','email'],'temp_user_id ="'.$row['user_id'].'"');
                            $name = $user_details['name'];
                        } else {
                            $user_details = $query->extract2DArrayFromQuery('users', ['first_name','last_name','phone','email'],'user_id = '.$row['user_id']);
                            $name = $user_details['first_name'].' '.$user_details['last_name'];;
                        }

                        ?>
                        <tr <?=$style?>>
                            <td>
                                <?=$row['hour'].' '.$row['date']?>
                            </td>
                            <td><?=$row['name']?></td>
                            <td>
                                <?=$service_name?>

                            </td>

                            <td>

                                <button data-toggle="modal" data-target="#pic<?= $row['actual_booking_id'] ?>" type="button" class="btn btn-icon btn-primary margin-inline">
                                    <i class="icmn-user" aria-hidden="true"></i><?=$name?>
                                </button>
                                <div class="modal fade modal-size-large" id="pic<?= $row['slide_id'] ?>" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>


                                                <h4 class="modal-title" id="myModalLabel">Change image</h4>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div class="row">
                                                    <img src="../../../img/<?= $row['url'] ?>" style="height: 400px; width: auto;">
                                                </div>
                                                <form action="home.php?art=change_slide_image&i=<?= $row['slide_id'] ?>" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
                                                    <div class="form-actions">
                                                        <label for="l30">Choose another Image</label>
                                                        <input type="file" class="form-control" name="Filedata" id="l30" data-validation-message="You didn't choose any file" accept="image/*" data-validation="[NOTEMPTY]">
                                                        <label id="status"></label>
                                                        <button type="submit" class="btn btn-primary width-150">Change</button>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?=$canceled?>
                            </td>
                            <td>
                                <?=$type?>
                            </td>




                            <td>
                                <button onClick="location.replace('home.php?art=delete_booking&i=<?=$row['actual_booking_id']?>')" type="button" class="btn btn-icon btn-danger margin-inline">
                                    <i class="icmn-bin" aria-hidden="true"></i>
                                </button>

                            </td>
                            <div class="modal fade modal-size-large" id="pic<?= $row['actual_booking_id'] ?>" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>


                                            <h4 class="modal-title" id="myModalLabel">Customer Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><b style="font-size:16px;">Name: </b><?=$name?></p>
                                            <p><b style="font-size:16px;">Phone: </b><?=$user_details['phone']?></p>
                                            <p><b style="font-size:16px;">Email: </b><?=$user_details['email']?></p>
                                            <p><b style="font-size:16px;">Address: </b><?=$row['address']?></p>

                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<?php
}
?>

<script>
    $('#example2').DataTable({
        responsive: true,
        "lengthMenu": [
            [25, 50, -1],
            [25, 50, "All"]
        ],
        orderable: false
    });
</script>
