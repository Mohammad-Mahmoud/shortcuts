<?php
$query = new query();
$services = $query->fetchAssoc("select * from barbers_services b, services s
                                where b.service_id = s.service_id
                                and barber_id = '$_GET[i]'");
$q1 = "select * from services";
$q2 = "select * from barbers_services where barber_id = '$_GET[i]'";

$all_ser = query::numRows($q1);
$cur_barb_ser = query::numRows($q2);


if($cur_barb_ser < $all_ser) {
    $barb_ser = $query->fetchAssoc($q2);
    $arr = array();
    
    while($row = $barb_ser->fetch_assoc()) {
       array_push($arr,$row['service_id']);
    }

    $new_arr = implode("','",$arr);
    
    $other_ser = $query->fetchAssoc("SELECT * FROM services WHERE service_id NOT IN ('$new_arr')");
    
} 
if(admin::getSalonData('type') == 'self') {
    $salon_id = admin::getSalonData('salon_id');
    $query = new query;
    $barber = $query->fetchAssoc("select barber_id from barbers where salon_id = '$salon_id'");
	$barb_id_data = $barber->fetch_assoc();
    $barb_id = $barb_id_data['barber_id'];
    $current = '';
    $more = 'Add services';
} else {
    $barb_id = $_GET['i'];
    $current = 'Current barber services';
    $more = 'Add more services';
}
?>


<div class="margin-bottom-50">
    <h2><?=$current?></h2>
    <form action="home.php?art=update_barber_services&i=<?=$barb_id?>" method="post" id="form-validation-simple" name="form-validation-simple">
    <?php
                $count = 0;
                while ($row = $services->fetch_assoc()) {
                    $count++;
                    $home = ($row['type'] == 'home' ? 'checked' : ''); 
                    $salon = ($row['type'] == 'salon' ? 'checked' : ''); 
                    $both = ($row['type'] == 'both' ? 'checked' : ''); 

                    
                    
                ?>
                <script>
                    $(function() {

                        $('#c<?=$count?>').change(function() {
                            if(this.checked) {
                                $("#r<?=$count?>").css("display","block");
                                $("#t<?=$count?>").css("display","block");
                                $("#dur<?=$count?>").css("display","block");
                                $('#price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                                $('#price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                                $('#price_salon<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                                $('#price_salon<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                                $('#duration<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                                $('#duration<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                                $('#uncheck<?=$count?>').removeAttr("value");
                                
                            }
                            if(this.checked == false) {
                                $("#r<?=$count?>").css("display","none");
                                $("#t<?=$count?>").css("display","none");
                                $("#dur<?=$count?>").css("display","none");
                                $('#price_home<?=$count?>').removeAttr("data-validation-message");
                                $('#price_home<?=$count?>').removeAttr("data-validation");
                                $('#price_salon<?=$count?>').removeAttr("data-validation-message");
                                $('#price_salon<?=$count?>').removeAttr("data-validation");
                                $('#duration<?=$count?>').removeAttr("data-validation-message");
                                $('#duration<?=$count?>').removeAttr("data-validation");
                                $('#uncheck<?=$count?>').attr("value", "<?= $row['barb_ser_id'] ?>");
                            }            
                        });

                        $("#s<?=$count?>").click(function() {
                            $("#price_home<?=$count?>").css("display","none");
                            $("#price_salon<?=$count?>").css("display","block");

                            $('#price_home<?=$count?>').removeAttr("data-validation-message");
                            $('#price_home<?=$count?>').removeAttr("data-validation");

                        });
                        $("#h<?=$count?>").click(function() {
                            $("#price_home<?=$count?>").css("display","block");
                            $("#price_salon<?=$count?>").css("display","none");
                            $('#price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                           
                          
                        });
                        $("#b<?=$count?>").click(function() {
                            $("#price_home<?=$count?>").css("display","block");
                            $("#price_salon<?=$count?>").css("display","block");

                        });

                    });
                </script>
        <input type="hidden" name="uncheck<?=$count?>" id="uncheck<?=$count?>">
        <div class="row">
            <div class="col-md-2" id="check">
                <input type="checkbox" id="c<?= $count ?>" name="c<?= $count ?>" value="<?= $row['barb_ser_id'] ?>" checked>
                <?= $row['name'] ?>
            </div>
            <?php
            if(admin::getSalonData('type') == 'salon') {
            ?>
            <div id="r<?= $count ?>">
                <div class="col-md-2">
                    <input type="radio" id="s<?= $count ?>" name="ser<?= $count ?>" value="salon" <?=$salon?>>
                    Just salon service
                </div>
                <div class="col-md-2">
                    <input type="radio" id="h<?= $count ?>" name="ser<?= $count ?>" value="home" <?=$home?>>
                    Just home service
                </div>
                <div class="col-md-2">
                    <input type="radio" id="b<?= $count ?>" name="ser<?= $count ?>" value="both" <?=$both?>>
                    both
                </div>

            </div>
            <?php
            }
            ?>
        </div>

        <div class="row" style="margin-top: 10px;" id="t<?= $count ?>" >
            <div class="col-md-2" id="price_home<?=$count?>">
                Home cut price:
                <div class="form-group">
                   <input type="text" value="<?=$row['price_home']?>" data-validation-message="Only numbers greater than 0" data-validation= "[INTEGER, V>0]"  class="form-control" name="price_home<?= $count ?>" id="price_home<?= $count ?>" placeholder="Home cut price">
                </div>
            </div>
            <?php
            if(admin::getSalonData('type') == 'salon'){
            ?>
            <div class="col-md-2" id="price_salon<?=$count?>">
                Salon cut price:
                <div class="form-group">
                   <input type="text" value="<?=$row['price_salon']?>" data-validation-message="Only numbers greater than 0" data-validation= "[INTEGER, V>0]"  class="form-control" name="price_salon<?= $count ?>" id="price_salon<?= $count ?>" placeholder="Salon cut price">
                </div>
            </div>
            <?php
            }
            ?>
            

            <div class="col-md-2" id="dur<?= $count ?>">
            Duration
                <div class="form-group">
                    <input type="text" value="<?=$row['dur']?>" class="form-control" data-validation-message="Only numbers greater than 0" data-validation= "[INTEGER, V>0]" name="duration<?= $count ?>" id="duration<?= $count ?>" placeholder="Duration in Minutes">
                </div>
            </div>
        </div>
        <hr>
        <?php
        }
        if($cur_barb_ser < $all_ser) {
        ?>
        <h2><?=$more?></h2>
        <div class="form-group">
                <br>
                <?php
                $count = 0;
                while ($row = $other_ser->fetch_assoc()) {
                    $count++;
                ?>
                <script>
                    $(function() {

                        $('#ch<?=$count?>').change(function() {
                            if(this.checked) {
                                $("#radio<?=$count?>").css("display","block");
                                $("#text<?=$count?>").css("display","block");
                                $("#s_duration<?=$count?>").css("display","block");
                                $('#s_price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                                $('#s_price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                                $('#s_price_salon<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                                $('#s_price_salon<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                                $('#s_duration<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                                $('#s_duration<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                                
                            }
                            if(this.checked == false) {
                                $("#radio<?=$count?>").css("display","none");
                                $("#text<?=$count?>").css("display","none");
                                $("#s_duration<?=$count?>").css("display","none");
                                $('#s_price_home<?=$count?>').removeAttr("data-validation-message");
                                $('#s_price_home<?=$count?>').removeAttr("data-validation");
                                $('#s_price_salon<?=$count?>').removeAttr("data-validation-message");
                                $('#s_price_salon<?=$count?>').removeAttr("data-validation");
                                $('#s_duration<?=$count?>').removeAttr("data-validation-message");
                                $('#s_duration<?=$count?>').removeAttr("data-validation");
                            }            
                        });

                        $("#salon<?=$count?>").click(function() {

                            $("#c_price_home<?=$count?>").css("display","none");
                            $("#c_price_salon<?=$count?>").css("display","block");
                            $('#s_price_home<?=$count?>').removeAttr("data-validation-message");
                            $('#s_price_home<?=$count?>').removeAttr("data-validation");
                            $('#s_price_salon<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#s_price_salon<?=$count?>').attr("data-validation", "[INTEGER, V>0]");

                        });
                        $("#home<?=$count?>").click(function() {

                            $("#c_price_home<?=$count?>").css("display","block");
                            $("#c_price_salon<?=$count?>").css("display","none");
                            $('#s_price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#s_price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                            $('#s_price_salon<?=$count?>').removeAttr("data-validation-message");
                            $('#s_price_salon<?=$count?>').removeAttr("data-validation");

                        });
                        $("#both<?=$count?>").click(function() {

                            $("#c_price_home<?=$count?>").css("display","block");
                            $("#c_price_salon<?=$count?>").css("display","block");
                            $('#s_price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#s_price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                            $('#s_price_salon<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#s_price_salon<?=$count?>').attr("data-validation", "[INTEGER, V>0]");

                        });

                    });
                </script>
                    <div class="row">
                        <div class="col-md-2" id="check">
                            <input type="checkbox" id="ch<?= $count ?>" name="ch<?= $count ?>" value="<?=$row['service_id']?>">
                            <?= $row['name'] ?>
                        </div>
                        <?php
                        if(admin::getSalonData('type') == 'salon'){
                        ?>
                        <div id="radio<?=$count?>" style="display:none;">
                            <div class="col-md-2">
                                <input type="radio" id="salon<?=$count?>" name="serv<?= $count ?>" value="salon" >
                                Just salon service
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="home<?=$count?>" name="serv<?= $count ?>" value="home">
                                Just home service
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="both<?=$count?>" name="serv<?= $count ?>" value="both" checked>
                                both
                            </div>
                            
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="row" id="text<?=$count?>" style="display:none;">
                                <div class="col-md-2" id="c_price_home<?=$count?>">
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="s_price_home<?=$count?>" id="s_price_home<?=$count?>"  placeholder="Home cut price">
                                    </div>
                                </div>
                                <?php
                                if(admin::getSalonData('type')=='salon'){
                                ?>
                                <div class="col-md-2" id="c_price_salon<?=$count?>">
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="s_price_salon<?=$count?>" id="s_price_salon<?=$count?>"  placeholder="Salon cut price">
                                    </div>
                                </div>
                                <?php
                                }
                                ?>

                

                                <div class="col-md-3" id="duration<?=$count?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="s_duration<?=$count?>" id="s_duration<?=$count?>" placeholder="Duration in Minutes">
                                    </div>
                                </div>                                
                    </div>
                    <hr />
                <?php
                }
                ?>
            </div>

        <?php
        }
        ?>
        
         <div class="form-actions">
            <button id="sub" type="submit" class="btn btn-primary width-150">Update</button>
        </div>

    </form>
<script>

$("#sub").click(function(event) {
       
       var total = $('[id^=c]:checked').length;
      if(total === 0){
          alert("You have to choose at least one service");
          event.preventDefault();
          return fales;
      }
      
   
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



