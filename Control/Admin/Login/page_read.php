 <?php
query::update("update messages set readen = 1 where messages_id = '$_GET[i]'");
$query = new query();
$message = $query->fetchAssoc("select * from messages where messages_id = '$_GET[i]'");
$message_detail = $message->fetch_assoc();
$text = str_replace("\n", "<br>", $message_detail['text']);
$next = $query->fetchAssoc("select *,count(*) count from messages where date = (select min(date) from messages where date > '$message_detail[date]')");
$previous = $query->fetchAssoc("select *,count(*) count from messages where date = (select max(date) from messages where date < '$message_detail[date]')");
$next_msg = $next->fetch_assoc();
$previous_msg = $previous->fetch_assoc();

$date = strtotime( $message_detail['date'] );
$year = date( 'd/m/Y', $date );
$time = date( 'H:i', $date );



?>
       
       <div class="panel">
        
        <div class="panel-body">
            <div class="margin-bottom-50">
                <div class="invoice-block">
                    <div class="row">
                        <div class="col-md-6">
                            
                            <address>
								<b style="color:#A2A2A2"><?=$year?> - <?=$time?></b>
                            	<br /><br />
                            	<b style="color:#A2A2A2">From: </b><?=$message_detail['name']?>
                            	 <br /><br />
								<b style="color:#A2A2A2">Email: </b><?=$message_detail['email']?>
                               
                            </address>
                        </div>
                        
                        <div class="col-md-6 text-right">
                            <a href="home.php?art=delete_message&i=<?=$_GET['i']?>" class="link-underlined"><i class="icmn-cross2"><!-- --></i> Delete</a>
                        </div>
                    
                    </div>
                    <hr>
                    <h5 class="margin-top-30 margin-bottom-30">Message</h5>
                    <div class="text-left">
                       
                        <?=$text?>
                    </div>
              		<hr>
                    <div class="text-right">
                      <?php
						if($previous_msg['count'] != 0) {
						?>
                       <button type="submit" class="btn btn-primary" onClick=location.replace("home.php?art=read&i=<?=$previous_msg['messages_id'];?>")>
                            Older
                        </button>
						<?php
						}
						if($next_msg['count'] != 0) {
						?>
                        <button type="submit" class="btn btn-primary" onClick=location.replace("home.php?art=read&i=<?=$next_msg['messages_id'];?>")>
                            Newer
                        </button>
                        <?php
						}
						?>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
