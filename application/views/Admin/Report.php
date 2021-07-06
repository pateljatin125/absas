

 
          
             <?php include('include/header.php'); ?>  
             <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('assets/css/managedata.css');?>"/>
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
                            <div class="panel panel-default" style="box-shadow:none">
                                <div class="panel-heading col-md-12">
                                    <div class="row"> 
                                       <div class="col-md-6">
                                           <h3 class="panel-title"><strong>Report's Management </strong></h3>
                                        </div>
                                       <div  class="col-md-6 text-right">
                                           <span style="font-size: 14px;margin-top:3px;display:inline-block">View By Report Category</span>  
                                           <select class="form-control pull-right" style="width:200px;">
                                        <option>Search By</option>
                                        <option>Popularity</option>
                                        <option>Location</option>
                                        <option>Duration</option>
                                        <option>State</option>
                                        <option>Response time</option>
                                    </select>
                                        </div>
                                    </div>
                                   
                                    <?php if(isset($_SESSION['userAdd'])){ ?>
    <div class="alert alert-success"><?php echo $_SESSION['userAdd'] ?></div>
  <?php }if(isset($_SESSION['usernotAdd'])){ ?>
    <div class="alert alert-danger"><?php echo $_SESSION['usernotAdd'] ?></div>
  <?php } ?>    
                                      
                                </div>
                                
                                <div class="panel-body">
                                    <div class="panel panel-default tabs" style="border: none;">
    <div class="bs-example bs-example-tabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        
      <li role="presentation" class="active" ><a href="#sos" id="sos-tab" role="tab" data-toggle="tab" aria-controls="sos" aria-expanded="true">SOS</a></li>
       <li role="presentation" class=""><a href="#Popularity" role="tab" id="Popularity-tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="false">iWitness</a></li>
      <li role="presentation" class=""><a href="#Popularity1" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Officer Conduct</a></li>
      <li role="presentation" class=""><a href="#Popularity2" role="tab" id="Duration-tab" data-toggle="tab" aria-controls="Duration" aria-expanded="false">Commend Officer</a></li>
      <li role="presentation" class=""><a href="#Popularity3" role="tab" id="State-tab" data-toggle="tab" aria-controls="State" aria-expanded="false">Stolen vehicle</a></li>
      <li role="presentation" class=""><a href="#Popularity4" role="tab" id="Response-tab" data-toggle="tab" aria-controls="Response" aria-expanded="false">Missing Persons</a></li>
      <li role="presentation" class="" ><a href="#Popularity5" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">Lodge a complaint</a></li>
      <li role="presentation" class=""><a href="#Popularity6" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Gun Violence</a></li>
      <li role="presentation" class=""><a href="#Popularity7" role="tab" id="Duration-tab" data-toggle="tab" aria-controls="Duration" aria-expanded="false">Drug Abuse</a></li>
      <li role="presentation" class="" style="margin-left: -5px;"><a href="#Popularity8" role="tab" id="State-tab" data-toggle="tab" aria-controls="State" aria-expanded="false">Domestic Violence</a></li>
      <li role="presentation" class=""><a href="#Popularity9" role="tab" id="Response-tab" data-toggle="tab" aria-controls="Response" aria-expanded="false">Terrorist Attack</a></li>
      <li role="presentation" class="" ><a href="#Popularity10" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">Rape</a></li>
      <li role="presentation" class=""><a href="#Popularity11" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Kidnap</a></li>
      <li role="presentation" class=""><a href="#Popularity12" role="tab" id="Duration-tab" data-toggle="tab" aria-controls="Duration" aria-expanded="false">Robbery</a></li>
      <li role="presentation" class=""><a href="#Popularity13" role="tab" id="State-tab" data-toggle="tab" aria-controls="State" aria-expanded="false">Burglary</a></li>
      <li role="presentation" class=""><a href="#Popularity14" role="tab" id="Response-tab" data-toggle="tab" aria-controls="Response" aria-expanded="false">Cybercrime</a></li>
      <li role="presentation" class="" ><a href="#Popularity15" id="Popularity-tab" role="tab" data-toggle="tab" aria-controls="Popularity" aria-expanded="true">Submit a Tip</a></li>
      <li role="presentation" class=""><a href="#Popularity16" role="tab" id="Location-tab" data-toggle="tab" aria-controls="Location" aria-expanded="false">Other Reports</a></li>
     
      
    </ul>
    <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="sos" aria-labelledby="sos-tab">
          <table id="customers2" class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>SOS ID</th>
                                                <th>SOS Type</th>
                                                <th><?php echo ucfirst('SOS_category'); ?></th>
                                                <th>current_location</th>
                                                <th>Name</th>
                                                 <th>Phone_Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Media</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($resultsos as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['SOS_id']; ?></td>
                                            <td><?php  if($itm['usertype']==0){ echo 'Citizen';}else{ echo 'Officer';} ?></td>
                                               <td><?php  echo $itm['sos_category_name']; ?></td>
                                                 <td><?php  echo $itm['current_location']; ?></td>
                                                 <td><?php  echo $itm['Name']; ?></td>
                                                  <td><?php  echo $itm['Phone_Number']; ?></td>
                                                  <td id="status_<?php echo $itm["SOS_id"];?>"><?php if($itm['SOS_staus']==1) {?><a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["SOS_id"];?>);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to deactive this SOS." /></a><?php } else{ ?><a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["SOS_id"];?>);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Aeactive this SOS." /> </a><?php } ?></td>
                                                
                                                 
                                       <td>
                                           <!--<a href="<?php echo base_url('/EditNewsArticles/') ;?><?php  echo $itm['SOS_id']; ?>">Edit</a>/-->
                                           <a  href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["SOS_id"];?>)">FeedBack/</a>
                                      
                                       <!--<a href="javascript:void(0)"><span onClick="return doconfirm(<?php  echo $itm['SOS_id']; ?>);">Delete</span></a>-->
                                       <a  href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return SOSview(<?php echo $itm["SOS_id"];?>)">View</a>
                                                                                            </td>
                                                                                            
                                                                                            <td><?php  
                                                                                            $audios = json_decode($itm['images']); 
                                                                                                  for($i=0; $i< count($audios); $i++)
                                                                                                  {
                                                                                            ?>
                                                                                            <a target='_blank' href="<?php echo $audios[$i]?>"><?php echo "link".$i; ?>
 
<?php
}
                                                                                   
                                                                         ?></td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                    </table>  
      </div>
      
      <div role="tabpanel" class="tab-pane fade" id="Popularity" aria-labelledby="Popularity-tab">
          <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>iWitness ID</th>
                                                <th>iWitness_date</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['iWitness_id']; ?></td>
                                               <td><?php  echo $itm['iWitness_date'].$itm['iWitness_tym']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status1_<?php echo $itm["iWitness_id"];?>"><?php if($itm['iWitness_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["iWitness_id"];?>,1);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["iWitness_id"];?>,1);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           <!--<a href="<?php echo base_url('/EditNewsArticles/') ;?><?php  echo $itm['iWitness_id']; ?>">Edit</a>/-->
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["iWitness_id"];?>,1)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       <!--<a href="javascript:void(0)"><span onClick="return doconfirm(<?php  echo $itm['iWitness_id']; ?>);">Delete</span></a>-->
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview(<?php echo $itm["iWitness_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity1" aria-labelledby="Location-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>OfficerAbuse_id </th>
                                                <th>Description</th>
                                                  <th>Location</th>
                                                 <th>Officer_name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result1 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['OfficerAbuse_id']; ?></td>
                                               <td><?php  echo $itm['Description']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Officer_name']; ?></td>
                                                  
                                                  <td id="status2_<?php echo $itm["OfficerAbuse_id"];?>"><?php if($itm['OfficerAbuse_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["OfficerAbuse_id"];?>,2);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["OfficerAbuse_id"];?>,2);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                          
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["OfficerAbuse_id"];?>,2)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview1(<?php echo $itm["OfficerAbuse_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity2" aria-labelledby="Duration-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>CommendOffice_id</th>
                                                <th>Officer_name</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result2 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['CommendOffice_id']; ?></td>
                                               <td><?php  echo $itm['Officer_name']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status3_<?php echo $itm["CommendOffice_id"];?>"><?php if($itm['CommendOffice_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["CommendOffice_id"];?>,3);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["CommendOffice_id"];?>,3);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["CommendOffice_id"];?>,3)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview2(<?php echo $itm["CommendOffice_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity3" aria-labelledby="State-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Vehicle_make</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result3 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['StolenVehicle_report_id']; ?></td>
                                               <td><?php  echo $itm['Vehicle_make']; ?></td>
                                                 <td><?php  echo $itm['Vehicle_model']; ?></td>
                                                 <td><?php  echo $itm['Plate_Number']; ?></td>
                                                  
                                                  <td id="status4_<?php echo $itm["StolenVehicle_report_id"];?>"><?php if($itm['StolenVehicle_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["StolenVehicle_report_id"];?>,4);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["StolenVehicle_report_id"];?>,4);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                          
                                           <a title="Give Feedback" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["StolenVehicle_report_id"];?>,4)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview3(<?php echo $itm["StolenVehicle_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity4" aria-labelledby="Response-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Full_Name</th>
                                                  <th>Age</th>
                                                 <th>Sex</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result4 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Missing_Persons_report_id']; ?></td>
                                               <td><?php  echo $itm['Full_Name']; ?></td>
                                                 <td><?php  echo $itm['Age']; ?></td>
                                                 <td><?php  echo $itm['Sex']; ?></td>
                                                  
                                                  <td id="status5_<?php echo $itm["Missing_Persons_report_id"];?>"><?php if($itm['Missing_Persons_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Missing_Persons_report_id"];?>,5);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Missing_Persons_report_id"];?>,5);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Missing_Persons_report_id"];?>,5)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview4(<?php echo $itm["Missing_Persons_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity5" aria-labelledby="Location-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                  <th>Complaint</th>
                                                 
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result5 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Lodgecomplaint_report_id']; ?></td>
                                               <td><?php  echo $itm['Name']; ?></td>
                                                 <td><?php  echo $itm['Complaint']; ?></td>
                                                 
                                                  
                                                  <td id="status6_<?php echo $itm["Lodgecomplaint_report_id"];?>"><?php if($itm['Lodgecomplaint_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Lodgecomplaint_report_id"];?>,6);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Lodgecomplaint_report_id"];?>,6);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                          
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Lodgecomplaint_report_id"];?>,6)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview5(<?php echo $itm["Lodgecomplaint_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity6" aria-labelledby="Duration-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>GunViolence_id</th>
                                                
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result6 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['GunViolence_id']; ?></td>
                                              
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status7_<?php echo $itm["GunViolence_id"];?>"><?php if($itm['GunViolence_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["GunViolence_id"];?>,7);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["GunViolence_id"];?>,7);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["GunViolence_id"];?>,7)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview6(<?php echo $itm["GunViolence_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity7" aria-labelledby="State-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result7 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['DrugAbuse_report_id']; ?></td>
                                              
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status8_<?php echo $itm["DrugAbuse_report_id"];?>"><?php if($itm['DrugAbuse_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["DrugAbuse_report_id"];?>,8);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["DrugAbuse_report_id"];?>,8);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                         
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["DrugAbuse_report_id"];?>,8)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview7(<?php echo $itm["DrugAbuse_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity8" aria-labelledby="Response-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                               
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result8 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['DomesticViolence_report_id']; ?></td>
                                               
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status9_<?php echo $itm["DomesticViolence_report_id"];?>"><?php if($itm['DomesticViolence_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["DomesticViolence_report_id"];?>,9);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["DomesticViolence_report_id"];?>,9);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["DomesticViolence_report_id"];?>,9)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview8(<?php echo $itm["DomesticViolence_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity9" aria-labelledby="Location-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Date/Time</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result9 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['TerroristAttack_report_id']; ?></td>
                                               <td><?php  echo $itm['Date'].$itm['tym']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status10_<?php echo $itm["TerroristAttack_report_id"];?>"><?php if($itm['TerroristAttack_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["TerroristAttack_report_id"];?>,10);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["TerroristAttack_report_id"];?>,10);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["TerroristAttack_report_id"];?>,10)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview9(<?php echo $itm["TerroristAttack_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity10" aria-labelledby="Duration-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Victim_Name</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result10 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Rape_report_id']; ?></td>
                                               <td><?php  echo $itm['Victim_Name']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status11_<?php echo $itm["Rape_report_id"];?>"><?php if($itm['Rape_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Rape_report_id"];?>,11);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Rape_report_id"];?>,11);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                          
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Rape_report_id"];?>,11)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview10(<?php echo $itm["Rape_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity11" aria-labelledby="State-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Full_Name</th>
                                                  <th>Age</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result11 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Kidnap_report_id']; ?></td>
                                               <td><?php  echo $itm['Full_Name']; ?></td>
                                                 <td><?php  echo $itm['Age']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status12_<?php echo $itm["Kidnap_report_id"];?>"><?php if($itm['Kidnap_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Kidnap_report_id"];?>,12);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Kidnap_report_id"];?>,12);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                          
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Kidnap_report_id"];?>,12)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview11(<?php echo $itm["Kidnap_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity12" aria-labelledby="Response-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Items</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result12 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Robbery_report_id']; ?></td>
                                               <td><?php  echo $itm['Items']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status13_<?php echo $itm["Robbery_report_id"];?>"><?php if($itm['Robbery_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Robbery_report_id"];?>,13);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Robbery_report_id"];?>,13);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                          
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Robbery_report_id"];?>,13)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview12(<?php echo $itm["Robbery_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity13" aria-labelledby="Location-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                <th>Items</th>
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result13 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Burglary_report_id']; ?></td>
                                               <td><?php  echo $itm['Items']; ?></td>
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status14_<?php echo $itm["Burglary_report_id"];?>"><?php if($itm['Burglary_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Burglary_report_id"];?>,14);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Burglary_report_id"];?>,14);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           <!--<a href="<?php echo base_url('/EditNewsArticles/') ;?><?php  echo $itm['iWitness_id']; ?>">Edit</a>/-->
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Burglary_report_id"];?>,14)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       <!--<a href="javascript:void(0)"><span onClick="return doconfirm(<?php  echo $itm['iWitness_id']; ?>);">Delete</span></a>-->
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview13(<?php echo $itm["Burglary_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity14" aria-labelledby="Duration-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result14 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['CybercrimeFraud_report_id']; ?></td>
                                              
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status15_<?php echo $itm["CybercrimeFraud_report_id"];?>"><?php if($itm['CybercrimeFraud_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["CybercrimeFraud_report_id"];?>,15);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["CybercrimeFraud_report_id"];?>,15);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["CybercrimeFraud_report_id"];?>,15)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview14(<?php echo $itm["CybercrimeFraud_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity15" aria-labelledby="State-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                               
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result15 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Submit_Tip_id']; ?></td>
                                               
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status16_<?php echo $itm["Submit_Tip_id"];?>"><?php if($itm['Submit_Tip_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Submit_Tip_id"];?>,16);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Submit_Tip_id"];?>,16);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Submit_Tip_id"];?>,16)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview15(<?php echo $itm["Submit_Tip_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      <div role="tabpanel" class="tab-pane fade" id="Popularity16" aria-labelledby="Response-tab"> <table id="customers2" class="table datatable">

                                        <thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>ID</th>
                                                
                                                  <th>Location</th>
                                                 <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									
                                            <?php 
                                            $count=1;

                                            foreach($result16 as $itm) { ?>
                                            <tr class=''>
                                                <td><?php echo $count; ?>.</td>
                                            <td><?php  echo $itm['Others_report_id']; ?></td>
                                               
                                                 <td><?php  echo $itm['Location']; ?></td>
                                                 <td><?php  echo $itm['Description']; ?></td>
                                                  
                                                  <td id="status17_<?php echo $itm["Others_report_id"];?>"><?php if($itm['Others_report_status']==1) {?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(0,<?php echo $itm["Others_report_id"];?>,17);"><img src="<?php echo base_url(); ?>images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a><?php } else{ ?>
                                                  <a href="javascript:void(0);" onclick="changeBannerStatus(1,<?php echo $itm["Others_report_id"];?>,17);"><img src="<?php echo base_url(); ?>images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a><?php } ?></td>
                                                
                                                 
                                       <td class="tips">
                                           
                                           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(<?php echo $itm["Others_report_id"];?>,17)"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                      
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview16(<?php echo $itm["Others_report_id"];?>)"><span class="fa fa-eye "></span></a>
                                                                                            </td>
                                            </tr>
			<?php $count++;}

            ?>
                                        </tbody>
                                        
                                        
                                    </table>  
      </div>
      
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
        <h5 class="modal-title" id="exampleModalLabel">FeedBack Filed Report
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h5>
      </div>
       <form id="" action="<?php echo base_url('FeedbackFiledReport'); ?>" role="form" class="form-horizontal" method="POST"  enctype="multipart/form-data" >
      <div class="modal-body">
          <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                            <div class="row" >
                                
                                <div class="col-md-12">
                            
                           
                            <div class="panel panel-default">
                                
                               
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                      
									<div class="form-group">
                                                <label class="col-md-3 control-label">Feedback</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="feedback" id="feedback"  required/></textarea>
                                                        
                                                        <div id="aptid"></div>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Media</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="file" class="form-control" name="userfile[]" multiple>
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
										
                                        
                                        
                                        
                                    </div>

                                </div>
                               
                            </div>
                            
                            
                        </div>
                                </div></div>
        
        
        
        
      </div>
      <div class="modal-footer">
          <input type="Submit"    class="btn btn-primary pull-left" value="Submit" />
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
        <h5 class="modal-title" id="exampleModalLabel">Filed Report Details
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h5>
      </div>
      <div class="modal-body">
          <div class="col-md-12 mt-3" style="padding:30px 15px; background:#fff">
                            <div class="row" id="modal_body">
                                ...
                                </div></div>
        
        
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

                        </div>
                    </div>
                    
                    
                        <?php
                        
                         $category1 = $this->db->get_where('SOSManagement', array('SOS_category' =>1))->result_array(); 
                         $category2 = $this->db->get_where('SOSManagement', array('SOS_category' =>2))->result_array(); 
                         $category3 = $this->db->get_where('SOSManagement', array('SOS_category' =>3))->result_array(); 
                         $category4 = $this->db->get_where('SOSManagement', array('SOS_category' =>4))->result_array(); 
                         $category5 = $this->db->get_where('SOSManagement', array('SOS_category' =>5))->result_array(); 
                         $category6 = $this->db->get_where('SOSManagement', array('SOS_category' =>6))->result_array(); 
                         $category7 = $this->db->get_where('SOSManagement', array('SOS_category' =>7))->result_array();
                         
                         
                         
    $data1= $this->beats_model->select_data('*' , 'iWitness');
    $data2= $this->beats_model->select_data('*' , 'Officer_Abuse');
    $data3= $this->beats_model->select_data('*' , 'Commend_Officer');
    $data4= $this->beats_model->select_data('*' , 'StolenVehicle_report');
    $data5= $this->beats_model->select_data('*' , 'Missing_Persons_report');
    $data6= $this->beats_model->select_data('*' , 'Lodgecomplaint_report');
    $data7= $this->beats_model->select_data('*' , 'Gun_Violence_report');
    $data8= $this->beats_model->select_data('*' , 'Drug_Abuse_report');
    $data9= $this->beats_model->select_data('*' , 'Domestic_Violence_report');
    $data10= $this->beats_model->select_data('*' , 'Terrorist_Attack_report');
    $data11= $this->beats_model->select_data('*' , 'Rape_report');
    $data12= $this->beats_model->select_data('*' , 'Kidnap_report');
    $data13= $this->beats_model->select_data('*' , 'Robbery_report');
    $data14= $this->beats_model->select_data('*' , 'Burglary_report');
    $data15= $this->beats_model->select_data('*' , 'CybercrimeFraud_report');
    $data16= $this->beats_model->select_data('*' , 'Submit_Tip_report');
    $data17= $this->beats_model->select_data('*' , 'Others_report');
     
    $dataPoints = array( 
    	array("y" => count($category1), "label" => "Kidnap" ),
    	array("y" => count($category2), "label" => "Robbery" ),
    	array("y" => count($category3), "label" => "Rape" ),
    	array("y" => count($category4), "label" => "Car Theft" ),
    	array("y" => count($category5), "label" => "Burglary" ),
    	array("y" => count($category6), "label" => "Terrorist Attack" ),
    	array("y" => count($category7), "label" => "Drug Abuse" )
    );
     
     
     $dataPoints1 = array( 
    	array("y" => count($data1), "label" => "iWitness" ),
    	array("y" => count($data2), "label" => "Officer Conduct" ),
    	array("y" => count($data3), "label" => "Commend Officer" ),
    	array("y" => count($data4), "label" => "Stolen vehicle" ),
    	array("y" => count($data5), "label" => "Missing Persons" ),
    	array("y" => count($data6), "label" => "Lodge a complaint" ),
    	array("y" => count($data7), "label" => "Gun Violence" ),
    	array("y" => count($data8), "label" => "Drug Abuse" ),
    	array("y" => count($data9), "label" => "Domestic Violence" ),
    	array("y" => count($data10), "label" => "Terrorist Attack" ),
    	array("y" => count($data11), "label" => "Rape" ),
    	array("y" => count($data12), "label" => "Kidnap" ),
    	array("y" => count($data13), "label" => "Robbery" ),
    	array("y" => count($data14), "label" => "Burglary" ),
    	array("y" => count($data15), "label" => "Cybercrime" ),
    	array("y" => count($data16), "label" => "Submit a Tip" ),
    	array("y" => count($data17), "label" => "Other Reports" )
    
    );
    ?>
   
    <script>
    window.onload = function() {
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	theme: "light2",
    	title:{
    		text: "SOS Category"
    	},
    	axisY: {
    		title: "Number of SOS"
    	},
    	data: [{
    		type: "column",
    		yValueFormatString: "#,##0.## ",
    		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
    
     var chart = new CanvasJS.Chart("chartContainer2", {
    	animationEnabled: true,
    	theme: "light2",
    	title:{
    		text: "Filed Reports"
    	},
    	axisY: {
    		title: "Number of FiledReports"
    	},
    	data: [{
    		type: "column",
    		yValueFormatString: "#,##0.## ",
    		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
     
    }
    </script>
   
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                                 

                </div>         
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
          
        
        <!-- START PRELOADS -->
       <?php include('include/mange_script.php'); ?>       
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->     
    <script type="text/javascript" src="<?php echo base_url('assets/admin/user.js'); ?>"></script>
	<script>
	function FiledReportview(iWitness_id){

//alert(iWitness_id);

var base_url = $('#base_url').val();
     var datastring= 'iWitness_id='+iWitness_id;

//alert(datastring);
//alert(base_url);
    $.ajax({
      url: base_url+'Admin/iWitness',
      method:'POST',
      data:datastring,
      success:function(response){
        //alert(response) 
     $("#modal_body").html(response);
        }
        
       });




    }
    function SOSFeedback(iWitness_id,catid){
// alert(iWitness_id);
// alert(catid);
$('#aptid').html('<input type="hidden" class="form-control" name="report_id" id="report_id" value="'+iWitness_id+'" /><input type="hidden" class="form-control" name="cat_id" id="cat_id" value="'+catid+'" />');





    }
	
function doconfirm(id)
{
    //alert(id);
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
    var base_url = $('#base_url').val();
     var datastring= 'id='+id;
     //alert(datastring);
    $.ajax({
      url: base_url+'Admin/Newsdel',
      method:'POST',
      data:datastring,
      success:function(data){
        location.href = data;
            }
       });

}
function changeBannerStatus(status,event_id,cat_id){
//alert(status);
//alert(banner_id);

var base_url = $('#base_url').val();
     var datastring= 'status='+status +'&SOSid='+event_id+'&cat_id='+cat_id;

 //alert(base_url);
    $.ajax({
      url: base_url+'Admin/iWitnessStatus',
      method:'POST',
      data:datastring,
      success:function(data){
      //alert(data);
      //console.log(data);
        if(data==1){
        $('#status'+cat_id+'_'+event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(0,'+event_id+')"><img src='+base_url+'images/bullet_green.png width="32" height="32" title="click to deactive this banner." /></a>');
        //location.href = data;
            }
            else
            {
                $('#status'+cat_id+'_'+event_id).html('<a href="javascript:void(0);" onclick="changeBannerStatus(1,'+event_id+')"><img src='+base_url+'images/bullet_red.png width="32" height="32" title="click to Aeactive this banner." /></a>');
        
            }
        }
       });




    }
    
      
function ReportCategory(id){
    //alert(id)
    var base_url = $('#base_url').val();
     var datastring= 'id='+id;

 //alert(base_url);
    $.ajax({
      url: base_url+'Admin/ReportCategory',
      method:'POST',
      data:datastring,
      success:function(data){
      //alert(data);
      //console.log(data);
      $('#tab1').html(data);
    //   table.ajax.reload();
        
        }
       });
}
</script>

    </body>
</html>
  