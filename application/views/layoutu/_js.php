<!-- JavaScript -->
<script src="<?php echo base_url('assets');?>/vendor/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets');?>/vendor/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?php echo base_url('assets');?>/vendor/assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="<?php echo base_url('assets');?>/vendor/assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url('assets');?>/vendor/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="<?php echo base_url('assets');?>/vendor/assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url('assets');?>/vendor/assets/js/demo.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
    });
</script>

<script>
  const CURRENT_URL=window.location.href.split("#")[0].split("?")[0];
  const $SIDEBAR_MENU = $("#my-sidebar-menu");

  $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent("li").addClass("active"); 
</script>

