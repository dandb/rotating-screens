<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Prepare_db_model');
        $this->load->helper('url');
    }

    public function index()
    {
        //this controller is to create tables they do not exist yet;
        echo "hello";
        $this->Prepare_db_model->prepareTables();
        redirect('auth/login');
    }


}