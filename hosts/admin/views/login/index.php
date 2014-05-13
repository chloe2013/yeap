
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="login-container">
			<div class="center">
				<h1>
					<i class="icon-leaf green"></i>
					<span class="red">Ace</span>
					<span class="white">Application</span>
				</h1>
				<h4 class="blue">&copy; Company Name</h4>
			</div>

			<div class="space-6"></div>

			<div class="position-relative">
				<div id="login-box" class="login-box visible widget-box no-border">
					<div class="widget-body">
						<div class="widget-main">
							<h4 class="header blue lighter bigger">
								<i class="icon-coffee green"></i>
								Please Enter Your Information
							</h4>

							<div class="space-6"></div>

							<form action="/login" method="post">
								<fieldset>
									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<input type="text" name="uid" class="form-control" placeholder="Username" />
											<i class="icon-user"></i>
										</span>
									</label>

									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<input type="password" name="password" class="form-control" placeholder="Password" />
											<i class="icon-lock"></i>
										</span>
									</label>

									<div class="space"></div>

									<div class="clearfix">
										<label class="inline">
											<input type="checkbox" name="remeber" class="ace" />
											<span class="lbl"> Remember Me</span>
										</label>

										<button type="submit" id="submitLogin" class="width-35 pull-right btn btn-sm btn-primary">
											<i class="icon-key"></i>
											Login
										</button>
									</div>

									<div class="space-4"></div>
								</fieldset>
							</form>

							<div class="social-or-login center">
								<span class="bigger-110">Or Login Using</span>
							</div>

							<div class="social-login center">
								<a class="btn btn-primary">
									<i class="icon-facebook"></i>
								</a>

								<a class="btn btn-info">
									<i class="icon-twitter"></i>
								</a>

								<a class="btn btn-danger">
									<i class="icon-google-plus"></i>
								</a>
							</div>
						</div><!-- /widget-main -->

						<div class="toolbar clearfix">
							<div>
								<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
									<i class="icon-arrow-left"></i>
									I forgot my password
								</a>
							</div>
						</div>
					</div><!-- /widget-body -->
				</div><!-- /login-box -->

				<div id="forgot-box" class="forgot-box widget-box no-border">
					<div class="widget-body">
						<div class="widget-main">
							<h4 class="header red lighter bigger">
								<i class="icon-key"></i>
								Retrieve Password
							</h4>

							<div class="space-6"></div>
							<p>
								Enter your email and to receive instructions
							</p>

							<form>
								<fieldset>
									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<input type="email" class="form-control" placeholder="Email" />
											<i class="icon-envelope"></i>
										</span>
									</label>

									<div class="clearfix">
										<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
											<i class="icon-lightbulb"></i>
											Send Me!
										</button>
									</div>
								</fieldset>
							</form>
						</div><!-- /widget-main -->

						<div class="toolbar center">
							<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
								Back to login
								<i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- /widget-body -->
				</div><!-- /forgot-box -->
			</div><!-- /position-relative -->
		</div>
	</div><!-- /.col -->
</div><!-- /.row -->

