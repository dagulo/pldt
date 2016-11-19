<?php

namespace App\Http\Controllers\Ajax;

use ApiAi\Client;
use ApiAi\Method\QueryApi;
use ApiAi\Model\Query;
use App\Http\Models\Accounts;
use Helpers\Layout;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AjaxChatController extends Controller{

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

    public function getAccountBill( Request $r )
    {
        if( ! $account =  Accounts::find( $r->account_id ) ){
            return [
                'success' => false,
                'message' => 'Account not found'
            ];
        }

        $account->due = date( 'D M d, Y' , strtotime( $account->billing_due ) );
        return [
            'success' => true,
            'account' => $account
        ];

    }
}