$(document).ready(function(){
	
	var descriptionFieldLabels = 'Event Type:<br />'+
		'City/State/Country:<br />'+
		'Day/Month/Year:<br />'+
		'Crawler Type:<br />'+
		'Search Page Limit:';
	var locationFields = '<select name="locationField" id="locationField">'+
		'<option value="0"> </option>'+
		'<option value="avalanche">Avalanche</option>'+
		'<option value="blizzard">Blizzard</option>'+
		'<option value="drought">Drought</option>'+
		'<option value="earthquake">Earthquake</option>'+
		'<option value="forestfire">Forest Fire</option>'+
		'<option value="flood">Flood</option>'+
		'<option value="hailstorm">Hailstorm</option>'+
		'<option value="heatwave">Heat Wave</option>'+
		'<option value="hurricane">Hurricane</option>'+
		'<option value="tsunami">Tsunami</option>'+
		'<option value="tornado">Tornado</option>'+
		'<option value="tropicalstorm">Tropical Storm</option>'+
		'<option value="typhoon">Typhoon</option>'+
		'<option value="volcaniceruption">Volcanic Eruption</option>'+
		'<option value="wildfire">Wildfire</option>'+
		'</select><br />';
	var cityField = '<input type="text" name="cityField" value="" id="cityField"> ';
	var stateField = '<input type="text" name="stateField" value="" id="stateField"> ';
	var countryField = '<input type="text" name="countryField" value="" id="countryField"><br />';

	var today = new Date()
	var dayField = '<select id="dayField">';
		dayField += '<option value="0"> </option>';
	for (var i=1;i<=31;i++)
	{
		dayField += '<option value="'+i+'">'+i+'</option>';
	}
	dayField +='</select>';
	var monthField = '<select id="monthField">'+
		'<option value="0"> </option>'+
		'<option value="1">January</option>'+
		'<option value="2">February</option>'+
		'<option value="3">March</option>'+
		'<option value="4">April</option>'+
		'<option value="5">May</option>'+
		'<option value="6">June</option>'+
		'<option value="7">July</option>'+
		'<option value="8">August</option>'+
		'<option value="9">September</option>'+
		'<option value="10">October</option>'+
		'<option value="11">November</option>'+
		'<option value="12">December</option>'+
		'</select>';
	var yearField = '<select id="yearField">';
		yearField += '<option value="0"> </option>';
	for (var i=today.getFullYear();i>=1900;i--)
	{
		yearField += '<option value="'+i+'">'+i+'</option>';
	}
	yearField +='</select><br />';
	
	var pageLimitField = '<input type="text" name="pageLimitField" id="pageLimitField" value="10">';
	
	var crawlerFields = '<select name="crawlerField" id="crawlerField">'+
		'<option value="0">Default</option>'+
		'<option value="1">Event-Based</option>'+
		'</select><br />'
	
    /* Handle adding Site URL fields */
	$('#siteDetailsContainer').append('<div id="siteDetailsLeft">'+
		descriptionFieldLabels+
		'</div>'+'<div id="siteDetailsRight">'+
		locationFields+cityField+stateField+countryField+dayField+monthField+yearField+crawlerFields+pageLimitField+
		'</div>');
    $('#siteUrls').append('<br /><div style="clear:both"></div>Site URL: <input type="text" name="addedURL" class="addedURL">');
    $('#addInput').click( function(){
        $('#siteUrls').append('<br />Site URL: <input type="text" name="addedURL" class="addedURL">');
    });
	
	$('#locationField').change(function() {
		if ($(this).val() === 'hurricane' || $(this).val() === 'typhoon') {
			var n = $(this).val();
			n = n.charAt(0).toUpperCase() + n.slice(1);  // Capitalize first letter
			$(".nameLabel").html(n+" Name:");
			if(!$("#siteDetailsRight #nameField").length){
				$("#siteDetailsLeft br" ).first().after('<div class="nameLabel">'+n+' Name:</div>');
				$("#siteDetailsRight br" ).first().after('<div class="nameValue"><input type="text" name="nameField" value="name" id="nameField" onfocus="this.value=\'\'"></div>');
			}
		}
		else if($("#siteDetailsRight #nameField").length) {
			$(".nameLabel").remove();
			$(".nameValue").remove();
		}
	});
	
	/* Handle input fields green shading */
	$('#siteUrls').delegate(".addedURL","input",function(){
		if($(this).val() != ''){
			$(this).css("background-color","#E0FFE7");
			$('#siteUrls').append('<br />Site URL: <input type="text" name="addedURL" class="addedURL">');
		}
		else {
			$(this).css("background-color","#FFFFFF");
		}
	});
	
	/* Handle tree comparison styling */
	$h = ($(window).height()-$(".treeComparisonWindow").height())/2;
	$w = ($(window).width()-$(".treeComparisonWindow").width())/2;
	$(".treeComparisonWindow").css("top",$h);
	$(".treeComparisonWindow").css("left",$w);
	$("#resultHolder").delegate(".comparisonButton","click",function(){
		window.open("JSTest/index.html");
		/*
		$(".treeComparisonBackground").toggle();
		$(".treeComparisonWindow").toggle();
		*/
	});
	$(".treeComparisonBackground").click(function(){
		$(".treeComparisonBackground").toggle();
		$(".treeComparisonWindow").toggle();
	});
	
	
    /* Handle AJAX fields posting */
	var s = 1;
	var origSpinner = "";
	var submissionLabel = "";
	$(".submitButton").click( function(){
		$('.noSubmissionsLabel').html('');
		$('#clearResults').attr("disabled",true);
	});
    $("#inputForm").on("submit", function(event) {
		
		event.preventDefault();
		
		origSpinner = "spinner"+s;
		submissionLabel = '<div class="submission"><span class="submissionLabel">Submission '+s+'</span>';
		$('#topHere').after(submissionLabel+'<div class="spinner '+origSpinner+'" style=""></div>');
		
		var inputURLValue = "";
		var inputEventDetails = "";
		var pageLimitField = "10";
		var crawlerField = "0";
		
		// Format URLs for url text file
		$(".addedURL").each(function(index) {
			inputURLValue += $(this).val()+" ";
		});
		
		// Format event details for details text file
		inputEventDetails = $("#locationField option:selected").text()+"\r\n"+
			$("#countryField").val()+"\r\n"+
			$("#stateField").val()+"\r\n"+
			$("#cityField").val()+"\r\n"+
			$("#nameField").val()+"\r\n"+
			$("#dayField option:selected").text()+"\r\n"+
			$("#monthField option:selected").text()+"\r\n"+
			$("#yearField option:selected").text();
			
		pageLimitField = $("#pageLimitField").val();
		crawlerField = $("#crawlerField").val();

		s++;
		$.ajax({
			type: "POST",
			data: {id: s-1, urlInput: inputURLValue, detailInput: inputEventDetails, pageLimit: pageLimitField, crawlField: crawlerField},
			url: "results-new.php",
			success: function (msg) {
				var temp = msg.substr(msg.indexOf('|')+1);
				var id = temp.substr(0, temp.indexOf('|'));
				$('.spinner'+id).after(msg);
				$('.spinner'+id).toggle();
			}
		});
	
    });
	
	/* Execute when all ajax is complete. */
	$(document).ajaxStop(function () {
		$('#clearResults').removeAttr("disabled");
	});
	
	/* Handle clearing URL text fields */
	$('#clearURLFields').click(function(){
		$(".addedURL").each(function(){
			$(this).css("background-color","#FFFFFF");
		});
	});
	
	/* Handle clearing URL results */
	$('#clearResults').click(function(){
		s = 1;
		$('#resultHolder').empty();
		$('#resultHolder').append('<div id="topHere"></div>');
		$('#resultHolder').append('<div class="noSubmissionsLabel">There have been no current submissions.</div>');
	});
	
});



