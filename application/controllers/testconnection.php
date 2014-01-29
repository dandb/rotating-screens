<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testconnection extends CI_Controller {

    function __construct()
    {

    }

    function index()
    {
        echo "testconnection";
        phpinfo();
    }
}