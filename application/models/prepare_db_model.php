<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 10/2/13
 * To change this template use File | Settings | File Templates.
 */

class Prepare_db_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }


    public function prepareTables()
    {
        $this->_createDashboardTable();
        $this->_createIonAuthUsersTable();
        $this->_createIonAuthGroupsTable();
        $this->_createIonAuthUsersGroupsTable();
        $this->_createIonAuthLoginAttemptsTable();
    }


    private function _createIonAuthUsersTable()
    {
        if (!($this->db->table_exists('users'))) {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '39',
            ),
            'username' => array(
                'type' =>'VARCHAR',
                'constraint' => '100',
            ),
            'password' => array(
                'type' =>'VARCHAR',
                'constraint' => '80',
            ),
            'salt' => array(
                'type' =>'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
            ),
            'email' => array(
                'type' =>'VARCHAR',
                'constraint' => '100',
            ),
            'activation_code' => array(
                'type' =>'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
            ),
            'forgotten_password_code' => array(
                'type' =>'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
            ),
            'forgotten_password_time' => array(
                'type' =>'INT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'remember_code' => array(
                'type' =>'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
            ),
            'created_on' => array(
                'type' =>'INT',
                'unsigned' => TRUE,
            ),
            'last_login' => array(
                'type' =>'INT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'active' => array(
                'type' =>'INT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'first_name' => array(
                'type' =>'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'last_name' => array(
                'type' =>'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
            'office_location' => array(
                'type' =>'INT',
                'constraint' => 11,
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);

        $this->dbforge->create_table('users',TRUE);

        $newUser = array(
            'ip_address'                => '0x7f000001' ,
            'username'                  => 'administrator' ,
            'password'                  => '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4' ,
            'salt'                      => '9462e8eee0' ,
            'email'                     => 'admin@admin.com' ,
            'activation_code'           => '' ,
            'forgotten_password_code'   => NULL,
            'created_on'                => time() ,
            'last_login'                => time() ,
            'active'                    => '1' ,
            'first_name'                => 'Admin' ,
            'last_name'                 => 'istrator' ,
            'office_location'           => '1',
        );
        $this->db->insert('users', $newUser);
        }
    }

    private function _createIonAuthUsersGroupsTable()
    {
        if (!($this->db->table_exists('users_groups'))){
                $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE
                ),
                'user_id' => array(
                    'type' => 'INT',
                ),
                'group_id' => array(
                    'type' =>'INT',
                ),

            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('users_groups',TRUE);

            $newUser = array(
                'id'        => '1' ,
                'user_id'   => '1' ,
                'group_id'  => '1' ,

            );
            $this->db->insert('users_groups', $newUser);
            $newUser = array(
                'id'        => '2' ,
                'user_id'   => '1' ,
                'group_id'  => '2' ,

            );
            $this->db->insert('users_groups', $newUser);
        }
    }

    private function _createIonAuthGroupsTable()
    {
        if (!($this->db->table_exists('groups'))){
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '20',
                ),
                'description' => array(
                    'type' =>'VARCHAR',
                    'constraint' => '100',
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('groups',TRUE);

            $newUser = array(
                'id'            => '1' ,
                'name'          => 'admin' ,
                'description'   => 'Administrator' ,

            );
            $this->db->insert('groups', $newUser);
            $newUser = array(
                'id'            => '2' ,
                'name'          => 'members' ,
                'description'   => 'General User' ,

            );
            $this->db->insert('groups', $newUser);
        }
    }

    private function _createIonAuthLoginAttemptsTable()
    {
        if (!($this->db->table_exists('login_attempts'))){
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'auto_increment' => TRUE
                ),
                'ip_address' => array(
                    'type' => 'VARBINARY',
                    'constraint' => '16',
                ),
                'login' => array(
                    'type' =>'VARCHAR',
                    'constraint' => '100',
                ),
                'time' => array(
                    'type' =>'datetime',
                    'null' => TRUE,
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('login_attempts',TRUE);
        }
    }

    private function _createDashboardTable()
    {
        $fields = array(
            'dashboard_id' => array(
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> TRUE
            ),
            'sort_id' => array(
                'type'          => 'INT',
                'constraint'    => 11,
            ),
            'description' => array(
                'type'          =>'VARCHAR',
                'constraint'    => '50',
            ),
            'URL' => array(
                'type'          =>'VARCHAR',
                'constraint'    => '250',
                'null'          => true
            ),
            'message' => array(
                'type'          =>'VARCHAR',
                'constraint'    => '2000',
                'null'          => true
            ),
            'time_interval'     => array(
                'type'          =>'INT',
                'constraint'    => 11,
            ),
            'category_id'       => array(
                'type'          =>'INT',
                'constraint'    => 11,
            ),
            'office_location'   => array(
                'type'          =>'INT',
                'constraint'    => 11,
            ),
            'activate'  => array(
                'type'          => 'INT',
                'constraint'    => 11
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('dashboard_id', TRUE);
        $this->dbforge->create_table('screens_dashboard',TRUE);

    }
}