<?php 
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($actual_link== base_url('/BookingInfo') || $actual_link== base_url('/CompletedBooking') || $actual_link== base_url('/OngoingdBooking') ||
$actual_link== base_url('/CancelledBooking') ){
?>
<style>
	.x-navigation li.contant > ul {
    max-height: 1200px !important;
    }.x-navigation li.contant.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
else if($actual_link== base_url('/PersonalBookingInfo/All') || $actual_link== base_url('/PersonalBookingInfo/Completed') || $actual_link== base_url('/PersonalBookingInfo/Ongoing') ||
$actual_link== base_url('/PersonalBookingInfo/Cancelled') ){
?>
<style>
	.x-navigation li.contant1 > ul {
    max-height: 1200px !important;
    }.x-navigation li.contant1.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
elseif($actual_link==  base_url('/adminprofile')){
?>
<style>
	.x-navigation li.adpro> ul {
    max-height: 1200px !important;
    }.x-navigation li.adpro.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
elseif($actual_link== base_url('/CreateUser') || $actual_link== base_url('/ManageUser')){
?>
<style>
	.x-navigation li.member1> ul {
    max-height: 1200px !important;
    }.x-navigation li.member1.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
elseif($actual_link== base_url('/CreateDriver') || $actual_link== base_url('/ManageDriver') || $actual_link== base_url('/onlineDriver') || $actual_link== base_url('/offlineDriver')){
?>
<style>
	.x-navigation li.member2> ul {
    max-height: 1200px !important;
    }.x-navigation li.member2.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
elseif($actual_link== base_url('/ManageFare') || $actual_link== base_url('/Managebookingfee') ){
?>
<style>
	.x-navigation li.mtchprfl> ul {
    max-height: 1200px !important;
    }.x-navigation li.mtchprfl.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
elseif($actual_link== base_url('/DriverEarnings') || $actual_link== base_url('/AdminEarnings')){
?>
<style>
	.x-navigation li.mtchprfl1> ul {
    max-height: 1200px !important;
    }.x-navigation li.mtchprfl1.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}
elseif($actual_link== base_url('/DriverFeedback') || $actual_link== base_url('/UserFeedback')){
?>
<style>
	.x-navigation li.supprtreq > ul {
    max-height: 1200px !important;
    }.x-navigation li.supprtreq.active > ul {
    max-height: 0px !important;
    }
</style>
    <?php




}




?>