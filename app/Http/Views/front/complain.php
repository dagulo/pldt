<div id="cDiv" style="margin-top: 24px">
    <div class="col-lg-6" id="searchDiv">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-right">
                    <a href="javascript:" class="" v-on:click="populateComplaintForm"><i class="fa fa-refresh"></i></a>
                </div>
                <h2><b>Complaint Form</b></h2>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Landline Plus Area Code</label>
                    <input type="text" name="landline" id="landline" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" id="email" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Complaint</label>
                    <textarea name="complaint" id="complaint" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" v-on:click="submitComplainForm"> Submit </button>
                </div>
            </div>
        </div>
    </div>
</div>
