<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', 'accessibility_admin_actions');
function accessibility_admin_actions() {

add_menu_page( 'Accessibility','Accessibility','manage_options','accessibility-assistance','adminpage_accessibility','dashicons-universal-access-alt');

}

// Admin Panel View function
function adminpage_accessibility()
{
  if(is_admin())
  {
    ?>

  <script type="application/javascript">

  jQuery( document ).ready(function() {
  
jQuery('#preview_data').click(function(){
  
    jQuery('.keyboard-text').text(jQuery('#keybaord_nav').val());
    jQuery('.cursor-text').text(jQuery('#curson').val());
    jQuery('.desaturate-text').text(jQuery('#desaturate').val());
    jQuery('.contrast-text').text(jQuery('#contrast').val());
    jQuery('.bigger-text').text(jQuery('#bigger_text').val());
    jQuery('.highlight-text').text(jQuery('#highlight_links').val());
    jQuery('.reset-text').text(jQuery('#reset_all').val());
    jQuery('.icon-color-text').attr('fill',jQuery('#iconcolor').val());
    jQuery('.reset-text,.access-text').css("color", jQuery('#iconcolor').val());
    jQuery('.text-color-text').attr('fill',jQuery('#fontcolor').val());
    jQuery('.aa-cc-plugintextcolor').css("color", jQuery('#fontcolor').val());
    jQuery('.aa-cc-heading-background').css("background-color", jQuery('#backgroundcolor').val());
    jQuery('.reset-text').css("background-color", jQuery('#backgroundcolor').val());
    jQuery('.aa-cc-iconimg').css("background-color", jQuery('#backgroundcolor').val());
});

});
</script>
   <div class="container-fluid accessibilty-container">
    <div class="panel panel-primary">
    <nav class="navbar navbar-expand-md ">
    <a class="navbar-brand" href="#"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . '/assets/header_logo.png'; ?>" Navbar</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
      <span class="navbar-toggler-icon"></span>
      <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
         <li class="nav-item active">
            <a class="nav-link" href="#accessibility_dashboard">Setting</a>
         </li>
         <!--
        <li class="nav-item">
         <a class="nav-link" href="#">Link</a>
         </li>
         <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
        </li>
        -->    
        </ul>
  </div>  
</nav>
    <div class="panel-body">

<?php
require_once 'accessibility_dashboard.php';
?>

    </div>  <!-- panel-body -->

    </div>  <!-- panel -->
    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Preview</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    <?php
    require_once 'preview-model.php';
    ?>
    </div><!-- Modal content-->
    </div>
</div>
</div> <!-- container -->
<?php 
}
else{
  echo '<div class="alert alert-danger alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error! </strong> You do not have permission to edit this page</div> ';
}
}