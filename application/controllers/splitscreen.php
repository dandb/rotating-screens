<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Splitscreen extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Splitscreen_model');
    }

    public function index()
    {
        $this->data['listOfUrls'] = $this->Splitscreen_model->getSplitScreenDashboard();
        $this->load->view('splitscreen/index', $this->data);
    }

    public function show()
    {

        $this->data['listOfUrls'] = $this->Splitscreen_model->getSplitScreenDashboard();
        $this->load->view('splitscreen/show',$this->data);
    }

    public function update()
    {
        $arrayToBeUpdated = json_decode($_POST['postData']);

        $this->Splitscreen_model->updateSplitScreenDashboard($arrayToBeUpdated);

    }
}