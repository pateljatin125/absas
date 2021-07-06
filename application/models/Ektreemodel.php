<?php
class Ektreemodel extends CI_Model
{
  
        /**
	* file upload method
	* @access	public
	**/
	
       public function upload_image()
       {
                           $config['upload_path']='./uploads/';
			   $config['allowed_types']='gif|jpg|png|jpeg';
			   $config['max_size']='2024';
			   $config['max_width']='2024';
			   $config['max_height']='1024';
			   $this->load->library('upload',$config);
			   if(!$this->upload->do_upload())
			   {
			     $error=array('error'=>$this->upload->display_errors());
			     return 0;
				 
			   }
			   else
			   {
		             $data=$this->upload->data();
                             $filename=$data['file_name'];
                             $user=1;
                             $result= array('imagepath' =>$filename);
                             $this->db->where('user_id', $user);
                             $insertstatus=$this->db->update("users",$result);
                             return $filename;            
			   }
                
       }
       public function upload_thumbnail()
       {
                        if($this->session->userdata('artist_login')){
                                $session_id = $this->session->userdata('artist_id');
                        }else{
                                $session_id = $this->session->userdata('fan_id');  
                        }
                        $prev_profile = $this->beats_model->select_data('c_profile','artist_registration',array('user_id'=>$session_id));
		            	if(!empty($prev_profile) && $prev_profile[0]['c_profile']!==''){
		            		unlink('uploads/'.$prev_profile[0]['c_profile']);
		            	}
                          $this->load->helper('string');
                          $rand = random_string('alnum',4);
                          $w=$this->input->post('thumb_width');
                          $h=$this->input->post('thumb_height');
                          $x1=$this->input->post('x_axis');
                          $y1=$this->input->post('y_axis');
                          $img=$this->input->post('img');
			  $new_name = "small".$rand.".jpg"; // Thumbnail image name
                          $path = "./uploads/";
                          list($joe, $alto) = getimagesize($path.$img);
                            $ratio = $joe / 500;
                            $x1 = ceil($x1 * $ratio);
                            $y1 = ceil($y1 * $ratio);
                            $wd = ceil($w * $ratio);
                            $ht = ceil($h * $ratio);
                            $nw = 260;// Maximum thumbnail width
                            $nh = 260;//Maximum thumbnail height
                            $nimg = imagecreatetruecolor($nw,$nh);
                            $im_src = imagecreatefromjpeg($path.$img);
                            imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$wd,$ht);
                            imagejpeg($nimg,$path.$new_name,90);
                             $result= array('c_profile' =>$new_name);
                             $this->db->where('user_id', $session_id);
                             $insertstatus=$this->db->update("artist_registration",$result);
		             return $new_name;
       }
    
}
?>