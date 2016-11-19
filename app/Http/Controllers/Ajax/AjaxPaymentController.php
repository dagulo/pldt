<?php

namespace App\Http\Controllers\Ajax;

use ApiAi\Client;
use ApiAi\Method\QueryApi;
use ApiAi\Model\Query;
use App\Http\Models\Accounts;
use Helpers\Layout;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AjaxPaymentController extends Controller{

    public function pay( Request $r )
    {
        // PayMaya stuff here
        // unable to accommodate PayMaya for lack of time

        // for now just update the account to zero
        if( ! $account = Accounts::find( $r->acct_id ) ){
            return [
                'success' =>false,
                'message' => 'Payment Failed'
            ];
        }
        //
        $account->current_bill = 0;
        $account->save();

        return [
            'success' =>true,
            'account' => $account
        ];
    }
}