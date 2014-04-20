<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Background Image</h4>
            </div>
            <div class="modal-body">
                <p>Settings for the page background image, this will override the website default</p>
                <div id="preview">

                </div>

                <div class="checkbox">
                    <label><input type="checkbox" name="repeat-x" checked="checked">Repeat-x</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="repeat-y" checked="checked">Repeat-y</label>
                </div>
                <div class="form-group">
                    <label>Position (presets)</label>
                    <select name="position" class="form-control">
                        <option value="left top">Left Top</option>
                        <option value="left center">Left Center</option>
                        <option value="left bottom">Left Bottom</option>
                        <option value="right top">Right Top</option>
                        <option value="right center">Right Center</option>
                        <option value="right bottom">Right Bottom</option>
                        <option value="center top">Center Top</option>
                        <option value="center center">Center Center</option>
                        <option value="center bottom">Center Bottom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Position (direct input)</label><input type="text" class="form-control" name="position">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-action="save">Apply Settings</button>
            </div>
        </div>
    </div>