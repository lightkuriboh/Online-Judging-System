function updateJudge(rid, full, img) {
	full = (full==='undefined'?false:full);
	img = (img==='undefined'?false:img);
	jQuery.ajax({
		type: "GET",
		url: "resources/components/submission.php",
		data: {
			"action": "getresult",
			"rid": rid,
			"full": full,
			"img": img
		},
		dataType: "json",
		success: function(resp) {
			if (full) {
				$('#res'+rid+'f').html(resp['judge']);
				$('#time'+rid+'f').html(resp['time']);
			}
			else $('#res'+rid).html(resp['judge']);
			if (!resp['end']) setTimeout(function() {updateJudge(rid, full, img);},3000);
			else if (full) jQuery.ajax({
				type: "GET",
				url: "resources/components/submission.php",
				data: {
					"action": "geterror",
					"rid": rid
				},
				dataType: "json",
				success: function(resp) {
					$('#error').html(resp);
				}
			});
		},
		error: function(a,b,c) {
			//alert(b+' '+c);
		}
	});
}
function timeAlert(name, time) {
	setTimeout(function() {$('#'+name).alert('close');},time);
}
