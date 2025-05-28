<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/images/logo-perpus.png') ?>" />
	<meta name="description" content="">
	<meta name="author" content="">

	<link href="<?php echo base_url('assets/login') ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/login') ?>/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/login') ?>/css/style.css" rel="stylesheet">

	<title>Pintu Masuk</title>
</head>

<body>
	<section class="form-02-main">
		<div class="container">
			<form action="<?php echo site_url('auth/login') ?>" method="post">
				<div class="row">
					<div class="col-md-12">
						<div class="_lk_de">
							<div class="form-03-main">
								<div class="logo">
									<img src="<?php echo base_url('assets/images/logo-perpus.png') ?>">
								</div>
								<?php if ($this->session->flashdata('message')) { ?>
									<div class="alert alert-danger alert-dismissible">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<h5> Alert!</h5>
										<?php echo $this->session->flashdata('message') ?>
									</div>
								<?php } ?>

								<div class="form-group">
									<input type="text" name="username" class="form-control _ge_de_ol" type="text" placeholder="Enter Username" required="" aria-required="true">
								</div>

								<div class="form-group">
									<input type="password" name="password" class="form-control _ge_de_ol" type="text" placeholder="Enter Password" required="" aria-required="true">
								</div>

								<div class="form-group">
									<div class="_btn_04">
										<button type="submit">Login</button>
									</div>
								</div>
								<div class="form-group nm_lk">
									<p>Or Login With</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</form>

		</div>
	</section>
</body>

</html>