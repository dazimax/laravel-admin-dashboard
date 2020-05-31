<?php

namespace App\Http\Controllers;

use App\Http\Controllers\View;
use App\CoreConfig;
use DB;

class BaseController extends Controller
{
    //define return response params
    public    $msg = '';
    public    $status = false;
    public    $data = null;
    protected $site_settings;

    /**
     * __construct
     * 
     * @return void
     * 
     * @access public
     */
    public function __construct()
    {
        //show system logo on each views
        $settingsObj = new CoreConfig();
        $settingsObj->setConfigurationsValues();
    }

}
