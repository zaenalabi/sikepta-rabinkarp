<!DOCTYPE html>
<html lang="en">


<head>

	<link rel="apple-touch-icon" sizes="76x76"
		  href="<?php echo base_url('assets'); ?>/vendor/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?php echo base_url('assets'); ?>/vendor/assets/img/favicon.ico">

	<!-- meta -->
	<?php require_once('_meta.php'); ?>


	<title><?php echo $title ?></title>

	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
	<!-- CSS Files -->

	<!-- css -->
	<?php require_once('_css.php'); ?>
	<script src="<?php echo base_url('assets'); ?>/vendor/assets/js/core/jquery.3.2.1.min.js"
			type="text/javascript"></script>

</head>

<body>
<div class="wrapper">
	<!-- sidebar -->

	<?php require_once('_sidebar.php'); ?>


	<div class="main-panel">
		<!-- Header -->
		<?php require_once('_header.php'); ?>
		<!-- End header -->
		<div class="content">
			<div class="container-fluid">
				<div class="section">

					<?php echo $contents; ?>

				</div>
			</div>
		</div>
		<!-- footer -->
		<?php require_once('_footer.php'); ?>
	</div>
	<div class="modal fade" id="ModalMe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		 aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="ModalHeader"></h6>
					<button type="button" id="ModalClose" class="close" data-dismiss="modal" aria-label="Close"><i
							class='fa fa-times'></i>
					</button>
				</div>
				<div class="modal-body" id="ModalContent"></div>
				<div class="modal-footer" id="ModalFooter"></div>
			</div>
		</div>
	</div>
</div>
</body>
<!--   Core JS Files   -->
<!-- js -->
<?php require_once('_js.php'); ?>
<script>
	$('#ModalMe').on('hide.bs.modal', function () {
		setTimeout(function () {
			$('#ModalHeader, #ModalContent, #ModalFooter').html('');
		}, 500);
	});
</script>
</html>
