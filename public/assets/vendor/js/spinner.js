
//useage
//Include the Js and the css file
//Add a container div with class spinner-container
//
	//read spinner container
	$(".spinner-container").html(
		'<div class="cssload-thecube"><div class="cssload-cube cssload-c1"></div><div class="cssload-cube cssload-c2"></div><div class="cssload-cube cssload-c4"></div><div class="cssload-cube cssload-c3"></div></div>'
)
	$(".spinner-container").fadeOut();


function showSpinner(){
	$(".spinner-container").addClass("overlay");
$(".spinner-container").fadeIn(300);
}

function removeSpinner(){
	$(".spinner-container").removeClass("overlay");
$(".spinner-container").fadeOut(300);
}