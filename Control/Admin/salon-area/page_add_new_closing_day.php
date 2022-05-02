<div class="margin-bottom-50">
    <h2>Add new closing day / Holiday</h2>
    <div class="form-group row">
            <div class="col-md-7">
                Select date
                <input type="date" id="date" name="date" class="form-control" data-validation-message="This field must not be empty" data-validation="[NOTEMPTY]" placeholder="Name" id="l0" value="<?= admin::getSalonData('name') ?>">
                <button id="select" class="btn btn-primary width-110">Add Selected</button>
            </div>
        </div>
    <form action="home.php?art=add_closing_day" method="post" id="form-validation-simple" name="form-validation-simple" enctype="multipart/form-data">
        

        <div class="my_dates">

        </div>

        <div class="form-actions">
            <button type="submit" id="sub" class="btn btn-primary width-150">Save</button>
            <button  id="cancel" class="btn btn-danger width-150">Cancel</button>
        </div>


        <script>
            $(document).ready(function() {
                var count = 1;
                var dates = [];

                $("#sub").click(function() {
                    
                    if(dates.length === 0) {
                        alert('You did not select any date');
                      
                        return false;
                    }

                });
                $("#cancel").click(function() {
                    
                    location.replace('home.php?art=settings')

                });

                
                $("#select").click(function() {
                    var val = $("#date").val();
                    var in_array = jQuery.inArray(val, dates);

                    if (!val) {
                        alert("Select a date first");
                    } else {
                        if (in_array === -1) {
                            dates.push(val);
                            console.log(dates);
                            $("form").append(" <input type='hidden' name='h" + count + "' value='" + val + "'>");
                            var el = $("<p><span>" + val + "</span><a onclick='' href='#' class='margin-left-5'><i class='left-menu-link-icon icmn-bin'></i></a></p>");
                            $(".my_dates").append(el);
                           
                            el.click(function() {
                                var removeItem = jQuery(this).find("span").html();
                
                                dates = jQuery.grep(dates, function(value) {
                                    return value != removeItem;
                                    
                                });
                                $(this).remove();
                                $('input[value="'+removeItem+'"]').remove();                                
                            });
                            count++;
                        } else {
                            alert("this date already selected");
                        }
                    }
                })

                
            });
        </script>

    </form>

</div>

<script>
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("date")[0].setAttribute('min', today);
</script>

<script>
    
</script>




<script>
    
</script>
