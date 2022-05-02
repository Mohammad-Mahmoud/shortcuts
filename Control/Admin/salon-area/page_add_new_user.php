<?php
$query = new query();

$services = $query->fetchAssoc("select * from services");

$ser_count = query::numRows("select * from services");

?>
<div class="margin-bottom-50">
    <h2>Add New Barber</h2>
    <form action="home.php?art=add_user" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-9">
                <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="name" placeholder="First Name" id="l0">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-9">
                <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="email" placeholder="Email" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="phone" placeholder="Phone" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Birthdate<input type="date" class="form-control" name="birthday" placeholder="Birthdate" id="l0">
            </div>
        </div>
        

        <div class="form-group row">
            <div class="col-md-9">
                <input type="text" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" name="address" placeholder="Address" id="l0">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9">
                Description
                <textarea class="summernote" name="info" placeholder="Description" id="l0"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="l30">Profile image</label>
            <input type="file" class="form-control" name="Filedata" id="l30" data-validation-message="You didn't choose any file" accept="image/*" data-validation="[NOTEMPTY]">
            <label id="status"></label>
        </div>

        <div class="margin-bottom-50">
            Services

            <div class="form-group">
                <br>
                <?php
                $count = 0;
                while ($row = $services->fetch_assoc()) {
                    $count++;
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
                            }            
                        });

                        $("#s<?=$count?>").click(function() {

                            $("#price_home<?=$count?>").css("display","none");
                            $("#price_salon<?=$count?>").css("display","block");
                            $('#price_home<?=$count?>').removeAttr("data-validation-message");
                            $('#price_home<?=$count?>').removeAttr("data-validation");
                            $('#price_salon<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#price_salon<?=$count?>').attr("data-validation", "[INTEGER, V>0]");

                        });
                        $("#h<?=$count?>").click(function() {

                            $("#price_home<?=$count?>").css("display","block");
                            $("#price_salon<?=$count?>").css("display","none");
                            $('#price_salon<?=$count?>').removeAttr("data-validation-message");
                            $('#price_salon <?=$count?>').removeAttr("data-validation");
                            $('#price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");

                        });
                        $("#b<?=$count?>").click(function() {
                            $("#price_salon<?=$count?>").css("display","block");
                            $("#price_home<?=$count?>").css("display","block");

                            $('#price_home<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#price_home<?=$count?>').attr("data-validation", "[INTEGER, V>0]");
                            $('#price_salon<?=$count?>').attr("data-validation-message", "Only numbers grater than 0");
                            $('#price_salon<?=$count?>').attr("data-validation", "[INTEGER, V>0]");

                        });

                    });
                </script>
                    <div class="row">
                        <div class="col-md-2" id="check">
                            <input type="checkbox" id="c<?= $count ?>" name="c<?= $count ?>" value="<?=$row['service_id']?>">
                            <?= $row['name'] ?>
                        </div>
                        <div id="r<?=$count?>" style="display:none;">
                            <div class="col-md-2">
                                <input type="radio" id="s<?=$count?>" name="ser<?= $count ?>" value="salon" >
                                Just salon service
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="h<?=$count?>" name="ser<?= $count ?>" value="home">
                                Just home service
                            </div>
                            <div class="col-md-2">
                                <input type="radio" id="b<?=$count?>" name="ser<?= $count ?>" value="both" checked>
                                both
                            </div>
                            
                        </div>
                    </div>
                    <div class="row" id="t<?=$count?>" style="display:none;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="price_home<?=$count?>" id="price_home<?=$count?>"  placeholder="Home cut price">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="price_salon<?=$count?>" id="price_salon<?=$count?>"  placeholder="Salon cut price">
                                    </div>
                                </div>
                                

                                <div class="col-md-3" id="dur<?=$count?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="duration<?=$count?>" id="duration<?=$count?>" placeholder="Duration in Minutes">
                                    </div>
                                </div>                                
                    </div>
                    <hr />
                <?php
                }
                ?>
            </div>


        </div>

        <div class="form-actions">
            <button id="sub" type="submit" class="btn btn-primary width-150">Add</button>
        </div>
    </form>

<script>
    $("#sub").click(function() {
       
        var total = $('[id^=c]:checked').length;

        
       if(total === 0){
           alert("You have to choose at least one service");
           //event.preventDefault();
        return false;
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


</div>




<script>
    $(function() {
        $('.summernote').summernote({
            height: 200
        });
    });
</script>

