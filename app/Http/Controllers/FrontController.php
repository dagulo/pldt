<?php

namespace App\Http\Controllers;

use Helpers\Layout;
use Illuminate\Http\Request;

class FrontController extends FrontBaseController{

    public function __construct(){
        parent::__construct();
        $this->setLayout( 'layouts.layout_bootstrap' );
    }

    public function index()
    {
        $this->layout->content = view( 'front.front_index' );
        $this->indexAssets();
        return $this->layout;
    }

    public function ask()
    {
        Layout::loadToastr();

        Layout::instance()->addScript( '/plugins/apiai/target/api.ai.min.js' );
        Layout::instance()->addScript( '/app/js/chatbot/chatbot.js' );
        Layout::instance()->addScript( 'https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.jquery.min.js' );
        Layout::instance()->addScript( '/app/js/gmap/gmap.js' );
        Layout::instance()->addScript( 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCS_4gXSMr2y4J-rtfEe8f1XXScL1yx_co&callback=initMap' );
        Layout::instance()->addScript( '/app/js/search/search.js' );


        $this->layout->content = view( 'front.ask' );

        return $this->layout;
    }

    public function complain()
    {
        $this->layout->content = view( 'front.complain' );
        $this->indexAssets();
        return $this->layout;
    }

    /**
     * Login
     */
    public function login( Request $r )
    {
        if( $r->isMethod( 'post' ) ){
            if( $user = \Auth::attempt( array( 'email' => $r->username, 'password' => $r->pwd  )  ) ){
                return redirect( 'admin/dashboard' );
            }
        }

        $this->layout->content = view( 'front.login' );
        $this->indexAssets();
        return $this->layout;
    }

    public function logout( Request $r )
    {
        \Auth::logout();
        return redirect('login');
    }

    private function indexAssets()
    {
        Layout::loadFileupload();
        Layout::instance()->addScript( 'app/js/front/login.js' );
    }

}