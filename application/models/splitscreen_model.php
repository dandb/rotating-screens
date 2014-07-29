<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 6/26/14
 * Time: 11:25 PM
 * To change this template use File | Settings | File Templates.
 */
class Splitscreen_model extends CI_Model {

    public function getEntriesFrom($userOfficeLocation)
    {
//        $query = $this->db->where('screen_1',$userOfficeLocation)
//            ->order_by("sort_id", "asc")
//            ->get($this->lang->line('dashboard_table'))
//            ->result_array();

        $query = $this->db->get('splitscreen_dashboard');
        return $query;
    }
    //@TODO: Ability to add if doesnt exist?
    public function addToDashboardTableWith($newEntry)
    {
        $this->db->insert('splitscreen_dashboard', $newEntry);
    }

    public function getSplitScreenDashboard()
    {
        $arResponse = $this->db->order_by("screen", "asc")
            ->get('splitscreen_dashboard')
            ->result_array();

        return $arResponse;
    }

    public function updateSplitScreenDashboard($postData)
    {
        for ($i = 0; $i < 6 ; $i++) {
            $data = array (
                'screen'    => $i+1,
                'url'       => $postData[$i]
            );

        $this->db->where('screen', $i+1);
        $this->db->update('splitscreen_dashboard', $data);

        }

        //@TODO: Throw exception
    }
}