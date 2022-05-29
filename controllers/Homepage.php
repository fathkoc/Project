<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage extends Veripay_Controller
{
    function __construct()
    {
        parent:: __construct();
        $this->result = new StdClass();
        $this->result->status = false;
        $this->load->model($this->router->fetch_class() . '_model', 'model');

    }
        public function response()
    {
        echo json_encode($this->result);
        exit();
    }
        public function login(){
            $data=new stdClass();
            $this->form_validation->set_rules('nick','nick alanını doldur','required|xss_clean|trim');
            $this->form_validation->set_rules('password','şifre alanını doldur','required|xss_clean|trim');
            if ($this->form_validation->run() !=FALSE){
                $post=new stdClass();
                $post->nick=$this->input->post('nick',true);
                $post->password=$this->input->post('password',true);
                if (!empty($user=$this->model->login($post))){
                      if (password_verify($post->password,$user->password)){
                        $this->session->set_userdata('user',$post);
                        $this->result->stats=true;
                      }
                      else{
                            $data->error="KULLANCII ADI VEYA ŞİFRE HATALI";
                      }
                }

            }
            $this->response();
            $this->load->view('login',$data);

        }
        public function addimage(){
            $data=new stdClass();
            $post=new stdClass();
            if ($this->session->userdata('images')) {
                $post->img_pet = $this->session->userdata('images')[0];
                $this->session->unset_userdata('images');
            }
            $this->model->imageadd($post);
            $data->image=$this->model->get_image();
            $this->result->status=true;
            $this->response();

            $this->load->view('addimage',$data);

        }
        public function add_image(){
            $uploaded_images = [];
            $config['upload_path'] = 'assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->load->library('Upload', $config);
            if ($this->upload->do_upload('file')) {
                $image_session = $this->session->userdata('images');
                if ($image_session == false) {
                    $uploaded_images = [];
                } else {
                    $uploaded_images = $image_session;
                }
                $uploaded_images[] = 'assets/uploads/' . $this->upload->data('file_name');
                $this->session->set_userdata('images', $uploaded_images);
                pre($this->session->userdata('images'));
            } else {
                $this->output->set_status_header('404');
                print strip_tags($this->upload->display_errors());
                exit;
            }

        }

}