function changeImage(id, newImg)
{
	document.getElementById(id).src = newImg;
}

function getLuStatus(lid)
{
	sendRequestText("include/getlustatus.php", acceptLuStatus, "lid="+lid);
}

function acceptLuStatus(text)
{
	document.getElementById("lumessage").innerHTML = text;
}

_reArrangeDivs = function() {
    var docHeight = $(window).height();
    var docWidth = $(window).width();
	
	var dvMainTop = docHeight / 2 - $("#dvMain").height() / 2;
	dvMainTop = dvMainTop - 90;
	var dvMainLeft = docWidth / 2 - $("#dvMain").width() / 2;
	$("#dvMain").css({"top" : dvMainTop, "left" : dvMainLeft});
    
    var dvCopyTop = docHeight - 60;
    var dvCopyLeft = docWidth - 315;
    $("#dvCopy").css({"top" : dvCopyTop, "left" : dvCopyLeft});
	
	var dvPartnerTop = docHeight - 60;
    var dvPartnerLeft = 10;
    $("#dvPartner").css({"top" : dvPartnerTop, "left" : dvPartnerLeft});
    
    var luMessageTop = docHeight - 40;
    var luMessageLeft = docWidth / 2 - ($('#lumessage').width() / 2)
    $("#lumessage").css({"top" : luMessageTop, "left" : luMessageLeft});
}

// ON WINDOW RESIZED
$(window).resize(function() {
    _reArrangeDivs();
});

$(document).ready(function () {
    _reArrangeDivs();
	
	$(document).bgStretcher({
        images: ['images/background15.jpg'], imageWidth: 1680, imageHeight: 1050
    });
});