<?php

	$urlList = $_POST["urlInput"];
	$eventDetails = $_POST["detailInput"];
	$pageLimit = $_POST["pageLimit"];
	$crawlerField = $_POST["crawlField"];
	
	$file = 'src/event-details.txt';
	file_put_contents($file, $eventDetails); // \r\n because of Windows Notepad

	// Event-based, Default
	$f = 'src/addurls.txt';
	file_put_contents($f, $urlList);
	exec('"C:\Python27\python.exe" src/FocusedCrawler.py '.$crawlerField.' "'.$f.'" '.$pageLimit.'', $output);
	
	echo '<span style="display:none">|'.$_POST["id"].'|</span>';
	echo "<br />";
	
	// Begin grabbing specific URL output fields from array generated from Python output
	
	// Grab URL output, removing beginning and ending junk
	$added_urls = substr($output[3], 2);
	$added_urls = substr($added_urls, 0, strlen($added_urls)-2);
	$added_array = explode("', '",$added_urls);
	$used_urls = "";
	$all_urls_good = true;

	$urlArr = explode(" ", $added_array[0]);
	
	foreach ($urlArr as $u){
		if($u != ""){
			$file_headers = @get_headers($u);
			//echo "<script type=\"text/javascript\">alert(\"".$file_headers[0]."\");</script>";
			if($file_headers[0] == 'HTTP/1.0 404 Not Found') {
				$all_urls_good = false;
				$used_urls .= 'The URL "'.$u.'" is not valid.<br />';
			}
			else {
				if($all_urls_good){
					$used_urls .= $u;
					if($crawlerField == 1){
						$used_urls .= '<div class="treeComparisonButton"><input type="button" class="comparisonButton" value="View Tree"></div><br />';
					}
				}
			}
		}
	}
	
	if($all_urls_good){
		// Grab relevant URL's output beginning with the unique URL's.
		$relevant_urls = "";
		// Begin reading after the gap of repeated URL's, which is the size of $added_array
		// Since each URL has 2 scores ahead of it, take just the URL by taking the 3rd item via explode
		for($i = 6+sizeof($added_array); $i < sizeof($output)-2; $i++){
			$raw_url = explode(",",$output[$i])[2];
			$trunc_url = (strlen($raw_url) > 93) ? substr($raw_url,0,90).'...' : $raw_url;
			$relevant_urls .= '<a href="'.$raw_url.'" target="_blank">'.$trunc_url.'</a>';
			if($crawlerField == 1){
				$relevant_urls .= '<div class="treeComparisonButtonLink"><input type="button" class="comparisonButtonLink" value="View Tree"></div><br />';
			}
		}

		// Grab score from last 2 elements in output
		$relevant_articles = $output[sizeof($output)-2];
		$total_articles = $output[sizeof($output)-1];
		
		echo 'Entered URLs:<br /><div style="margin-left:15px;">'.$used_urls.'</div>';
		if($relevant_urls != ""){
			echo 'Found unique relevant URLs:<br /><div style="margin-left:15px;">'.$relevant_urls.'</div>';
		}
		else {
			echo 'No further unique relevant URLs found.<br />';
		}
		echo "<span style=\"text-size:1.0em;\">Accepted <span style=\"color:#0B7700;\"><strong>".$relevant_articles."</strong></span> relevant web pages out of <span style=\"color:#680A0C;\"><strong>".$total_articles."</strong></span>.</span></div>";
	}
	else {
		echo $used_urls."</div>";
	}
	/*
	echo '<pre>';
	print_r($output);
	echo '</pre>';
	*/

?>

