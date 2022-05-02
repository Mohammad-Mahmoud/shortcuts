<?php
query::update("update salon_req set readen = 1 where req_id = '$_GET[i]'");
$query = new query();
$message = $query->fetchAssoc("select * from salon_req where req_id = '$_GET[i]'");
$message_detail = $message->fetch_assoc();
$text = str_replace("\n", "<br>", $message_detail['notes']);
$next = $query->fetchAssoc("select *,count(*) count from salon_req where date = (select min(date) from salon_req where date > '$message_detail[date]')");
$previous = $query->fetchAssoc("select *,count(*) count from salon_req where date = (select max(date) from salon_req where date < '$message_detail[date]')");
$next_msg = $next->fetch_assoc();
$previous_msg = $previous->fetch_assoc();

$date = strtotime( $message_detail['date'] );
$year = date( 'd/m/Y', $date );


if($message_detail['type'] == 0) {
    $type = 'Self employed';
} else {
    $type = 'Hair salon';
}

if($text == '') {
    $text = 'User did not provied any additional information';
} 



?>
       
       <div class="panel">
        
        <div class="panel-body">
            <div class="margin-bottom-50">
                <div class="invoice-block">
                    <div class="row">
                        <div class="col-md-6">
                            
                            <address>
								<b style="color:#A2A2A2"><?=$year?></b>
                            	<br /><br />
                            	<b style="color:#A2A2A2">From: </b><?=$message_detail['name']?>
                            	 <br /><br />
                                <b style="color:#A2A2A2">Email: </b><?=$message_detail['email']?>
                                <br /><br />
                                <b style="color:#A2A2A2">Home Address: </b><?=$message_detail['address']?>
                                <br /><br />
                                <b style="color:#A2A2A2">Phone: </b><?=$message_detail['phone']?>
                                <br /><br />
                                <b style="color:#A2A2A2">Type: </b><?=$type?>
                                <?php
                                if($message_detail['type'] == 1) {
                                ?>
                                <br /><br />
                                <b style="color:#A2A2A2">Salon name: </b><?=$message_detail['salon_name']?>
                                <br /><br />
                                <b style="color:#A2A2A2">Salon address: </b><?=$message_detail['salon_address']?>
                                <?php
                                }
                                ?>
                               
                            </address>
                        </div>
                        
                        <div class="col-md-6 text-right">
                            <a style="color:red" href="home.php?art=delete_req&i=<?=$_GET['i']?>" class="link-underlined"><i class="icmn-cross2"><!-- --></i> Delete</a> || 
                            <?php
                            if($message_detail['approved'] == 0) {
                            ?>
                            <a style="color:green;" href="home.php?art=approve_req&i=<?=$_GET['i']?>" class="link-underlined"><i class="icmn-user-check"><!-- --></i> Approve?</a>
                            <?php
                            } else {
                            ?>
                            <span style="color:green;"><i class="icmn-checkmark"><!-- --></i> Approved</span>

                            
                            <?php
                            }
                            ?>
                        </div>
                    
                    </div>
                    <hr>
                    <h5 class="margin-top-30 margin-bottom-30">Additional Information</h5>
                    <div class="text-left">
                       
                        <?=$text?>
                    </div>
              		<hr>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
