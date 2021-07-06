<?php include('include/header.php'); ?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/css/managedata.css'); ?>" />
<!-- START PAGE SIDEBAR -->
<div class="page-container">
  <?php include('include/left_side.php'); ?>

  <!-- PAGE CONTENT -->
  <div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php include('include/top_nav.php'); ?>

    <div class="page-content-wrap">



      <div class="row">
        <div class="col-md-12">




          <!-- START DATATABLE EXPORT -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>MANAGE All Registered Officer's </strong></h3>
              <?php if (isset($_SESSION['userAdd'])) { ?>
                <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
              <?php }
              if (isset($_SESSION['usernotAdd'])) { ?>
                <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
              <?php } ?>


            </div>

            <div class="panel-body">
              <div class="panel panel-default tabs">
                <!--<ul class="nav nav-tabs nav-justified">
<li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">HTML</a></li>
<li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false">CSS</a></li>
<li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false">Javascript</a></li>
</ul>-->
                <div class="panel-body tab-content">
                  <div class="tab-pane active" id="tab1">
                    <table id="customers2" class="table datatable">
                      <thead>
                        <tr>
                          <th>SrNo.</th>
                          <th>Officer ID</th>
                          <th><?php echo ucfirst('Full_Name'); ?></th>
                          <th>Phone</th>
                          <th>Rank</th>
                          <th>Category</th>
                          <th>Genotype</th>
                          <th>Allergies</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $count = 1;

                        foreach ($result_new as $itm) { ?>
                          <tr id="Officer<?php echo $itm->Officer_id; ?>">
                            <td><?php echo $count; ?>.</td>
                            <td><?php echo $itm->Officer_id; ?></td>
                            <td><?php echo $itm->Full_Name; ?></td>
                            <td><?php echo $itm->phone; ?></td>
                            <td><?php echo $itm->Rank; ?></td>
                            <td><?php echo ($itm->officer_category == 1 ?"State":"LGA"); ?></td>
                            <td><?php echo $itm->geno_type; ?></td>
                            <td><?php echo $itm->allergies; ?></td>
                            <td id="status_<?php echo $itm->Officer_id; ?>"><?php if ($itm->Officer_status == 1) { ?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm->Officer_id; ?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to deactive Officer." /></a><?php } else { ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm->Officer_id; ?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Aeactive Officer." /> </a><?php } ?></td>
                            <td>
                              <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm->Officer_id; ?>">Edit</a>/-->
                              <a href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return OfficerEdit(<?php echo $itm->Officer_id; ?>)">Edit/</a>

                              <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm->Officer_id; ?>);">Delete</span></a>
                              <a href="#" data-toggle="modal" data-target="#exampleModal" onclick="return Officerview(<?php echo $itm->Officer_id; ?>)">/view</a>
                              <!--<a  href="#" data-toggle="modal" data-target="#exampleModal2"  onclick="return Officerview1(<?php echo $itm->Officer_id; ?>)">/Reset Password</a>-->
                           
                            </td>
                          </tr>
                        <?php $count++;
                        }

                        ?>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>


            </div>
          </div>
          <!-- END DATATABLE EXPORT -->

          <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Officer Details
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button></h5>
                </div>
                <form id="" action="<?php echo base_url('UpdateOfficer'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                  <div class="modal-body">
                    <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                      <div class="row" id="modal_body1">

                        <div class="col-md-12">


                          <div class="panel panel-default">


                            <div class="panel-body">

                              <div class="row">


                                <div class="col-md-12">

                                  ...

                                </div>




                              </div>

                            </div>

                          </div>


                        </div>
                      </div>
                    </div>




                  </div>
                  <div class="modal-footer">
                    <input type="Submit" class="btn btn-primary pull-left" value="Update" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- END DEFAULT TABLE EXPORT -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Officer Details
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button></h5>
                </div>
                <div class="modal-body">
                  <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                    <div class="row" id="modal_body">
                      ...
                    </div>
                  </div>




                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
              </div>
            </div>
          </div>

          <!-- reset password -->



        </div>
      </div>

    </div>
    <!-- END PAGE CONTENT WRAPPER -->
  </div>


  <!-- START PRELOADS -->
  <?php include('include/mange_script.php'); ?>
  <!-- END TEMPLATE -->
  <!-- END SCRIPTS -->
  <script>
    function Officerview(Officer_id) {

      //alert(Officer_id);

      var base_url = $('#base_url').val();
      var datastring = 'Officer_id=' + Officer_id;

      //alert(datastring);
      //alert(base_url);
      $.ajax({
        url: base_url + 'Admin/ViewOfficer',
        method: 'POST',
        data: datastring,
        success: function(response) {
          $("#modal_body").html(response);
        }

      });




    }

    function OfficerEdit(Officer_id) {

      //alert(Officer_id);

      var base_url = $('#base_url').val();
      var datastring = 'Officer_id=' + Officer_id;

      //alert(datastring);
      //alert(base_url);
      $.ajax({
        url: base_url + 'Admin/EditOfficer',
        method: 'POST',
        data: datastring,
        success: function(response) {
          $("#modal_body1").html(response);
        }

      });




    }

    function doconfirm(id) {
      //alert(id);
      job = confirm("Are you sure to delete permanently?");
      if (job != true) {
        return false;
      }
      var base_url = $('#base_url').val();
      var datastring = 'id=' + id;
      //alert(datastring);
      $.ajax({
        url: base_url + 'Admin/Officerdel',
        method: 'POST',
        data: datastring,
        success: function(data) {

          $('#Officer' + id).remove();

        }
      });

    }

    function changeBannerStatus(status, event_id) {
      //alert(status);
      //alert(banner_id);

      var base_url = $('#base_url').val();
      var datastring = 'status=' + status + '&Officer_id=' + event_id;

      //alert(datastring);
      $.ajax({
        url: base_url + 'Admin/OfficerStatus',
        method: 'POST',
        data: datastring,
        success: function(data) {
          //alert(data);
          //console.log(data);
          if (data == 1) {
            $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,' + event_id + ')"><img src=' + base_url + 'images/bullet_green.png width="32" height="32" title="click to deactive this banner." /></a>');
            //location.href = data;
          } else {
            $('#status_' + event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,' + event_id + ')"><img src=' + base_url + 'images/bullet_red.png width="32" height="32" title="click to Aeactive this banner." /></a>');

          }
        }
      });




    }
  </script>
  <script>
        function viewPassword()
        {
          var passwordInput = document.getElementById('password-field');
          var passStatus = document.getElementById('pass-status');
         
          if (passwordInput.type == 'password'){
            passwordInput.type='text';
            passStatus.className='fa fa-eye-slash';
            
          }
          else{
            passwordInput.type='password';
            passStatus.className='fa fa-eye';
          }
        }
    </script>
  
  </body>

  </html>