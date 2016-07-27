<!DOCTYPE html>
<html>
<head>
	<title> Counting Particular Cancers </title>
     <style>
          body {
 	       padding:0;
	       margin:0;
	  }
     </style>
</head>
<body>
	 
    <!-- Offer a download option  !-->
    <div id="nyu_logo">
        <img src="NYU logo.png" border="0">
    </div>
    <?php

        # connect to database. Queries are made below
	include 'db_connection_kirchhoff.php';

	# save the user selected cancer, used for the query 
	$disease_name = $_POST["disease_name"];
	# save the user selected type of data 
	$library_type = $_POST["library_type"];
    	
    	# save the first tissue stae that the user selected
    	$first_tissueState = $_POST["tissueState"];

        # save the second library_type
        $second_library_type = $_POST["second_library_type"];

        # save the second tissue state, if and only if there is a second library type
        if($second_library_type != "no"){
            $second_tissueState = $_POST["second_tissueState"];
      
        # based on the second tissue state chosen, save the second condition accordingly
        if($second_tissueState == "NT"){
            $second_conditionFullName = "Normal";
        }
      
        elseif($second_tissueState == "TP"){
          $second_conditionFullName = "Tumor";
        }

            # if you are in this loop, that means you MAY have chosen a third library type - test for that
            $third_library_type = $_POST["third_library_type"];
      
            if($third_library_type != "no"){

                # based on the third tissue state chosen, save the third condition accordingly
                # first get the third tissue state
                $third_tissueState = $_POST["third_tissueState"];

                if($third_tissueState == "NT"){
                    $third_conditionFullName = "Normal";
                }
	        
	        elseif($third_tissueState == "TP"){
	            $third_conditionFullName = "Tumor";
	        }
            }
        }

        if($first_tissueState == "NT")
        {
            $conditionFullName = "Normal";
        }
    
        elseif($first_tissueState == "TP"){
            $conditionFullName = "Tumor";
        }


        #-------------------------------------------------------------------------------------------------
        # if the condition is normal or tumor, filter the results accordingly 
        if(($first_tissueState == "NT") || ($first_tissueState == "TP")){

            if($second_library_type == "no")
            {

                # because there is only one library type, the table to search is a concatenation 
                # of the disease name and library type. 

                $table = $disease_name . ' ' . $library_type . ' ' . $first_tissueState;

	        #-----------------------------------------------------------------------------------------------------------------------------
                # number of patients that fit the criteria 
                if (!($stmt = $dbh->prepare("SELECT count(*) as numberOfpatients
                                          FROM `$table`
                                          where disease_name = ? and
                                          library_type = ? and 
                                          sample_type = ?
                                          "))) {
                // just in case the prepared statement failed 
                    echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
        	}		   

	        # execute the query 
	        if(!$stmt->execute(array($disease_name , $library_type, $first_tissueState))){
	            echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
	        }
	
	 	# save the result 
		while ($row = $stmt->fetch()) 
		{
    		    # echo results 
	            echo '<center><h1> The Number of '.$disease_name.' Patients with  <br>
	        	'.$conditionFullName.' '.$library_type.' is '.$row["numberOfpatients"].'</center></h1>';
	        }
	        		      	
	        #-----------------------------------------------------------------------------------------------------------------------------
	        # show the patients ID
	        if (!($stmt = $dbh->prepare("SELECT distinct *
                                          FROM `$table` 
                                          where disease_name = ? and
                                          library_type = ? and 
                                          sample_type = ?
                                          "))) {
	        // just in case the prepared statement failed 
	          echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
	        }           	
        
                # execute the query 
                if(!$stmt->execute(array($disease_name , $library_type, $first_tissueState)))
                {
                    echo "Execution failed: (" . $stmt->errno . ")" . $stmt->error;
                }
        
        	## script that'll select all checkboxes. 
                    	
                echo "<script type='text/javascript'>
                	function checkAll(tcgaForm)
                    	{
                    		if(tcgaForm.everything.checked) 
                    		{
                    			//console.log(tcgaForm);
                    			//console.log(tcgaForm.elements['analysis_id[]'][0]); 
                    			
                    			for(i = 0; i < tcgaForm.elements['analysis_id[]'].length; i++ )
                    			{
                    				
                    				tcgaForm.elements['analysis_id[]'][i].checked = true;
                    				
                    			}
                    		}
                    	}
                    	</script>";
        
                # create a form and a header of a table for the results.
                echo '<center>';    
                echo "<form action='cgHubDownload.php' method='POST'>";
                echo '<table border="1">';
                    echo '<tr>';
                        echo "<td><input type='checkbox' onClick='checkAll(this.form)' name='everything'>  Select All </td>";
		        echo '<td> Analysis_id </td>';
              		echo '<td> File Size </td>';
              		echo '<td> Cancer Genomics Hub Link </center></td>';
            	    echo '</tr>';

                # output the results. 
	        while ($row = $stmt->fetch()) 
	        {
	            
	            echo '<tr>';
              	    
              	    ## save the analysis_id so it can be sent over to the form. 
              	    $analysis_id = $row["analysis_id"];
              	    
              	    ## save the barcode_id so it can be sent over to the form. 
              	    $barcode_id = $row["barcode"];
              	    
              	    echo "<td> <input type='checkbox' name='analysis_id[]' value='$analysis_id'> </td>";
              	    
              	    ##echo "<td> <input type='checkbox' name='barcode_id' value='$barcode_id'> </td>";
              	    
                    echo '<td>' .$row["analysis_id"]. '</td>';
            	    echo '<td> '.$row["files_size"].' </td>';
            	    
            	    $link = "https://browser.cghub.ucsc.edu/search/?study=(phs000178+OR+*Other_Sequencing_Multiisolate)&state=(live)&q=" . $row["analysis_id"];

            	    echo "<td> <a target='_blank' href='$link'>" . $row["analysis_id"] ." </td>";
            	    
                }
          
                # close table
                echo '</table>';
                echo "<input type='submit' value='Create File'>";
                echo "</form>";
                echo '</center>';
            } # closes if second library type == no 
      
            # if the second library type does not equal "no", filter the results for the second library type
            else if($second_library_type != "no"){
        
                # if the third library type is "not at this moment" 
                if($third_library_type == "no"){

                    # specify the table names that should be searched on.
                    $table1 = $disease_name . ' ' . $library_type . ' ' . $first_tissueState;
                    $table2 = $disease_name . ' ' . $second_library_type . ' ' . $second_tissueState;

                    # number of patients that fit the criteria 
                    if (!($stmt = $dbh->prepare("SELECT count(distinct participant_id) as numberOfpatients
                                            FROM `$table1` 
                                            where disease_name = ? and
                                            library_type = ? and 
                                            sample_type = ? and participant_id in 
                                                              (select distinct participant_id
                                                              from `$table2`
                                                              where disease_name = ? and 
                                                              library_type = ? and 
                                                              sample_type = ?)
                                            "))) {
                      // just in case the prepared statement failed 
                      echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
                    } 
               
                    # execute the query 
          	    if(!$stmt->execute(array($disease_name , $library_type, $first_tissueState,
                                         $disease_name , $second_library_type , 
                                         $second_tissueState))){
                        echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
          	    }
          	
          	
          	    while ($row = $stmt->fetch()) 
	    	    {
          	       # echo results 
          	        echo '<center><h1> The Number of '.$disease_name.' Patients that have <b>both</b> <br>
          	            '.$conditionFullName.' '.$library_type.' and '.$second_conditionFullName.' 
          	            '.$second_library_type.' is '.$row["numberOfpatients"].'</center></h1>';
          	    }
          	    
          	    #-------------------------------------------------------------------------------------
          	    # show the patients ID
                    if (!($stmt = $dbh->prepare("SELECT *
                                            FROM `$table1`
                                            where disease_name = ? and
                                            library_type = ? and 
                                            sample_type = ? and 
                                            participant_id in(select distinct participant_id
                                                              from `$table2`
                                                              where disease_name = ? and 
                                                              library_type = ? and 
                                                              sample_type = ?)
                                            "))) {
                        // just in case the prepared statement failed 
            		echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
          	    }
          	    
          	    # execute the query 
           	    if(!$stmt->execute(array($disease_name , $library_type, $first_tissueState, 
                                             $disease_name , $second_library_type, 
                                             $second_tissueState)))
                    {
            	        echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
          	    }
          	    
          	     # create a table of the results 
            	    echo '<center>';
                    echo '<table border="1">';
                    echo '<tr>';
                	##echo '<td> <center>Participant_id </td>';
                	echo '<td> Analysis_id </td>';
                	##echo '<td> File Name </td>';
                	echo '<td> File Size </center></td>';
              	    echo '</tr>'; 
              	    
              	    # fetch the results 
              	    while ($row = $stmt->fetch()) 
	    	    {
              	        echo '<tr>';
              		## echo '<td> '.$row["participant_id"].' </td>';
              
              		echo '<td> '.$row["analysis_id"].' </td>';
          
              	 	##echo '<td> '.$row["filename"].' </td>';

              		echo '<td> '.$row["files_size"].' </td>';
              	    }
              	    
              	    # close table
         	    echo '</table>';
                    echo '</center>';
                    
                   } # closes if third library type == no 
               
      
      	       
                # if the third library type has been chosen, do the appropriate query.
                elseif($third_library_type != "no"){

                    # specify tables to search on
                    $table1 = $disease_name . ' ' . $library_type . ' ' . $first_tissueState;
                    $table2 = $disease_name . ' ' . $second_library_type . ' ' . $second_tissueState;
                    $table3 = $disease_name . ' ' . $third_library_type . ' ' . $third_tissueState;

                    # if a third library type is provided, filter the data accordingly 
                    # number of patients that fit the criteria 
                    if (!($stmt = $dbh->prepare("SELECT count(distinct participant_id) as numberOfpatients
                                            from `$table1`
                                            where disease_name = ? and 
                                            library_type = ? and 
                                            sample_type = ? and 
                                            participant_id in (
                                                  select distinct participant_id
                                                  FROM `$table2` 
                                                  where disease_name = ? and
                                                  library_type = ? and 
                                                  sample_type = ? and participant_id in 
                                                                (select distinct participant_id
                                                                from `$table3`
                                                                where disease_name = ? and 
                                                                library_type = ? and 
                                                                sample_type = ?))
                                            "))) {
                     // just in case the prepared statement failed 
                        echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
                    }   
          
      
      	        } # close if third library type != no 
     
              
            } # closes if second library type != no 
        } # close the if first tissue state is normal or tumor 
    ?>
    
</body>
</html>
 