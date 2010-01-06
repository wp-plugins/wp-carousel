<?php header('Content-type: text/css'); ?>
.theme-default-sidebar {
	margin:0;
}

.theme-default-sidebar .top-div {
	width:100%;
	height:30px;
	background:url(img/carousel-bg.png) top left repeat-x;
	-moz-border-radius:10px 10px 0 0;
	-khtml-border-radius:0 0 5px 5px;
	-webkit-border-radius:0 0 5px 5px;
	border-radius:0 0 5px 5px;
}

.theme-default-sidebar .top-div .arrow-right {
	width:50%;
	height:30px;
	float:right;
}

.theme-default-sidebar .top-div .arrow-left {
	width:50%;
	height:30px;
	float:left;
}

.theme-default-sidebar .top-div .arrow-left a {
	width:25px;
	height:30px;
	background:url(img/arrow_left.png) top left no-repeat;
	display:block;
	float:right;
}

.theme-default-sidebar .top-div .arrow-right a {
	width:25px;
	height:30px;
	background:url(img/arrow_right.png) top right no-repeat;
	display:block;
	float:left;
}

.theme-default-sidebar .hide { display:none; }

.stepcarousel {
	position: relative; /* Leave this value alone */
	overflow: scroll; /* Leave this value alone */
	height: 220px;
	background:url(img/carousel-bg.png) 0 -30px repeat-x;
}

.stepcarousel .belt{
	position: absolute; /* Leave this value alone */
	left: 0;
	top: 0;
}

.theme-default-sidebar .stepcarousel .panel {
	height:180px;
	float: left; /* Leave this value alone */
	overflow: hidden; /*Clip content that go outside dimensions of holding panel DIV */
	margin:10px;
	padding:10px;
	border:1px solid #5B5B5B;
	background:#383838 url(img/carousel-panel-bg.png) bottom left repeat-x;
	-moz-border-radius:5px;
	-khtml-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	display:block;
}

.theme-default-sidebar .stepcarousel .panel .panel-text { color:#FFF; }

.theme-default-sidebar .bottom-div {
	background:#3B3B3B;
	-moz-border-radius:0 0 5px 5px;
	-khtml-border-radius:0 0 5px 5px;
	-webkit-border-radius:0 0 5px 5px;
	border-radius:0 0 5px 5px;
}

.wp_carousel_default_sidebar_pagination {
	margin:0 30px;
	padding:5px 10px;
	background:#3B3B3B;
	text-align:center;
}