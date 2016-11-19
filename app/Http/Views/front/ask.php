
<div id="cDiv" style="margin-top: 24px">
    <div class="col-lg-4">
        <div class="panel panel-default" id="chatDiv">
            <div class="panel-body">
                <div id="paymentModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Payment Form</h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6">Account Name:</div>
                                        <div class="col-lg-6">{{account.account_last_name}}, {{account.account_first_name}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">Account Number:</div>
                                        <div class="col-lg-6">{{account.account_id}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">Due Date:</div>
                                        <div class="col-lg-6">{{account.due}}</div>
                                    </div>

                                </div>
                                <div class="col-lg-6" style="text-align:center">
                                    <h2><b>P {{account.current_bill}}</b></h2>

                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-on:click="pay()">Pay with PayMaya</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="q">CHAT SUPPORT</label>
                </div>
                <form id="cForm" v-on:submit.prevent="doNothing">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="" id="q" name="q" @keyup.enter="chat()" />
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" v-on:click="toggle"><i class="fa fa-microphone" id="mic"></i></button>
                    </span>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" v-on:click="chat()"><i class="fa fa-arrow-right" id="arrow-right"></i></button>
                    </span>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" v-on:click="refresh()"><i class="fa fa-refresh" id="ref"></i></button>
                    </span>
                </div>
                <?php echo csrf_field() ?>
                </form>
                <br />
                <ul class="list-group" style="overflow-y: auto;max-height: 400px">
                    <li class="list-group-item" v-for="t in threads">
                        <!--<img src="" alt="User Avatar" v-bind:src="t.avatar" class="img-circle" style="height:24px" />-->
                        <strong v-html="t.by"></strong>
                        <div v-html="t.message"></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8" id="searchDiv">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="question"> ASK ME </label>
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="" id="question" name="question" @keyup="ask()" />
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" v-on:click="ask()"> Ask </button>
                    </span>
                    </div>
                </div>
                <div>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="r in results">
                            <strong><a href="javascript:" v-on:click="answer()">{{r.question}}</a></strong>
                            <div>
                                {{r.tags}}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-4" id="mapDiv">
    </div>
    <div class="col-lg-8" id="mapDiv">
        <div id="map" style="width:100%;height:420px;"></div>
    </div>
    <div id="mapModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


