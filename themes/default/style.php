<?php header('Content-type: text/css'); ?>
.theme-default {
	margin:20px 0 0 0;
}

.theme-default .arrow-right {
	width:30px;
	height:250px;
	background:url(img/carousel-bg-corners.png) top right no-repeat;
	float:right;
}

.theme-default .arrow-left {
	width:30px;
	height:250px;
	background:url(img/carousel-bg-corners.png) top left no-repeat;
	float:left;
}

.theme-default .arrow-left a {
	margin:112px 0 0 0;
	width:25px;
	height:30px;
	background:url(img/arrow_left.png) top left no-repeat;
	display:block;
}

.theme-default .arrow-right a {
	margin:112px 0 0 0;
	width:25px;
	height:30px;
	background:url(img/arrow_right.png) top right no-repeat;
	display:block;
}

.theme-default .hide { display:none; }

.theme-default .stepcarousel {
	position: relative; /* Leave this value alone */
	overflow: scroll; /* Leave this value alone */
	height: 250px;
	background:url(img/carousel-bg.png) top left repeat-x;
}

.theme-default .stepcarousel .belt{
	position: absolute; /* Leave this value alone */
	left: 0;
	top: 0;
}

.theme-default .stepcarousel .panel {
	height:210px;
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

.theme-default .stepcarousel .panel .panel-text { color:#FFF; }

.wp_carousel_default_pagination {
	margin:0 30px;
	padding:5px 10px;
	background:#3B3B3B;
	text-align:center;
	-moz-border-radius:0 0 5px 5px;
	-khtml-border-radius:0 0 5px 5px;
	-webkit-border-radius:0 0 5px 5px;
	border-radius:0 0 5px 5px;
}