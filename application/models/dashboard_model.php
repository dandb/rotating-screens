<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 9/16/13
 * Time: 4:42 PM
 * To change this template use File | Settings | File Templates.
 */

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('constant');
    }

    public function getEntriesFrom($userOfficeLocation)
    {
        $query = $this->db->where('office_location',$userOfficeLocation)
            ->order_by("sort_id", "asc")
            ->get($this->lang->line('dashboard_table'))
            ->result_array();
        return $query;
    }

    public function getMaxSortId()
    {
        $query = $this->db->select_max('sort_id')
            ->get($this->lang->line('dashboard_table'))
            ->result_array();
        $maxSortId = $query[0];
        return $maxSortId['sort_id'];
    }

    public function addToDashboardTableWith($newEntry,$isAdmin)
    {
        if(!$isAdmin){
            $this->db->insert($this->lang->line('dashboard_table'), $newEntry);
        } else {
            $addToLocations = $newEntry['office_location'];
            for($i=0;$i<count($addToLocations);$i++){
                $newEntry['office_location'] = $addToLocations[$i];
                $this->db->insert($this->lang->line('dashboard_table'), $newEntry);
            }
        }
    }

    public function changeOrderOfTable($arrayOfDashboardEntries)
    {
        foreach ($arrayOfDashboardEntries as $newSortID => $dashboardID){
            $data = array('sort_id' => $newSortID+1);
            $this->db->where('dashboard_id',$dashboardID)
                ->update($this->lang->line('dashboard_table'),$data);
        }
    }

    public function deleteEntryOf($dashboardID){
        $this->db->where('dashboard_id', $dashboardID)
            ->delete($this->lang->line('dashboard_table'));
    }

    public function editEntryOf($dataOfDashboardEntry){

        $data = array(
            'description'       => $dataOfDashboardEntry['edit_description'],
            'URL'               => $dataOfDashboardEntry['edit_URL'],
            'time_interval'     => $dataOfDashboardEntry['edit_time-interval'],
            'category_id'       => $dataOfDashboardEntry['edit_category'],
        );
        $this->db->where('dashboard_id', $dataOfDashboardEntry['edit_dashboardId'])
            ->update($this->lang->line('dashboard_table'),$data);
    }

    public function returnDescription($dashboardID){
        $query = $this->db->where('dashboard_id',$dashboardID)
            ->get($this->lang->line('dashboard_table'))
            ->result_array();
        $result = $query[0];
        return $result['description'];

    }
}