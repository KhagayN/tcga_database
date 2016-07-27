<!DOCTYPE html>
<html>
<head>
	<title> Download Page </title>
	<style>
          body {
 	       padding:0;
	       margin:0;
	  }
     	</style>
</head>

<body>
	<div id="nyu_logo">
        	<img src="NYU logo.png" border="0">
    	</div>
	<?php
		## create a file that'll store the analysis ids. The file will be uploaded to Cancer Genomics Hub (CGHub).
		$analysisIdFile = fopen("analysisIDs.txt", "w");
		
		## for each ID selected, write their analysis ID it to newly created file. 
		foreach ($_POST['analysis_id'] as $id) {
			$analysis_id = substr($id, 0, 36);
			fwrite($analysisIdFile, $analysis_id);
			fwrite($analysisIdFile, "\r\n");
		}
		fclose($analysisIdFile);
		
		## for each ID selected, create a file that stores their barcode and a breakdown of it. 
		/*
		$barcodeIdFile = fopen("barcodeIDs.tsv", "w");
		
		## create header.
		fwrite($barcodeIdFile, "Participant ID");
		fwrite($barcodeIdFile, "\t");
		fwrite($barcodeIdFile, "Remaining Barcode");
		fwrite($barcodeIdFile, "\t");
		fwrite($barcodeIdFile, "Analysis ID");
		fwrite($barcodeIdFile, "\t");
		fwrite($barcodeIdFile, "File");
		fwrite($barcodeIdFile, "\r\n");
		
		foreach($_POST['barcode_id'] as $id) {
			## subset to participant portion of the barcode.
			$participant_id = substr($id, 36, 12);
			
			## return barcode section for normal sample.
			$remaining_id = substr($id, 14, 28);
			
			fwrite($barcodeIdFile, $participant_id);
			fwrite($barcodeIdFile, "\t");
			fwrite($barcodeIdFile, $remaining_id);
			fwrite($barcodeIdFile, "\r\n");
			
		}
		fclose($barcodeIdFile);
		*/
		echo '<a href="analysisIDs.txt" download>Download Analysis ID File</a>';
		echo '<br>';
		
		##echo '<a href="barcodeIDs.tsv" download> Download Barcode ID File</a>';
		
	?>
</body>
</html>