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
              <h3 class="panel-title"><strong>MANAGE All Registered User's </strong></h3>
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
                          <th>User ID</th>
                          <th>Unique Code</th>
                          <th><?php echo ucfirst('user name'); ?></th>
                          <th>User Phone</th>
                          <th>User KinPhone</th>
                          <th>LGA State</th>
                          <th>Blood Group</th>
                          <th>Geno Type</th>
                          <th>Allergies</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $count = 1;

                        foreach ($result_new as $itm) { ?>
                          <tr id="user<?php echo $itm->user_id; ?>">
                            <td><?php echo $count; ?></td>
                            <td><?php echo $itm->user_id; ?></td>
                              <td><?php echo $itm->unique_code; ?></td>
                            <td><?php echo $itm->user_name; ?></td>
                            <td><?php echo $itm->user_phone; ?></td>
                            <td><?php echo $itm->user_kinPhone; ?></td>
                            <td><?php echo $itm->lga_state; ?></td>
                            <td><?php echo $itm->blood_group; ?></td>
                            <td><?php echo $itm->geno_type; ?></td>
                            <td><?php echo $itm->allergies; ?></td>
                            <td>
                              <!--<a href="<?php echo base_url('/EditNewsArticles/'); ?><?php echo $itm->user_id; ?>">Edit</a>/-->
                              <a href="#" data-toggle="modal" data-target="#exampleModal1" onclick="return UserEdit(<?php echo $itm->user_id; ?>)">Edit/</a>

                              <a href="javascript:void(0)"><span onClick="return doconfirm(<?php echo $itm->user_id; ?>);">Delete/</span></a>

                       
                              <!--                                       <a  href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return matchview(<?php echo $itm->user_id; ?>)">/-->

                              <!--  view-->
                              <!--</a>-->
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

          <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit User Details
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button></h5>
                </div>
                <form id="" action="<?php echo base_url('Updateuser'); ?>" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
          <!-- END DATATABLE EXPORT -->

          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">User Details
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
          <!-- END DEFAULT TABLE EXPORT -->

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
    function UserEdit(match_id) {

      //alert(match_id);

      var base_url = $('#base_url').val();
      var datastring = 'match_id=' + match_id;

      //alert(datastring);
      //alert(base_url);
      $.ajax({
        url: base_url + 'Admin/UserEdit',
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
        url: base_url + 'Admin/userdel',
        method: 'POST',
        data: datastring,
        success: function(data) {
          //location.href = data;
          $('#user' + id).remove();
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