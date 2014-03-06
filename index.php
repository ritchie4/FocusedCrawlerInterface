<?php 
date_default_timezone_set("UTC"); 

$path = "C:\Users\Tyler\Documents\StuffYouDontTouch\Classes\2014 (senior spring)\CS 4624\project\ProjFocusedCrawler-master\src\\";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			Focused Event Crawler
		</title>
        
		<link href="includes/style.css" rel="stylesheet" type="text/css" />
	    <script src="includes/jquery-1.11.0.js" type="text/javascript"></script>
	    <script src="includes/main.js" type="text/javascript"></script>
		
	</head>
	<body>
	
		<!-- Input -->
		<div style="border:1px solid #BBA6FF;width:950px;margin-left:165px;padding:15px 15px 15px 15px;">
		<h2 style="margin:0">Focused Event Crawler</h2><br />
		Give as much information as you know about the URL's.<br /><br />
		<form id="inputForm" method="post">
            <div id="siteUrls">
				<div id="siteDetailsContainer">
				</div>
			</div>
			<input type="button" id="addInput" name="add" value="+ URL Entry">
			<input type="submit" name="submit" value="Submit Entries" class="submitButton">
			<input type="reset" name="clear" value="Clear Fields" id="clearURLFields">
			
		</form> 
		
		<!-- Results -->
		</div>
		<div style="border:1px solid #BBA6FF;width:950px;margin-left:165px;margin-top:10px;padding:15px 15px 15px 15px;">
		<input type="button" name="clear" value="Clear Results" id="clearResults" style="float:right">
		<h2 style="margin:0">Results</h2><br />
			<div id="resultHolder">
				<div id="topHere"></div>
				<div class="noSubmissionsLabel">There have been no current submissions.</div>
			</div>
		</div>
		<div class="treeComparisonBackground"></div>
		<div class="treeComparisonWindow">
		</div>
		
	<script type="text/javascript">
		$(document).ready(function(){
			$("#resultHolder").delegate(".comparisonButton","click",function(){
				var treeURL = $(this).parent()[0].previousSibling.nodeValue;
				
				var eventTypeText = "";
				var nameFieldText = "";
				var countryFieldText = "";
				var stateFieldText = "";
				var cityFieldText = "";
				var yearFieldText = "";
				var monthFieldText = "";
				var dayFieldText = "";
				
				$.get('src/last-run-trees.txt', function(myContentFile) {
					var lines = myContentFile.split("\r\n");
					for(var i in lines){
						var fields = lines[i].split("|");
						
						// Grab fields from textfile once we have found the matched URL
						if(fields[0] == treeURL){
							eventTypeText = fields[1];
							nameFieldText = fields[2];
							countryFieldText = fields[3];
							stateFieldText = fields[4];
							cityFieldText = fields[5];
							yearFieldText = fields[6];
							monthFieldText = fields[7];
							dayFieldText = fields[8];
							window.open('JSTest/index.php?eventType='+eventTypeText+'&eventName='+nameFieldText+
								'&countryField='+countryFieldText+'&stateField='+stateFieldText+'&cityField='+cityFieldText+
								'&monthField='+monthFieldText+'&yearField='+yearFieldText+'&dayField='+dayFieldText);
							break;
						}
					}
				}, 'text');
			});
			$("#resultHolder").delegate(".comparisonButtonLink","click",function(){
				var treeURL = $(this).parent().prev().text();
				var eventTypeText = "";
				var nameFieldText = "";
				var countryFieldText = "";
				var stateFieldText = "";
				var cityFieldText = "";
				var yearFieldText = "";
				var monthFieldText = "";
				var dayFieldText = "";
				
				$.get('src/last-run-trees.txt', function(myContentFile) {
					var lines = myContentFile.split("\r\n");
					for(var i in lines){
						var fields = lines[i].split("|");
						
						// Grab fields from textfile once we have found the matched URL
						if(fields[0] == treeURL){
							eventTypeText = fields[1];
							nameFieldText = fields[2];
							countryFieldText = fields[3];
							stateFieldText = fields[4];
							cityFieldText = fields[5];
							yearFieldText = fields[6];
							monthFieldText = fields[7];
							dayFieldText = fields[8];
							window.open('JSTest/index.php?eventType='+eventTypeText+'&eventName='+nameFieldText+
								'&countryField='+countryFieldText+'&stateField='+stateFieldText+'&cityField='+cityFieldText+
								'&monthField='+monthFieldText+'&yearField='+yearFieldText+'&dayField='+dayFieldText);
							break;
						}
					}
				}, 'text');
			});
		});
	</script>
	</body>
</html>




