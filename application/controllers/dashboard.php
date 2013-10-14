<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    private $_updatedDashboardURLs;
    private $_updatedDashboardTimeIntervals;
    private $_updatedDashboardIds;

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');


        //create tables in the db if they do not exist yet
        $this->load->model('Prepare_db_model');
        $this->Prepare_db_model->prepareTables();

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
        $this->load->library('mongo_db') :

        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->lang->load('constant');
        $this->load->helper('language');
        $this->load->model('Dashboard_model');
        //initialize private variables
        $this->updateDashboardEntries();
    }

    public function index()
    {
        if(!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');

        } else {
            //grabbing entries for table
            $this->data['isAdmin'] = $this->ion_auth->is_admin();
            $this->data['userId'] = $this->ion_auth->user()->row()->id;
            $this->data['userOfficeLocation'] = $this->ion_auth->user()->row()->office_location;
            $this->data['dashboardEntries'] = $this->Dashboard_model->getEntriesFrom($this->data['userOfficeLocation']);
            $this->data['adminDashboardEntries'] = $this->_adminDashboard();

            $this->data['title'] = $this->lang->line('company_name').$this->lang->line('office_'.$this->data['userOfficeLocation']);
            if($this->data['isAdmin']){$this->data['title'] = $this->lang->line('company_name')."Admin";}
            $this->data['message'] ="";
            /*BEGIN: Add-Form Attributes *******************************************/
            $this->data['add_form_attributes'] = array(
                'name'      => 'addEntry_form',
                'id'        => 'addEntry_form',
                'class'     => 'form-inline',
            );
            $this->data['add_submit_btn_attributes'] = array(
                'name'      => 'add_submit',
                'id'        => 'add_submit',
                'class'     => 'btn btn-primary btn-block btn-add'
            );
            $this->data['add_description'] = array(
                'name'          => 'add_description',
                'id'            => 'add_description',
                'class'         => 'form-control',
                'type'          => 'text',
                'value'         => (isset($_POST['add_description']) ? $_POST['add_description'] : ""),
                'placeholder'   => 'Description'
            );
            $this->data['add_website'] = array(
                'name'          => 'add_website',
                'id'            => 'add_website',
                'class'         => 'form-control website_add',
                'type'          => 'text',
                'placeholder'   => 'Website URL'
            );$this->data['add_twitter'] = array(
                'name'          => 'add_twitter',
                'id'            => 'add_twitter',
                'class'         => 'form-control twitter_add',
                'type'          => 'text',
                'placeholder'   => 'Twitter Keyword'
            );$this->data['add_youtube'] = array(
                'name'          => 'add_youtube',
                'id'            => 'add_youtube',
                'class'         => 'form-control youtube_add',
                'type'          => 'text',
                'placeholder'   => 'Youtube'
            );
            $this->data['add_time_interval'] = array(
                'name'          => 'add_time-interval',
                'id'            => 'add_time-interval',
                'class'         => 'form-control time-interval_add',
                'type'          => 'text',
                'value'         => (isset($_POST['add_description']) ? $_POST['add_time-interval'] : ""),
                'placeholder'   => 'Time(sec)'
            );
            $this->data['add_category'] = array(
                '1' => 'Website',
                '2' => 'Twitter',
                '3' => 'Youtube',
            );
            $this->data['add_select_category'] = (isset($_POST['add_category']) ? $_POST['add_category'] : "1");
            $this->data['add_locationAll'] = array(
                'name'        => 'locationAll',
                'id'          => 'locationAll',
                'value'       => 'All',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location1'] = array(
                'name'        => 'location1',
                'id'          => 'location1',
                'value'       => '1',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location2'] = array(
                'name'        => 'location2',
                'id'          => 'location2',
                'value'       => '2',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location3'] = array(
                'name'        => 'location3',
                'id'          => 'location3',
                'value'       => '3',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location4'] = array(
                'name'        => 'location4',
                'id'          => 'location4',
                'value'       => '4',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location5'] = array(
                'name'        => 'location5',
                'id'          => 'location5',
                'value'       => '5',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location6'] = array(
                'name'        => 'location6',
                'id'          => 'location6',
                'value'       => '6',
                'class'       => 'checkbox-location_add'
            );
            $this->data['add_location7'] = array(
                'name'        => 'location7',
                'id'          => 'location7',
                'value'       => '7',
                'class'       => 'checkbox-location_add'
            );

            $this->data['add_category_attribute'] = "class= 'form-control category-attribute_add' id='add_category'";
            /**END:Add-Form Attributes *******************************************/

            /*BEGIN: Edit-Form Attributes *******************************************/
            $this->data['edit_form_attributes'] = array(
                'name'      => 'editEntry_form',
                'id'        => 'editEntry_form',
            );
            $this->data['edit_submit_btn_attributes'] = array(
                'name'      => 'edit_submit',
                'id'        => 'edit_submit',
                'class'     => 'btn btn-primary btn-edit'
            );
            $this->data['edit_description'] = array(
                'name'          => 'edit_description',
                'id'            => 'edit_description',
                'class'         => 'form-control',
                'type'          => 'text',
                'placeholder'   => 'Description'
            );
            $this->data['edit_website'] = array(
                'name'          => 'edit_website',
                'id'            => 'edit_website',
                'class'         => 'form-control website_edit',
                'type'          => 'text',
                'placeholder'   => 'Website URL'
            );$this->data['edit_twitter'] = array(
                'name'          => 'edit_twitter',
                'id'            => 'edit_twitter',
                'class'         => 'form-control twitter_edit',
                'type'          => 'text',
                'placeholder'   => 'Twitter Keyword'
            );$this->data['edit_youtube'] = array(
                'name'          => 'edit_youtube',
                'id'            => 'edit_youtube',
                'class'         => 'form-control youtube_edit',
                'type'          => 'text',
                'placeholder'   => 'Youtube'
            );
            $this->data['edit_time_interval'] = array(
                'name'          => 'edit_time-interval',
                'id'            => 'edit_time-interval',
                'class'         => 'form-control time-interval_edit',
                'type'          => 'text',
                'placeholder'   => 'Time(sec)'
            );
            $this->data['edit_category'] = array(
                '1' => 'Website',
                '2' => 'Twitter',
                '3' => 'Youtube',
            );$this->data['edit_category_attribute'] = "class= 'form-control category-attribute_edit' id='edit_category'";

            /**END:Edit-Form Attributes *******************************************/

            //form validation - PHP side
            $this->form_validation->set_rules("add_description","Description","required");
            $this->form_validation->set_rules("add_time-interval","Time interval","required|integer");

            if(isset($_POST['add_category'])){
                if($_POST['add_category']==1) {
                    $this->form_validation->set_rules("add_website","Website","required");
                } else if($_POST['add_category']==2) {
                    $this->form_validation->set_rules("add_twitter","Twitter keyword","required");
                } else if($_POST['add_category']==3) {
                    $this->form_validation->set_rules("add_youtube","Youtube","required");
                }
            }
            if ($this->form_validation->run() == FALSE){
                if($this->data['isAdmin']){
                    $this->load->view('dashboard/admin',$this->data);
                } else {
                    $this->load->view('dashboard/index',$this->data);
                }
            }
            else {
                //adding to db table
                if($_POST['add_category'] == 1){
                    $URL = $_POST['add_website'];
                    if(strpos($URL,"http") !== 0){
                        $URL = "http://" . $URL;
                    }

                } else if($_POST['add_category'] == 2) {
                    $twitterKeyword = str_replace("@","%40",$_POST['add_twitter']);
                    $twitterKeyword = str_replace(" ","%20",$twitterKeyword);
                    $twitterKeyword = str_replace("#","%23",$twitterKeyword);
                    $twitterKeyword = $this->lang->line('twitter_baseSearchURL') . $twitterKeyword;

                    $URL = $twitterKeyword;
                }else if($_POST['add_category'] == 3) {
                    $URL = $_POST['add_youtube'] . "&autoplay=1";
                    $URL = str_replace("watch?v=","v/",$URL);
                    if(strpos($URL,"http") !== 0){
                        $URL = "http://" . $URL;
                    }
                }

                $addNewEntryToTable = true;

                //modifying description

//
//
//                $description = urlencode($_POST['add_description']);
//                var_dump($description);exit;
//                $description = $_POST['add_description'];
//                $description = str_replace(" ","%20",$description);
//                $description = str_replace("@","%40",$description);
//                $description = str_replace("&","%26",$description);
//                $description = str_replace("#","%23",$description);

                //checking if host URL is valid
                $hostURL = parse_url($URL,PHP_URL_HOST);
                $ch = curl_init($hostURL);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_exec($ch);
                $returnedCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($returnedCode == 0 || $returnedCode >=400) {

                    $this->data['message'] = "Please enter a valid URL.";
                    $this->data['description'] = $_POST['add_description'];
                    $this->data['time_interval'] = $_POST['add_time-interval'];
                    $this->data['category'] = $_POST['add_category'];
                    $addNewEntryToTable = false;
                }
                curl_close($ch);



                if($addNewEntryToTable){

                    $newEntry = array(
                        'sort_id' => $this->Dashboard_model->getMaxSortId()+1,
                        'description'       => $_POST['add_description'],
                        'URL'               => $URL,
                        'time_interval'     => $_POST['add_time-interval'],
                        'category_id'          => $_POST['add_category'],
                        'office_location'   => $this->data['userOfficeLocation']
                    );
                    //change office location for admin dashboard
                    if($this->data['isAdmin']){
                        $addToOffices = array();

                        for($i = 1; $i<8 ; $i++){
                            if(isset($_POST['location'.$i]) == true){array_push($addToOffices,$i);}
                        }

                        $newEntry['office_location'] = $addToOffices;
                }

                    //TO ADD A NEW ENTRY
                    $this->Dashboard_model->addToDashboardTableWith($newEntry,$this->data['isAdmin']);
                }

                $this->data['dashboardEntries'] = $this->Dashboard_model->getEntriesFrom($this->data['userOfficeLocation']);
                $this->data['adminDashboardEntries'] = $this->_adminDashboard();

                if($this->data['isAdmin']){
                    $this->load->view('dashboard/admin',$this->data);
                } else {
                $this->load->view('dashboard/index',$this->data);
                }
            }
        }
    }

    //returns false when user is not an admin
    private function _adminDashboard(){
        if(!($this->ion_auth->is_admin())){
            return false;

        } else {
            $dashboardEntriesAllLocations = array(
                '1'     => $this->_dashboardEntriesOf(1),
                '2'     => $this->_dashboardEntriesOf(2),
                '3'     => $this->_dashboardEntriesOf(3),
                '4'     => $this->_dashboardEntriesOf(4),
                '5'     => $this->_dashboardEntriesOf(5),
                '6'     => $this->_dashboardEntriesOf(6),
                '7'     => $this->_dashboardEntriesOf(7),
            );
            return $dashboardEntriesAllLocations;
        }
    }

    private function _dashboardEntriesOf($location){
        return $this->Dashboard_model->getEntriesFrom($location);
    }

    public function change_order()
    {
        $this->Dashboard_model->changeOrderOfTable($_POST['arrayOfDashboardEntries']);
    }

    public function delete()
    {
        $this->Dashboard_model->deleteEntryOf($_POST['dashboardID']);
    }

    public function edit()
    {
        $dataOfDashboardEntry = array(
            'edit_description' => $_POST['description'],
            'edit_URL' => $_POST['URL'],
            'edit_time-interval' => $_POST['time_interval'],
            'edit_category' => $_POST['category'],
            'edit_dashboardId'=> $_POST['dashboardId']
        );

        $validURL = true;
        //checking if host URL is valid
        $hostURL = parse_url($_POST['URL'],PHP_URL_HOST);
        $ch = curl_init($hostURL);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $returnedCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($returnedCode == 0 || $returnedCode >=400) {
            echo "0";
        } else {
            echo "1";
            $this->Dashboard_model->editEntryOf($dataOfDashboardEntry);
        }




    }

    public function returningCurrentURLsAndTimeIntervalsAndDescriptions() {
         $URLs = explode(',',$this->_updatedDashboardURLs);
         $TimeIntervals = explode(',',$this->_updatedDashboardTimeIntervals);
         $DashboardIds = explode(',',$this->_updatedDashboardIds);


         echo json_encode(array('urls' => $URLs, 'times' => $TimeIntervals, 'dashboard_ids' => $DashboardIds));
    }

    private function updateDashboardEntries() {
        $userLocation = $this->ion_auth->user()->row()->office_location;
        $dashboardEntries = $this->Dashboard_model->getEntriesFrom($userLocation);
        if(!empty($dashboardEntries)){
            for($i=0;$i<count($dashboardEntries);$i++)
            {
                $arrayOfURLs[$i] = $dashboardEntries[$i]['URL'];
                $arrayOfTimesIntervals[$i] = $dashboardEntries[$i]['time_interval'];
                $arrayOfDescriptions[$i] = $dashboardEntries[$i]['description'];
                $arrayOfDashboardIds[$i] = $dashboardEntries[$i]['dashboard_id'];


            }
            $this->_updatedDashboardURLs = implode(',',$arrayOfURLs);
            $this->_updatedDashboardTimeIntervals = implode(',',$arrayOfTimesIntervals);
            $this->_updatedDashboardIds = implode(',',$arrayOfDashboardIds);
        }
    }

    public function cover($dashboardId) {
        $this->data['cover_title'] = $this->Dashboard_model->returnDescription($dashboardId);
        $this->load->view('dashboard/cover',$this->data);
    }

}

/* End of file dashboard.php */