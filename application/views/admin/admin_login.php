<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login Page - Ace Admin</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?=SITE_URL?>/static/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?=SITE_URL?>/static/assets/font-awesome/4.2.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="<?=SITE_URL?>/static/assets/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?=SITE_URL?>/static/assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?=SITE_URL?>/static/assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?=SITE_URL?>/static/assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?=SITE_URL?>/static/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?=SITE_URL?>/static/assets/js/html5shiv.min.js"></script>
		<script src="<?=SITE_URL?>/static/assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout light-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-leaf green"></i>
									<span class="red">通用</span>
									<span class="grey" id="id-text2">管理后台</span>
								</h1>

							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												输入用户名密码
											</h4>

											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="用户名" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="密码" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Remember Me</span>
														</label>

														<button type="button" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">登录</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										 
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->
					</div>
		    </div><!-- /.row -->
		</div><!-- /.main-container -->
		<!-- basic scripts -->
		<!--[if !IE]> -->
		<script src="<?=SITE_URL?>/static/assets/js/jquery.2.1.1.min.js"></script>
		<!-- <![endif]-->
		<!--[if IE]>
		<script src="<?=SITE_URL?>/static/assets/js/jquery.1.11.1.min.js"></script>
		<![endif]-->
		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?=SITE_URL?>/static/assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->
		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='<?=SITE_URL?>/static/assets/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?=SITE_URL?>/static/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		 
	</body>
</html>
