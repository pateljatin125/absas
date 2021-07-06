 <audio id="audio-alert" src="<?php echo base_url('assets/admin/audio/alert.mp3'); ?>" preload="auto"></audio>
        <audio id="audio-fail" src="<?php echo base_url('assets/admin/audio/fail.mp3'); ?>" preload="auto"></audio>
        <!-- END PRELOADS -->                      

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
  
        
       
        <!-- END PLUGINS -->
        
        <!-- START THIS PAGE PLUGINS-->        
      <script type='text/javascript' src="<?php echo base_url('assets/admin/js/plugins/icheck/icheck.min.js'); ?>"></script>        
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>"></script>
        
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tableexport/tableExport.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tableexport/jquery.base64.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tableexport/html2canvas.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tableexport/jspdf/libs/sprintf.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tableexport/jspdf/jspdf.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tableexport/jspdf/libs/base64.js'); ?>"></script>  
	
        <!-- END THIS PAGE PLUGINS-->  
		<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap-datepicker.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap-timepicker.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap-colorpicker.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap-file-input.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/bootstrap/bootstrap-select.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/tagsinput/jquery.tagsinput.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/jquery/jquery-ui.min.js'); ?>"></script>
          
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/settings.js'); ?>"></script>
        
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins.js'); ?>"></script>        
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/actions.js'); ?>"></script>    

<script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/blueimp/jquery.blueimp-gallery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/dropzone/dropzone.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/plugins/icheck/icheck.min.js'); ?>"></script>	
        
        
        <script>
        
        function state(id) {
         //alert(id);
       
           
        
           
          
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>Admin/state/"+id,
                    cache: false,
                    success: function(data) {
                         //alert(data);
                        $("#user_state").html(data);
                                    }
                });
            
        
    }
      function city(id) {
         //alert(id);
       
           
        
           
          
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>Admin/city/"+id,
                    cache: false,
                    success: function(data) {
                        //alert(data);
                        $("#user_city").html(data);
                                    }
                });
            
        
    }
    </script>