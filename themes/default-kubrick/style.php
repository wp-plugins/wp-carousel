<?php header('Content-type: text/css'); ?>
.theme-default-kubrick {
	margin:20px 0 0 0;
}

.theme-default-kubrick .arrow-right {
	width:30px;
	height:250px;
	background:url(img/carousel-bg-corners.png) top right no-repeat;
	float:right;
}

.theme-default-kubrick .arrow-left {
	width:30px;
	height:250px;
	background:url(img/carousel-bg-corners.png) top left no-repeat;
	float:left;
}

.theme-default-kubrick .arrow-left a {
	margin:112px 0 0 0;
	width:25px;
	height:30px;
	background:url(img/arrow_left.png) top left no-repeat;
	display:block;
}

.theme-default-kubrick .arrow-right a {
	margin:112px 0 0 0;
	width:25px;
	height:30px;
	background:url(img/arrow_right.png) top right no-repeat;
	display:block;
}

.theme-default-kubrick .hide { display:none; }

.theme-default-kubrick .stepcarousel {
	position: relative; /* Leave this value alone */
	overflow: scroll; /* Leave this value alone */
	height: 250px;
	background:url(img/carousel-bg.png) top left repeat-x;
}

.theme-default-kubrick .stepcarousel .belt{
	position: absolute; /* Leave this value alone */
	left: 0;
	top: 0;
}

.theme-default-kubrick .stepcarousel .panel {
	height:210px;
	float: left; /* Leave this value alone */
	overflow: hidden; /*Clip content that go outside dimensions of holding panel DIV */
	margin:10px;
	padding:10px;
	border:1px solid #73A0C5;
	background:#567995 url(img/carousel-panel-bg.png) bottom left repeat-x;
	-moz-border-radius:5px;
	-khtml-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	display:block;
}

.theme-default-kubrick .stepcarousel .panel .panel-text { color:#FFF; }

.wp_carousel_default_kubrick_pagination {
	margin:0 30px;
	padding:5px 10px;
	background:#4180B6;
	text-align:center;
	-moz-border-radius:0 0 5px 5px;
	-khtml-border-radius:0 0 5px 5px;
	-webkit-border-radius:0 0 5px 5px;
	border-radius:0 0 5px 5px;
}