<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Carousel Settings</h4>
                </div>
                <div class="modal-body">

                    <div class="step" id="step1">
                        <p>Define the settings for your carousel</p>
                        <div class="form-group">
                            <label><input type="checkbox" name="wrap" value="1"> Cycle Continuosly</label>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" name="pause" value="hover"> Pause on hover</label>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" name="arrows" value="1" checked="checked"> Show prev/next controls</label>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" name="pips" value="1" checked="checked"> Show slide pips</label>
                        </div>

                        <div class="form-group">
                            <label>Slide Interval (in milliseconds)</label>
                            <input type="number" value="5000" name="interval" class="form-control">
                        </div>

                        <button type="button" data-step="2" class="btn btn-info btn-next">Next</button>
                    </div>

                    <div class="step" id="step2">
                        <p>Upload the slides for your carousel</p>
                        <form id="slides">
                            <div class="slide">
                                <div class="pull-right">
                                    <span title="Add Another Slide" class="glyphicon glyphicon-plus"></span>
                                    <span title="Delete Slide" class="glyphicon glyphicon-minus"></span>
                                </div>
                                <div class="form-group">
                                    <label for="slide-upload">Slide file</label>
                                    <input type="text" name="slide-image" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Slide Caption</label>
                                    <input type="text" name="slide-caption" class="form-control">
                                </div>
                            </div>
                        </form>
                        <button type="button" data-step="3" class="btn btn-info btn-next">Next</button>
                    </div>

                    <div class="step" id="step3">
                        <div class="alert alert-success">Carousel ready to use!</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" disabled="disabled">Save</button>
                </div>
            </div>
        </div>