// ajax script for getting state data
$(document).on('change','#country', function(){
    var countryID = $(this).val();
    if(countryID){
        $.ajax({
            type:'POST',
            url:'../php/dropdown.php',
            data:{'country_id':countryID},
            success:function(result){
                $('#state').html(result);
               
            }
        }); 
    }else{
        $('#state').html('<option value="">Country</option>');
        $('#city').html('<option value=""> State </option>'); 
    }
});

  // ajax script for getting  city data
 $(document).on('change','#state', function(){
    var stateID = $(this).val();
    if(stateID){
        $.ajax({
            type:'POST',
            url:'../php/dropdown.php',
            data:{'state_id':stateID},
            success:function(result){
                $('#city').html(result);
               
            }
        }); 
    }else{
        $('#city').html('<option value="">City</option>');
        
    }
});