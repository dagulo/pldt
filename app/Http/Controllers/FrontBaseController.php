<?php

namespace App\Http\Controllers;

use Helpers\Layout;
use Illuminate\Routing\Controller;

class FrontBaseController extends Controller{

    public  $layout;

    public function __construct()
    {
        view()->addLocation( app_path().'/Http/Views' );

        // default layout
        $this->layout = view( 'layouts.layout_bootstrap' );

        //load js plugins
        Layout::loadVue();
        Layout::loadToastr();
    }

    public function setLayout( $layout )
    {
        $this->layout = view( $layout );
    }
}