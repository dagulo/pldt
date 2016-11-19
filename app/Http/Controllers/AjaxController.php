<?php

namespace App\Http\Controllers;

use ApiAi\Client;
use ApiAi\Method\QueryApi;
use ApiAi\Model\Query;
use Helpers\Layout;
use Illuminate\Http\Request;

class AjaxController extends Controller{

    public function chat( Request $r )
    {

        if( ! $r->q ) {
            return [
                'success' =>false,
                'message' => 'Invalid query'
            ];
        }

        $token = env( 'APIAI_CLIENT' );

        try{

            $client = new Client( $token );
            $queryApi = new QueryApi( $client );

            $session_id = session()->getId();
            $session_id = substr( $session_id , 0 , 7  );

            $meaning = $queryApi->extractMeaning( $r->q , [
                'sessionId' =>  $session_id,
                'lang' => 'en',
            ]);

            $response = new Query( $meaning );

        }catch (\Exception $error ){
            $message =  $error->getMessage();

            return [
                'success' =>false,
                'message' => $message
            ];
        }

        return [
            'success' =>true,
            'response' => $response
        ];

    }

}