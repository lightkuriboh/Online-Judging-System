function show(intA) {
    intA = Math.trunc(intA);
    if (intA<10) return '0'+intA.toString();
    else return intA.toString();
}

function showTime(sec) {
    return show(sec/3600)+":"+show(sec/60%60)+":"+show(sec%60);
}
function updateClock(cid, time) {
    if (time>0) {
        $('#clock'+cid).html('<b>'+showTime(time)+'</b>');
        setTimeout(function() {updateClock(cid,time-1);}, 1000);
     } //else if (!$('textarea').length) window.location.reload();
}

function contest_updateStandings(cid) {
	$('#btnRef').button('loading');
	jQuery.ajax({
		type: "POST",
		url: "resources/components/contest.php",
		data: {
			"cid": cid,
			"action": "standings"
		},
		dataType: "json",
		success: function(resp) {
			if (resp==false) location.reload();
			else {
				$('#contestRankings').html(resp);
				$('#btnRef').button('reset');
				setTimeout(function() {contest_updateStandings(cid);}, 30000);
			}
		}
	});
}

function contest_updateSidebarSubs(cid) {
	jQuery.ajax({
		type: "POST",
		url: "resources/components/contest.php",
		data: {
			"cid": cid,
			"action": "mysubs"
		},
		dataType: "json",
		success: function(resp) {
			if (resp==false) location.reload();
			else {
				$('#contestSidebarSubs').html(resp);
				setTimeout(function() {contest_updateSidebarSubs(cid);}, 10000);
			}
		}
	});
}

function contest_updateSidebarStandings(cid, tid) {
	$('#btnRef').button('loading');
	jQuery.ajax({
		type: "POST",
		url: "resources/components/contest.php",
		data: {
			"cid": cid,
			"action": "standings",
			"tid": tid 
		},
		dataType: "json",
		success: function(resp) {
			if (resp==false) location.reload();
			else {
				$('#contestSidebarRankings').html(resp);
				setTimeout(function() {contest_updateSidebarStandings(cid,tid);}, 10000);
			}
		}
	});
}

function load_submission_modal(rid) {
	$('#subModal').modal('show');
	$('#modal_loading_box').show();
	$('#modal_body').hide();
	jQuery.ajax({
		type: "GET",
		url: "resources/components/submission_modal.php",
		data: {
			"rid": rid
		},
		dataType: "json",
		success: function(resp) {
			if (resp==false) location.reload();
			else {
				//Start filling information for the modal
				jQuery.ajax({
					type: "GET",
					url: "resources/components/submission_judge.php",
					data: {
						"rid": rid
					},
					dataType: "json",
					success: function(respf) {
						$('#modal_loading_box').hide();
						$('#modal_body').show();
						$('#modal_subid').html(resp['rid']);
						$('#modal_subuser').html(resp['user']);
						$('#modal_subprob').html(resp['problem']);
						$('#modal_subjudge').html(resp['result']);
						$('#modal_subtime').html(resp['subtime']);
						$('#modal_sublink').html(resp['link']);
						if (resp['code']!='') {
							$('#modal_subcode').html('<pre><code id="modal_code" class="language-'+resp['lang']+'">'+resp['code']+'</code></pre>');
							Prism.highlightAll();
						} else $('#modal_subcode').html('');
						$('#modal_subjudge_details').html(respf);
						$('#subModal').modal('show');
					}
				});
			}
		}
	});
}

function get_judge_protocol(rid) {
	jQuery.ajax({
		type: "GET",
		url: "resources/components/submission_judge.php",
		data: {
			"rid": rid
		},
		dataType: "json",
		success: function(respf) {
			if (respf==-1) location.reload();
			$('#judge-protocol').html(respf);
			if (respf==' ') setTimeout(function() {get_judge_protocol(rid);}, 3000);
		}
	});
}

function updateLogon(tid) {
	jQuery.ajax({
		type: "GET",
		url: "resources/components/users.php",
		data: {
			"action": "update_logon",
			"tid": tid
		},
		success: function() {
			setTimeout(function() {updateLogon(tid);}, 600000);
		}
	});
}