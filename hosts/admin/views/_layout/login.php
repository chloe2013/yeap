<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>{title} - test</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- basic styles -->
		<link href="http://static.{config.domain}/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="http://static.{config.domain}/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="http://static.{config.domain}/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- ace styles -->
		<link rel="stylesheet" href="http://static.{config.domain}/css/ace.min.css" />
		<link rel="stylesheet" href="http://static.{config.domain}/css/ace-rtl.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="http://static.{config.domain}/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="http://static.{config.domain}/js/html5shiv.js"></script>
		<script src="http://static.{config.domain}/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
			{# view}
			</div>
		</div><!--/.fluid-container-->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='http://static.{config.domain}/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='http://static.{config.domain}/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='http://static.{config.domain}/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>
	</body>
</html>