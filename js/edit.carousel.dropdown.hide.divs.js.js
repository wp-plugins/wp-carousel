function hideDivs(){
	document.getElementById("show_in_loop_div").style.display = "none";
	document.getElementById("content_posts").style.display = "none";
	document.getElementById("content_pages").style.display = "none";
	document.getElementById("content_categories").style.display = "none";
}

function doShow(){
	
	switch (window.document.forms.post_wordpress.type_list.item(window.document.forms.post_wordpress.type_list.selectedIndex).value) {
		
		case "2": hideDivs();
		document.getElementById("content_posts").style.display = "block";
		document.getElementById("show_in_loop_div").style.display = "block";
		break;
		
		case "3": hideDivs();
		document.getElementById("content_pages").style.display = "block";
		break;
		
		case "1": hideDivs();
		document.getElementById("content_categories").style.display = "block";
		document.getElementById("show_in_loop_div").style.display = "block";
		break;
		
		default: hideDivs();
		break;
		
	}
}

doShow();