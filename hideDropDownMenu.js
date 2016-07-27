
// function to hide/show drop-down menus 
$(document).ready(function(){
	// hide the first tissue state 
	$("#tissueState").hide();

	// hide the second library_type options 
	$("#second_library_type").hide();

	// hide the second tissue state
	$("#second_tissueState").hide();

    // hide the third library type
    $("#third_library_type").hide();

    // hide the third tissue state
    $("#third_tissueState").hide();

//----------------------------------------------------------------------------------------------------
	// show the first tissue state ONCE the library_type has been chosen. 
	$('#library_type').change(function(){

    	// show the drop-down menu.
      	$("#tissueState").show();
    });

    // show first question ONCE the first tissue state has been selected 
    $('#tissueState').change(function(){

    	document.getElementById("first_additional_criteria").innerHTML = "Would You Like to Add Additional Criteria";
    	
        // show the options (yes or no)
    	$("#second_library_type").show();

        // show the second tissue state
        $("#second_tissueState").show();

        // if a tissue is selected, ask the user if they want to add additional criteria 
        $('#second_tissueState').change(function(){
                
            document.getElementById("second_additional_criteria").innerHTML = "Would You Like to Add Additional Criteria";
                
            // show the third library type 
            $("#third_library_type").show();
                
            // show the third tissue state
            $("#third_tissueState").show();

        });
    });
});
