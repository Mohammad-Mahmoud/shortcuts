<?php
query::update("update reports set readen = 1 where report_id = '$_GET[r]'");
$query = new query();
$message = $query->fetchAssoc("select * from reviews where review_id = '$_GET[i]'");
$message_detail = $message->fetch_assoc();
$text = str_replace("\n", "<br>", $message_detail['text']);

$date = strtotime( $message_detail['date'] );
$year = date( 'd/m/Y', $date );

$salon_id = query::returnSingleValue('reviews','salon_id','review_id = '.$_GET['i']);
$salon_name = query::returnSingleValue('salon','name','salon_id = '.$salon_id);



?>

<div class="panel">

    <div class="panel-body">
        <div class="margin-bottom-50">
            <div class="invoice-block">
                <div class="row">
                    <div class="col-md-6">

                        <address>
                            <b style="color:#A2A2A2"><?=$year?> </b>
                            <br /><br />
                            <b style="color:#A2A2A2">Review Title: </b><?=$message_detail['title']?>
                            <br /><br />
                            <b style="color:#A2A2A2">Salon: </b><?=$salon_name?>

                        </address>
                    </div>

                    <div class="col-md-6 text-right">
                        <a href="home.php?art=delete_review&i=<?=$_GET['i']?>&r=<?=$_GET['r']?>" class="link-underlined"><i class="icmn-cross2"><!-- --></i> Delete this review</a>
                    </div>

                </div>
                <hr>
                <h5 class="margin-top-30 margin-bottom-30">Review Text</h5>
                <div class="text-left">

                    <?=$text?>
                </div>
                <hr>


            </div>
        </div>
    </div>
</div>

