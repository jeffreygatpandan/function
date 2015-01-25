// JavaScript Document


var popupStatus = 0;


//loading popup with jQuery magic!
function loadPopup(idPop_up){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		idPop_up.slideDown();
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(idPop_up){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		idPop_up.slideUp();
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(idPop_up){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = idPop_up.height();
	var popupWidth = idPop_up.width();
	//centering
	idPop_up.css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}
