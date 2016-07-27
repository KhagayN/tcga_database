<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="http://www.med.nyu.edu/school/sites/all/themes/nyulmc/favicon.ico" type='image/x-icon' />
    <title> Home Page </title>
    <style>		
	table, th, td 
	{
	   border: 1px solid black;
	}
	body {
 	   padding:0;
	   margin:0;
	}

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
    <script src="hideDropDownMenu.js"></script>

    
</head>
	<body>
	    <div id="nyu_logo">
	    	<img src="NYU logo.png" border="0">
	    </div>
	    
	    <?php
		# connect to database
	        include 'db_connection_kirchhoff.php';
	    	
	    	if(!($stmt = $dbh -> prepare("SELECT count(*) as patientsWithMatchedData 
	                                          FROM tcgaDatabase 
	                                          where disease_name = ? and
	                                          library_type = ? and 
	                                          sample_type = ?
	                                          ")))  {
	                // just in case the prepared statement failed 
	                echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
	            }
	                                          
	         # create variables to be used for the prepared query
	         $disease_name_skcm = "Skin Cutaneous Melanoma";
	         $disease_name_breast = "Breast Invasive Carcinoma";
	         $disease_name_colon = "Colon adenocarcinoma";
	         $library_type_wgs = "WGS";
	         $library_type_wxs = "WXS";
	         $library_type_rnaseq = "RNA-Seq";
	         $sample_type_normal = "NT";
	         $sample_type_tumor = "TP";
	         $sample_type_metastatic = "TM"; 
	         
	        # execute the query - first bind variables to it.
	        $stmt -> execute(array($disease_name_skcm , $library_type_wgs , $sample_type_normal));
	        
	        # save the result 
	        while ($row = $stmt->fetch()) {
	    		$skcmWGSNormal=$row["patientsWithMatchedData"];
	      	}  
	/*
		#--------------------------------------------------------------------------------------------------------------------------------
	      	# prepare query to count SKCM WGS metastatic patients ------------------------------
		
		$stmt = $dbh->prepare("SELECT count(*) as patientCount 
	                                      FROM tcgaDatabase 
	                                      where disease_name = ? and
	                                      library_type = ? and
	                                      sample_type = ?
	                                     ");
	        
	         # execute the query 
	    	$stmt->execute(array($disease_name_skcm , $library_type_wgs , $sample_type_metastatic));
	        
	        # save the result
	        while ($row = $stmt->fetch()) {
	    		$skcmWGSMetastatic=$row["patientCount"];
	      	} 
	*/
	      	#--------------------------------------------------------------------------------------------------------------------------------
	      	# prepare query to count SKCM WGS tumor patients ------------------------------
	
		$stmt = $dbh->prepare("SELECT count(*) as patientCount 
	                                      FROM tcgaDatabase 
	                                      where disease_name = ? and
	                                      library_type = ? and
	                                      sample_type = ?
	                                     ");
	        
	         # execute the query 
	    	$stmt->execute(array($disease_name_skcm , $library_type_wgs , $sample_type_tumor));
	        
	        while ($row = $stmt->fetch()) {
	    		$skcmWGSTumor=$row["patientCount"];
	      	} 
	      	
	      	
	    	#--------------------------------------------------------------------------------------------------------------------------------
	    	
		# prepare query to count SKCM RNA-Seq normal patients ------------------------------
		if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                             FROM tcgaDatabase 
                                             WHERE disease_name = ? and
                                                   library_type = ? and 
                                                   sample_type = ?
                                            "))) {
                // just in case the prepared statement failed 
                echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_skcm , $library_type_rnaseq , $sample_type_normal))){
                echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}   
            	
            	while ($row = $stmt->fetch()) {
	    		$skcmRNASEQNormal = $row["patientCount"];
	      	}  	
	      	
	      	#--------------------------------------------------------------------------------------------------------------------------------
	      	
	      	# prepare query to count SKCM RNA-Seq tumor patients ------------------------------  
		if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                             FROM tcgaDatabase 
                                             WHERE disease_name = ? and
                                             library_type = ? and 
                                             sample_type = ?
                                            "))) 
                        {
                                            
		                // just in case the prepared statement failed 
		                echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh>errorInfo;
	        	}
    	
    		 # execute the query 
    		if(!$stmt->execute(array($disease_name_skcm , $library_type_rnaseq , $sample_type_tumor)))
    		{
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$skcmRNASEQTumor = $row["patientCount"];
	      	}  	
            
            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count SKCM Whole Exome Sequences normal patients ------------------------------

			if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                          FROM tcgaDatabase 
                                          where disease_name = ? and
                                          library_type = ? and 
                                          sample_type = ?
                                          "))) {
                // just in case the prepared statement failed 
                echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_skcm , $library_type_wxs , $sample_type_normal)))
    		{
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$skcmWXSNormal = $row["patientCount"];
	      	}  	

    	
    		#--------------------------------------------------------------------------------------------------------------------------------
    		
    		# prepare query to count SKCM Whole Exome Sequences tumor patients 

		if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              WHERE disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                          "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_skcm , $library_type_wxs , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->erroCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$skcmWXSTumor = $row["patientCount"];
	      	}  	

            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	# prepare query to count the number of patients that have provided their normal breast invasive carcinoma whole genome sequences
            	
		if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              WHERE disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                          "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_breast , $library_type_wgs , $sample_type_normal))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$breastWGSNormal = $row["patientCount"];
	      	}  	

            	
            	#--------------------------------------------------------------------------------------------------------------------------------
    		# prepare query to count the number of patients that have provided their normal breast invasive carcinoma rna-seq sequence
    		
		if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                          FROM tcgaDatabase 
                                          where disease_name = ? and
                                          library_type = ? and 
                                          sample_type = ?
                                          "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	 # execute the query 
    		if(!$stmt->execute(array($disease_name_breast , $library_type_wgs , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$breastWGSTumor = $row["patientCount"];
	      	}  	

            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal whole genome sequence patients with breast invasive carcinoma 
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_breast , $library_type_wxs , $sample_type_normal))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$breastWXSNormal = $row["patientCount"];
	      	}  	

            	
              	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of tumor whole genome sequence patients with breast invasive carcinoma 
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_breast , $library_type_wxs , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$breastWXSTumor = $row["patientCount"];
	      	}  	

            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal rna-seq patients with breast invasive carcinoma 
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_breast , $library_type_rnaseq , $sample_type_normal))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$breastRNASEQNormal = $row["patientCount"];
	      	}  	

            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of tumor rna-seq patients with breast invasive carcinoma 
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_breast , $library_type_rnaseq , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$breastRNASEQTumor = $row["patientCount"];
	      	}  	
        

            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal rna-seq patients with colon adenocarcinoma
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_colon , $library_type_wgs , $sample_type_normal))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$colonWGSNormal = $row["patientCount"];
	      	}  	
          	 
            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of tumor wgs patients with colon adenocarcinoma
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_colon , $library_type_wgs , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$colonWGSTumor = $row["patientCount"];
	      	}  	
      
            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal whole exome sequences patients with colon adenocarcinoma
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_colon , $library_type_wxs , $sample_type_normal))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$colonWXSNormal = $row["patientCount"];
	      	}  	

            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal whole exome sequences patients with colon adenocarcinoma
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_colon , $library_type_wxs , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$colonWXSTumor = $row["patientCount"];
	      	}  	
      
            	
            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal whole exome sequences patients with colon adenocarcinoma
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_colon , $library_type_rnaseq , $sample_type_normal))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$colonRNASEQNormal = $row["patientCount"];
	      	}  	
       
            	
            	            	#--------------------------------------------------------------------------------------------------------------------------------
            	
            	# prepare query to count the number of normal whole exome sequences patients with colon adenocarcinoma
            	if (!($stmt = $dbh->prepare("SELECT count(*) as patientCount 
                                              FROM tcgaDatabase 
                                              where disease_name = ? and
                                              library_type = ? and 
                                              sample_type = ?
                                             "))) {
                // just in case the prepared statement failed 
                	echo "Prepared Statement failed: (" . $dbh->errorCode . ")" . $dbh->errorInfo;
            	}
            	
            	# execute the query 
    		if(!$stmt->execute(array($disease_name_colon , $library_type_rnaseq , $sample_type_tumor))){
                	echo "Execution failed: (" . $stmt->errorCode . ")" . $stmt->errorInfo;
            	}
            	
            	while ($row = $stmt->fetch()) {
	    		$colonRNASEQTumor = $row["patientCount"];
	      	}  	
   
            	
            	echo '<p><font face = "Gotham Book">';
    		#-------------------------- Create Table with the Results --------------------------
    		echo '<div style="font:20pxGotham Book">
    		<center> <h1>The Number of Patients That TCGA Has Is Shown Below</h1>';
    		echo '<table "width:100%">';
    		# header 
    		echo '<tr>';
    		echo '<td>    </td>';
   		echo '<td> WGS </td>';
   		echo '<td> RNA-Seq </td>';
    		echo '<td> WXS </td>';
   		echo '</tr>';

    		# counts of normal skin cutaneous patients 
    		echo '<tr>';
    		echo '<td> Skin Cutaneous Melanoma <b> Normal </b> </td>'; 
    		echo '<td> '.$skcmWGSNormal.' </td>';
    		echo '<td> '.$skcmRNASEQNormal.' </td>';
    		echo '<td> '.$skcmWXSNormal.' </td>';
    		echo '</tr>';

    		# counts of tumor skin cutaneous patients 
    		echo '<tr>';
    		echo '<td> Skin Cutaneous Melanoma <b> Tumor </b> </td>';
    		echo '<td> '.$skcmWGSTumor.' </td>';
    		echo '<td> '.$skcmRNASEQTumor.' </td>';
    		echo '<td> '.$skcmWXSTumor.' </td>';
    		echo '</tr>';

    		# counts of normal breast patients 
    		echo '<tr>';
    		echo '<td> Breast <b> Normal </b> </td>';
    		echo '<td> '.$breastWGSNormal.' </td>';
    		echo '<td> '.$breastRNASEQNormal.' </td>';
    		echo '<td> '.$breastWXSNormal.' </td>';
    		echo '</tr>';

    		# counts of tumor breast patients 
    		echo '<tr>';
    		echo '<td> Breast <b> Tumor </b> </td>';
    		echo '<td> '.$breastWGSTumor.' </td>';
    		echo '<td> '.$breastRNASEQTumor.' </td>';
    		echo '<td> '.$breastWXSTumor.' </td>';
    		echo '</tr>';

    		#counts of normal colon patients
    		echo '<tr>';
    		echo '<td> Colon <b> Normal </b> </td>';
    		echo '<td> '.$colonWGSNormal.' </td>';
    		echo '<td> '.$colonRNASEQNormal.' </td>';
    		echo '<td> '.$colonWXSNormal.' </td>';
    		echo '</tr>';

    		#counts of tumor colon patients
    		echo '<tr>';
    		echo '<td> Colon <b> Tumor </b> </td>';
    		echo '<td> '.$colonWGSTumor.' </td>';
    		echo '<td> '.$colonRNASEQTumor.' </td>';
    		echo '<td> '.$colonWXSTumor.' </td>';
    		echo '</tr>';

    		echo '</table></center>';
		?>

	    <!-- form that outputs the number of matched normal and tumor patients
	    for a particular cancer and a particular type of data (e.g. whole genome, rna, rna-seq, etc.)!-->
	    
	    <h4><center>What Type of Cancer Are You Interested In? </center></h4> 
	    <!-- select the cancer !-->
	    <center>
	    <form action="matchedPatients.php" method="POST">
	      <select name="disease_name">
	        <option value="Breast Invasive Carcinoma">Breast Invasive Carcinoma</option>
	        <option value="Colon adenocarcinoma">Colon adenocarcinoma</option>
	        <option value="Skin Cutaneous Melanoma">Skin Cutaneous Melanoma</option>
	        <option value="Pancreatic adenocarcinoma">Pancreatic adenocarcinoma</option>
	      </select>
	
	      <!-- select the type of data !-->
	      <h4>And What Type of Data Are You Focusing On?</h4>
	        <select name="library_type" id="library_type">
	          <option value="" selected> </option>
	          <option value="WGS"> Whole Genome Sequences</option>
	          <option value="WXS">Whole Exome Sequences</option>
	          <option value="RNA-Seq">RNA-Seq</option>
	
	        </select>
	        
	        <!-- Drop-down menu for type of tissue !-->
	        <select name="tissueState" id="tissueState">
	          <option value="" selected> </option>
	          <option value = "NT"> Normal </option>  
	          <option value = "TP"> Tumor </option>
	          <option value = "Both"> Both </option>
	        </select>
	
	        <!-- Ask user if they want to add additional criteria.  !-->
	        <b><p id="first_additional_criteria"></p></b>
	
	        <!-- Drop-down menu for other options !-->
	        <select name="second_library_type" id="second_library_type">
	          <option value="no"> Not At This Time</option>
	          <option value="WGS"> Whole Genome Sequences</option>
	          <option value="WXS">Whole Exome Sequences</option>
	          <option value="RNA-Seq">RNA-Seq</option>
	        </select>
	        
	        <!-- Drop-down menu for type of tissue!-->
	        <select name="second_tissueState" id="second_tissueState">
	          <option value="" selected> </option>
	          <option value = "NT" > Normal </option>
	          <option value = "TP"> Tumor </option>
	        </select>
	
	      <p id="useranswer"></p>
	      
	      <b><p id="second_additional_criteria"></p></b>
	      
	      <!-- drop-down menu for third library type !-->  
	      <select name="third_library_type" id="third_library_type">
	          <option value="no" > Not At This Time</option>
	          <option value="WGS"> Whole Genome Sequences</option>
	          <option value="WXS">Whole Exome Sequences</option>
	          <option value="RNA-Seq">RNA-Seq</option>
	        </select>
	    
	      <!-- drop-down menu for third tissue state !-->
	        <select name="third_tissueState" id="third_tissueState">
	          <option value="" selected> </option>
	          <option value = "NT" > Normal </option>
	          <option value = "TP"> Tumor </option>
	        </select>
	
	      <br><br>
	      <input type="submit" value="Show Results">
	
	    </form></center>         
	    <br><br><br>
	    <div style="background-color:grey;width:1700px;height:250px;border:1px solid #000">
	    	
	    </div>
	    
	</body>
</html>