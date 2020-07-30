<!DOCTYPE html>
<head>
<title>Validasi upload file di CodeIgniter - Codingan.com</title>
</head>
<body>
<div class="container">
    <h1>Validasi upload file di CodeIgniter - Codingan.com</h1>
    <div class="row">
		<?php
			if(!empty($success_msg)){
				echo '<p class="statusMsg">'.$success_msg.'</p>';
			}elseif(!empty($error_msg)){
				echo '<p class="statusMsg">'.$error_msg.'</p>';
			}
		?>
		<form method="post" enctype="multipart/form-data">
			<p><input type="file" name="file"/>
			<?php echo form_error('file','<span class="help-block">','</span>'); ?></p>
			<p><input type="submit" name="uploadFile" value="UPLOAD"/></p>
		</form>
    </div>
</div>
</body>
</html>
