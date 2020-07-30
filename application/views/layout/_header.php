            <nav class="navbar navbar-expand-md " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#pablo"></a>
                    <button href="" class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <!-- <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-palette"></i>
                                    <span class="d-lg-none">Dashboard</span>
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification">5</span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Notification 1</a>
                                    <a class="dropdown-item" href="#">Notification 2</a>
                                    <a class="dropdown-item" href="#">Notification 3</a>
                                    <a class="dropdown-item" href="#">Notification 4</a>
                                    <a class="dropdown-item" href="#">Another notification</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nc-icon nc-zoom-split"></i>
                                    <span class="d-lg-block">&nbsp;Search</span>
                                </a>
                            </li>
                        </ul> -->
                        <ul class="navbar-nav ml-auto">

<div class="btn-group">
    <button type="button" class="btn btn-default btn-md" data-toggle="dropdown">Account</button>
    <!-- <button type="text" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <span class="sr-only">Toggle Dropdown</span>
    </button> -->
   
<div class="dropdown-menu card">
<div class="card-header">
    <strong>Info Login</strong><hr>
</div>
  <div class="card-body">
    <p><?php echo $this->session->userdata('email'); ?></p>
    <small>Terakhir Masuk , <?php echo $this->session->userdata('last_login'); ?></small>
  </div>
</div>                  
                    
</div>
                            
                         
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="no-icon">Dropdown</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </li> -->

                            <div class="btn-group">
                                <a class="btn btn-default btn-md" href="<?php echo base_url() ?>auth/logout">
                                    <span class="no-icon">Log out</span>
                                </a>
                            </div>
                        </ul>
                    </div>
                </div>
            </nav>