    
        <div class="sidebar" data-image="<?php echo base_url('assets');?>/vendor/assets/img/sidebar-3.jpg" data-color="blue">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="" class="simple-text">
                      Uji Kemiripan Topik TA
                    </a>
                </div>

            <li>
                <center><small>~MAIN MENU~</small></center>
            </li>

                <ul class="nav" id="my-sidebar-menu">
            
                    <!-- <li class="nav-item active"> -->
                    <!-- <li id="active">
                        <a class="nav-link" href="<?php echo base_url('admin/Home'); ?>">
                            <i class="nc-icon nc-icon nc-paper-2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li> -->
            

                    <li>
                        <a class="nav-link" href="<?php echo base_url('admin/Kemiripan'); ?>">
                            <i class="nc-icon nc-chart-bar-32"></i>
                            <p>Uji Kemiripan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin/Dokumen'); ?>">
                            <i class="nc-icon nc-icon nc-paper-2"></i>
                            <p>Dokumen Uji</p>
                        </a>
                    </li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('admin/Sinonim'); ?>">
							<i class="nc-icon nc-single-copy-04"></i>
							<p>Sinonim</p>
						</a>
					</li>
                    <li>
                        <a class="nav-link" href="<?php echo base_url('admin/Petunjuk'); ?>">
                            <i class="nc-icon nc-settings-gear-64"></i>
                            <p>Petunjuk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin/Tentang'); ?>">
                            <i class="nc-icon nc-badge"></i>
                            <p>Tentang</p>
                        </a>
                    </li>
                 
                </ul>
            </div>
        </div>
