<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style type="text/css">
    .login-container{
    margin-top: 5%;
    margin-bottom: 5%;
}
.login-form-1{
    padding: 5%;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-1 h3{
    text-align: center;
    color: #333;
}
.login-form-2{
    padding: 5%;
    background: #0062cc;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-2 h3{
    text-align: center;
    color: #fff;
}
.login-container form{
    padding: 10%;
}
.btnSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    border: none;
    cursor: pointer;
}
.login-form-1 .btnSubmit{
    font-weight: 600;
    color: #fff;
    background-color: #0062cc;
}
.login-form-2 .btnSubmit{
    font-weight: 600;
    color: #0062cc;
    background-color: #fff;
}
.login-form-2 .ForgetPwd{
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}
.login-form-1 .ForgetPwd{
    color: #0062cc;
    font-weight: 600;
    text-decoration: none;
}
img.tengah {
    display: block;
    margin-left: auto;
    margin-right: auto;
}


  </style>
<!-- Include the above in your HEAD tag -->

<div class="container login-container">
            <div class="row">
                <div class="col-md-6 login-form-1">
                 <center><strong>Sistem Pendeteksi Kemiripan Pada Proposal Pengajuan Tugas Akhir Menggunakan Algoritma Rabin-Karp</strong><br/>   
                 <strong align:center>FASTIKOM UNSIQ di Jawa Tengah</strong></center> <br/> 
                  <img class="tengah" src="<?php echo base_url('assets');?>/vendor/assets/img/index.jpg" alt="">
                </div>
                <div class="col-md-6 login-form-2">
                    <h3>Login</h3>
                      

                    <form class="form-signin" method="post" action="<?php echo base_url('auth/login'); ?>" role="login">
                      <div id="myalert" >
                        <?php echo $this->session->flashdata('alert', true)?>
                      </div>

                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="username" name="email" value="" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="password" name="password" value="" />
                        </div>
                        <div class="col-lg-8" style="padding-bottom: 5px">
                            <input type="submit" name="submit" class="btnSubmit" value="masuk" />
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>




   <!--  <h4 style="text-align:center;"><strong>Sistem Pendeteksi Kemiripan Pada Proposal Pengajuan Tugas Akhir Menggunakan Algoritma Rabin-Karp</strong></h4>
        <div class="card mb-3" style="max-width: 64rem;" style="center;">
          <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-lg-7">
            <src="" >
          Sistem Pendeteksi Kemiripan Pada Proposal Pengajuan Tugas Akhir Menggunakan Algoritma Rabin-Karp
            
            </div>
          <div class="col">
            <h5 class="card-title text-center">Masuk Dengan Username & Password Anda</h5> <br>
            <form class="form-signin" method="post" action="<?php echo base_url('auth/login'); ?>" role="login">
              <div class="form-group">
              Username
               <label for="email">username</label> 
				<input type="email" name="email" class="form-control" required minlength="5" placeholder="username" />
                <! <span class="glyphicon  glyphicon-envelope form-control-feedback"></span> 
              </div>
				
              <div class="form-group">
              Password
				<input type="password" name="password" class="form-control" required minlength="5" placeholder="password" />
				<!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> 
                
              </div>
              
			
				<div class="col-lg-8" style="padding-bottom: 5px">
					<button type="submit" name="submit" value="login" class="btn btn-info btn-fill pull-left"><i class="fa fa-sign-in" aria-hidden="true"></i> Masuk</button>
				</div>
			
              
              <!-- <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button> 
              </form>
              </div>
              </div>
           </div>
        </div>
      </div>
    --> 



 <script>
	$(function() {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			//radioClass: 'iradio_square-blue',
			//increaseArea: '20%' // optional
		});
	});
	$('#myalert').delay('slow').slideDown('slow').delay(4100).slideUp(600);
 </script>




