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
					$used_urls .= $u.
						'<div class="treeComparisonButton"><input type="button" class="comparisonButton" value="View Tree"></div><br />';
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
			$relevant_urls .= '<a href="'.$raw_url.'" target="_blank">'.$trunc_url.'</a>'.
				'<div class="treeComparisonButton"><input type="button" class="comparisonButton" value="View Tree Comparison"></div><br />';
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
		echo "Accepted <strong>".$relevant_articles."</strong> relevant web pages out of <strong>".$total_articles."</strong>.</div>";
	}
	else {
		echo $used_urls."</div>";
	}
	/*
	echo '<pre>';
	print_r($output);
	echo '</pre>';
	*/
	
	
	
	
	/*
	show keywords (5)
	show 3, 8-13 (links), 14/15
	show found links (hyperlink to them)

	Array
	(
    [0] => Content-Type: text/plain
    [1] => 
    [2] => 
    [3] => ['http://www.boston.com/bigpicture/2013/11/typhoon_haiyan.html', 'http://www.redcross.org.ph/']
    [4] => [(7.634789603169249, 496), (6.532599493153256, 293), (6.356708826689592, 480), (5.258096538021482, 394), (4.639057329615259, 574), (4.564949357461536, 159), (4.484906649788, 553), (4.484906649788, 146), (4.484906649788, 105), (4.302585092994046, 220)]
    [5] => [u'philippin', u'typhoon', u'manila', u'haiyan', u'central', u'wind', u'home', u'may', u'peopl', u'globe']
    [6] => 1,0.892210565468, http://www.boston.com/bigpicture/2013/11/typhoon_haiyan.html
    [7] => 1,0.793539601811, http://www.redcross.org.ph/
    [8] => 0.588030392867,0.716979838067, http://www.ifrc.org/en/news-and-media/news-stories/asia-pacific/philippines/relief--for-typhoon-bopha-survivors-reaches-remote-communities-in-mindanao-60624/
    [9] => 0.489383581707,0.652352845258, http://www.ifrc.org/typhoon-haiyan
    [10] => 0.588030392867,0.685862696574, http://www.redcross.fi/donate/typhoon-philippines
    [11] => 0.572321212068,0.75530805909, http://www.ifrc.org/en/news-and-media/press-releases/asia-pacific/philippines/international-red-cross-red-crescent-requests-87million-swiss-francs-for-typhoon-relief-efforts-in-philippines/
    [12] => 0.489383581707,0.74889582295, http://redcross.org.au/typhoon-haiyan-2013.aspx
    [13] => 0.489383581707,0.729918446021, http://www.redcross.ie/news/appeals/typhoon-haiyan-appeal/
    [14] => 8
    [15] => 10
	)	
	
	
	*/

?>

