<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>{title} - test</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and
		delete these references -->
		<link rel="shortcut icon" href="http://static.{config.domain}/img/favicon.ico" />
		<link rel="apple-touch-icon" href="http://static.{config.domain}/apple-touch-icon.png" />
		<link href="http://static.{config.domain}/css/??bootstrap.css,jquery-ui.css,plugin.css?v={=time()}" rel="stylesheet" media="screen">
		<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="http://{config.base_domain}"> <img alt="Charisma Logo" src="http://{config.static_domain}/img/logo20.png" /> <span>Charisma</span></a>
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> {login.uid}</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/my">Profile</a></li>
						<li class="divider"></li>
						<li><a href="/login/out">Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
				
				<div class="top-nav nav-collapse">
					<ul class="nav">
						<li><a href="http://{config.base_domain}">Visit Site</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Main</li>
						{@mmenu}
						<li><a class="ajax-link" href="{.url}"><i class="{.icon}"></i><span class="hidden-tablet"> {.title}</span></a></li>
						{/}
					</ul>
					<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
			<!-- content starts -->
			
			<div>
				<ul class="breadcrumb">
					
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					{@breadcrumb}
					<li>
						<a href="{.url}">{.title}</a> <span class="divider">/</span>
					</li>
					{/}
					 {title}
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> {title}</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  {@fields}
								  <th>{.value_}</th>
								  {/}
								  <th class="last"><input type="checkbox" value="" name="checkAll"></th>
							  </tr>
						  </thead>   
						  <tbody>
							<tr>
								<td colspan="100" class="dataTables_empty center">数据加载中...</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div><!--/span-->
			</div><!--/row-->

			<!-- content ends -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<hr>
		{# view}
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Tips</h3>
			</div>
			<div class="modal-body">
				<p>Here something for Tips...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<footer>
			<p class="pull-left">&copy; <a href="http://{config.base_domain}" target="_blank">{config.base_domain}</a> 2013</p>
			<p class="pull-right">Powered by: <a href="http://{config.base_domain}">Yeap</a></p>
		</footer>
		
	</div><!--/.fluid-container-->
		<script type="text/javascript">
			var AjaxUrl = '{path}{ajax_url}';
			var listsField = {=json_encode(lists_fields)};
		</script>
		<script src="http://static.{config.domain}/js/??jquery.min.js,jquery-ui.custom.min.js,bootstrap.js,plugin.js,jquery.dataTables.min.js,charisma.js,lists.js?v={=time()}"></script>
	</body>
</html>