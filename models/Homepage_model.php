<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_model extends CI_Model {
    
    public function login($post){
        $this->db->from('login');
        $this->db->WHERE(['username'=>$post->username]);
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
     
    }
    public function imageadd($post){
        $this->db->set($post)->insert('images');
        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }
     
    }
      public function get_image(){
          $this->db->from('images');
          $return_query=$this->db->get();
          if ($return_query->num_rows() > 0){
              return $return_query->row();
          }
          else{
              return false;
          }
       
      }    

}