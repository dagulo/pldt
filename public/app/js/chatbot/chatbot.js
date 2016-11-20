
var app, text, dialogue, response, start, stop, is_open;
var SERVER_PROTO, SERVER_DOMAIN, SERVER_PORT, ACCESS_TOKEN, SERVER_VERSION, TTS_DOMAIN;

is_open = false;
initialized = false;
app = null;

var chatVue = new Vue({
    el:'#chatDiv',
    data:{
        threads: [],
        parameters:{},
        account:{},
        ticket_id: ''
    },
    methods:{
        toggle:function(){

            if( app === null ){
                app = new App();
            }
            if( is_open === false ){
                app.start();
                return;
            }
            app.stop();
        },
        chat:function(){

            var qval = $('#q').val();

            if(  qval == '' ){
                toastr.error( ' Chat entry must not be empty ' );
                return;
            }

            chat_obj = { by: 'Customer ', message: qval };
            chatVue.$data.threads.push( chat_obj );

            if( this.processParameters( qval ) !== null ){
                return;
            }

            chat_obj = { by: '<span style="color:red">Dothy</span>', message: '<i class="fa fa-refresh fa-spin"></i> ' };
            chatVue.$data.threads.push( chat_obj );

            idx = chatVue.$data.threads.length - 1;

            $.post( '/ajax/chat' , $( '#cForm' ).serialize() )
            .done( function( data ){
                if( data.success ){

                    chat_obj = { by: '<span style="color:red">Dothy</span>', message: data.response.result.fulfillment.speech };
                    Vue.set( chatVue.$data.threads, idx, chat_obj );
                    $('#q').val('');

                    chatVue.$data.parameters = data.response.result.parameters;
                    chatVue.doNowParameters( data.response );
                }else{
                    toastr.error( data.message );
                }
            }).error(function( data ){
                toastr.error('Something went wrong');
            });

        },
        refresh:function(){
            this.threads = [];
        },
        doNothing:function(){
            return null;
        },
        doNowParameters:function( response )
        {
            switch( this.parameters.doNow ){
                case 'activateFaq':
                    $('#question').val( response.result.resolvedQuery );
                    searchVue.ask();
                break;
            }
        },
        processParameters:function( q )
        {
            switch( this.parameters.process ){
                case 'getBillExpectAccountNum':
                    // next chat message expected is numeric
                    account_number = q.replace(/\D/g, '' );
                    chat_obj = { by: '<span style="color:red">Dothy</span>', message: 'One moment pls while we process your request' };
                    chatVue.$data.threads.push( chat_obj );

                    $.post( '/ajax/chat/getAccountBill' , { _token: $('input[name="_token"]').val() , account_id: account_number   } )
                    .done(function( data ){
                        if( data.success ){
                            chat_obj = { by: '<span style="color:red">Dothy</span>', message: '<i class="fa fa-refresh fa-spin"></i> ' };
                            chatVue.$data.threads.push( chat_obj );

                            idx = chatVue.$data.threads.length - 1;
                            chatVue.$data.account = data.account;
                            // just delay reply
                            setTimeout( function(){
                                message = 'Hello '+data.account.account_first_name+', your account balance is $'+data.account.current_bill
                                +' due on '+data.account.due
                                +'. Do you want to pay online ? Type yes if you want to pay online' ;
                                chat_obj = { by: '<span style="color:red">Dothy</span>', message: message };
                                Vue.set( chatVue.$data.threads, idx, chat_obj );
                            }, 3000 );

                            $('#q').val('');
                            chatVue.$data.parameters = { process: 'PayOnline'};
                        }else{
                            toastr.error( data.message );
                        }
                    })
                    .error(function( data ){
                        toastr.error('Something went wrong');
                    });
                break;
                case 'PayOnline':
                    if( q == 'yes'){
                        chat_obj = { by: '<span style="color:red">Dothy</span>',
                            message: 'Please wait while I open a payment window ' +
                            'at the box on the right' };
                        chatVue.$data.threads.push( chat_obj );
                        // open payment window
                        this.openPaymentWindow( 'payment' );
                        return true;
                    }

                    return null;
                break;
                case 'geocity':
                    $.get( '/ajax/city/coordinates' , {city:this.parameters.geocity})
                    .done(function( data ){
                        if(data.success){
                            lVue.$data.location = data.city;
                            lVue.$data.lon = data.city.lon;
                            lVue.$data.lat = data.city.lat;

                            if( q == 'show map'){
                                initMap();
                                $("#map").css({ opacity: 1, zoom: 1 });
                            }

                            chatVue.$data.parameters = [];
                        }else{
                           toastr.error( data.message );
                        }
                    })
                    .error(function( data ){
                        toastr.error('Something went wrong');
                    });
                break;
                default:
                    return this.processQuery( q );
                break;
            }
        },
        openPaymentWindow:function( q ){
            $('#paymentModal').modal();
        },
        pay:function()
        {
            $('#pay').html('<i class="fa fa-refresh fa-spin"></i>');
            $.post( '/ajax/pay' , { _token:$('input[name="_token"]').val() , acct_id:chatVue.account.account_id } )
            .done( function( data ){
                if(data.success){
                    setTimeout( function(){
                        chat_obj = { by: '<span style="color:red">Dothy</span>', message: 'Payment successfully received. Your account balance is now P'+data.account.current_bill };
                        chatVue.$data.threads.push( chat_obj );
                    }, 3000 );

                    $('#paymentModal').modal( 'toggle' );
                }else{
                   toastr.error( data.message );
                }
                $('#pay').html('Pay with PayMaya');
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        processQuery:function( q ){
            switch( q ){
                case 'open complaint form':
                    this.openComplaintForm();
                    return true;
                break;
                case 'open map':


                break;
            }

            return null;
        },
        openComplaintForm:function()
        {
            $('#complaintModal').modal();
        },
        populateComplaintForm:function()
        {
            // auto-populate:: just dummy text for now to hasten form fillup
            $('#name').val( 'Maria Diaz');
            $('#landline').val( '082-2820991');
            $('#email').val( 'maria@gmail.com' );
            $('#complaint').val( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum' );
        },

        submitComplaintForm:function()
        {
            $( '.btn' ).prop( 'disabled', true );
            $( '#sbn' ).html( '<i class="fa fa-refresh fa-spin"></i>' );

            setTimeout( function(){
                var text = "";
                var length = 8;
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                for (var i = 0; i < length; i++) {
                    text += possible.charAt(Math.floor(Math.random() * possible.length));
                }

                chatVue.$data.ticket_id =  text;
                $('.cc').addClass( 'hide' );
                $('#ticketDiv').removeClass( 'hide' );
                $( '.btn' ).prop( 'disabled', false );
                $( '#sbn' ).html( 'Submit' );
            }, 2000 );

        }




    },
    ready:function(){

    }
});

SERVER_PROTO    = 'wss';
SERVER_DOMAIN   = 'api-ws.api.ai';
TTS_DOMAIN      = 'api.api.ai';
SERVER_PORT     = '4435';
ACCESS_TOKEN    = 'db3277781bf243728265c2d00e3bd0ec';
SERVER_VERSION  = '20150910';

window.onload = function () {
    text = $('#text');
    dialogue = $('#dialogue');
    response = $('#response');
    start = $('#start');
    stop = $('#stop');
    $('server').innerHTML = SERVER_DOMAIN;
    $('token').innerHTML = ACCESS_TOKEN;

};

function App() {
    var apiAi, apiAiTts;
    var isListening = false;
    var sessionId = _generateId(32);

    this.toggle = function(){
        if( is_open ){
            this.stop();
            return
        }
        this.start();
    };

    this.start = function () {
        //start.className += ' hidden';
        //stop.className = stop.className.replace('hidden', '');
        _start();
        is_open = true;
        $('#mic').css( 'color', 'orange');
    };
    this.stop = function () {
        _stop();
        //stop.className += ' hidden';
        //start.className = start.className.replace('hidden', '');
        is_open = false;
        $('#mic').css( 'color', 'black');
    };

    this.sendJson = function () {
        var query = text.value,
            queryJson = {
                "v": SERVER_VERSION,
                "query": query,
                "timezone": "GMT+6",
                "lang": "en",
                //"contexts" : ["weather", "local"],
                "sessionId": sessionId
            };

        console.log('sendJson', queryJson);

        apiAi.sendJson(queryJson);
    };

    this.open = function () {
        console.log('open');
        apiAi.open();
    };

    this.close = function () {
        console.log('close');
        apiAi.close();
    };

    this.clean = function () {
        dialogue.innerHTML = '';
    };

    _init();


    function _init() {
        console.log('init');

        /**
         * You can use configuration object to set properties and handlers.
         */
        var config = {
            server: SERVER_PROTO + '://' + SERVER_DOMAIN + ':' + SERVER_PORT + '/api/ws/query',
            serverVersion: SERVER_VERSION,
            token: ACCESS_TOKEN,// Use Client access token there (see agent keys).
            sessionId: sessionId,
            lang: 'en',
            onInit: function () {
                console.log("> ON INIT use config");
            }
        };
        apiAi = new ApiAi(config);

        /**
         * Also you can set properties and handlers directly.
         */
        apiAi.sessionId = '1234';

        apiAi.onInit = function () {
            console.log("> ON INIT use direct assignment property");
            apiAi.open();
        };

        apiAi.onStartListening = function () {
            console.log("> ON START LISTENING");
        };

        apiAi.onStopListening = function () {
            console.log("> ON STOP LISTENING");
        };

        apiAi.onOpen = function () {
            console.log("> ON OPEN SESSION");

            /**
             * You can send json through websocet.
             * For example to initialise dialog if you have appropriate intent.
             */
            apiAi.sendJson({
                "v": "20150512",
                "query": "hello",
                "timezone": "GMT+6",
                "lang": "en",
                //"contexts" : ["weather", "local"],
                "sessionId": sessionId
            });

        };

        apiAi.onClose = function () {
            console.log("> ON CLOSE");
            apiAi.close();
        };

        /**
         * Reuslt handler
         */
        apiAi.onResults = function (data) {
            console.log("> ON RESULT", data);

            var status = data.status,
                code,
                speech;

            if (!(status && (code = status.code) && isFinite(parseFloat(code)) && code < 300 && code > 199)) {
                //dialogue.innerHTML = JSON.stringify(status);
                return;
            }

            speech = (data.result.fulfillment) ? data.result.fulfillment.speech : data.result.speech;
            // Use Text To Speech service to play text.
            apiAiTts.tts(speech, undefined, 'en-US');

            dialogue.innerHTML += ('user : ' + data.result.resolvedQuery + '\napi  : ' + speech + '\n\n');
            response.innerHTML = JSON.stringify(data, null, 2);

            if( initialized === true ) {
                chat_obj = {by: 'Customer ', message: data.result.resolvedQuery};
                chatVue.$data.threads.push(chat_obj);
                $('#q').val( data.result.resolvedQuery );
            }

            chat_obj = { by: '<span style="color:red">Dothy</span>', message: speech };
            chatVue.$data.threads.push( chat_obj );
            initialized = true;
            app.stop();

            //text.innerHTML = '';// clean input
        };

        apiAi.onError = function (code, data) {
            apiAi.close();
            console.log("> ON ERROR", code, data);
            //if (data && data.indexOf('No live audio input in this browser') >= 0) {}
        };

        apiAi.onEvent = function (code, data) {
            console.log("> ON EVENT", code, data);
        };

        /**
         * You have to invoke init() method explicitly to decide when ask permission to use microphone.
         */
        apiAi.init();

        /**
         * Initialise Text To Speech service for playing text.
         */
        apiAiTts = new TTS(TTS_DOMAIN, ACCESS_TOKEN, undefined, 'en-US');

    }

    function _start() {
        console.log('start');
        isListening = true;
        apiAi.startListening();
    }

    function _stop() {
        console.log('stop');

        apiAi.stopListening();
        isListening = false;
    }

    function _generateId(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for( var i = 0; i < length; i++ ){
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

}

/***
function $(id) {
    return document.getElementById(id);
}
**/