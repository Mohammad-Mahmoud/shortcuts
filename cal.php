<div class="page-content top-90">
    <div class="content">
        

        <div class="ui-field-contain bottom-10">

            <label for="db">Select Date</label>

            <input name="db" type="text" data-mini="true" data-role="datebox" id="db"  />

        </div>
       
        <div id="what">

            
        </div>

        <div class="divider divider-margins bottom-20"></div>

        


    </div>



</div>

<input type="button" value="next" id="next">

<script>
    $("#next").click(function() {

        var val = $("#select-css").val();
        var date = $("#db").val();

        location.replace("add_hour.php?b=<?=$_GET['b']?>&h="+val+"&c=<?=$_GET['c']?>&d=<?=$duration?>&date="+date);
    })

</script>











<div class="menu-hider"></div>