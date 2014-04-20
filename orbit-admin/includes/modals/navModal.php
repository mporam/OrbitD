<?php
ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/data/get_active_saved_layouts.php');
$layouts = ob_get_contents();
ob_end_clean();
?>

<script>
var savedLayouts = <?php echo $layouts; ?>;
</script>

<?php $layouts = json_decode($layouts, true); ?>

<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Navigation Settings</h4>
                </div>
                <div class="modal-body">

                    <div class="step" id="step1">
                        <div class="form-group">
                            <label>Give your navigation a name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>

                        <p>Select the pages for your navigation</p>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Page Layout</th>
                                    <th><input type="checkbox" id="selectall" checked></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($layouts as $layout) { ?>
                                    <tr>
                                        <td><?php echo $layout['name']; ?></td>
                                        <td><input type="checkbox" name="layout[]" value='<?php echo $layout['name']; ?>' checked></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <button type="button" data-step="1" class="btn btn-info btn-next">Previous</button>
                        <button type="button" data-step="2" class="btn btn-info btn-next">Next</button>
                        
                    </div>

                    <div class="step" id="step2">
                        <p>Add custom navigation items</p>
                        <form id="custom-link-form">
                            <div class="form-group">
                                <label>Link Text</label>
                                <input type='text' name='link-text' class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Link Location</label>
                                <div class="input-group">
                                    <span class="input-group-addon">http://</span>
                                    <input type='text' name='link-location' class='form-control' required>
                                </div>
                                <span class="help-block">These links should be declared as whole urls.</span>
                            </div>
                            <input type="submit" value="Add Link" class="btn btn-primary">
                        </form>

                        <div id="custom-links">
                            <h4>Custom Links</h4>

                        </div>

                        <button type="button" data-step="1" class="btn btn-info btn-next">Previous</button>
                        <button type="button" data-step="3" class="btn btn-info btn-next">Next</button>
                    </div>

                    <div class="step" id="step3">
                        <p>Style your navigation.</p>

                        <ul class="nav nav-tabs" id="navType">
                            <li class="active"><a href="#navbar">Horizontal Bar</a></li>
                            <li><a href="#sidebar">Vertical Bar</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="navbar">

                                <form class="settings">
                                    <div class="form-group">
                                        <label><input type="radio" name="type" value="nav-pills" checked="checked">Pills</label>
                                        <label><input type="radio" name="type" value="nav-tabs">Tabs</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="text-color" value="#FFFFFF">
                                        <label>Text Colour</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="active-color" value="#428BCA">
                                        <label>Active Colour</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="hover-color" value="#EEEEEE">
                                        <label>Hover Colour</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="bg-color" value="transparent">
                                        <label>Background Colour</label>
                                    </div>
                                    <div class="form-group">
                                    	<label>
                                        	Round Corners
                                        	<input type="checkbox" name="corners">
                                        </label>
                                    </div>
                                </form>

                                <h4>Preview</h4>
                                <div class="preview">
                                    <nav>
                                        <ul class="nav navbar-nav nav-pills">
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                            <div class="tab-pane" id="sidebar">
                                <form class="settings">
                                    <div class="form-group">
                                        <input type="color" name="text-color" value="#FFFFFF">
                                        <label>Text Colour</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="active-color" value="#428BCA">
                                        <label>Active Colour</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="hover-color" value="#EEEEEE">
                                        <label>Hover Colour</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="color" name="bg-color" value="">
                                        <label>Background Colour</label>
                                    </div>
                                    <div class="form-group">
                                    	<label>
                                        	Round Corners
                                        	<input type="checkbox" name="corners">
                                        </label>
                                    </div>
                                </form>
                                <h4>Preview</h4>
                                <div class="preview">
                                    <nav>
                                        <ul class="nav nav-pills nav-stacked">
                                         </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <button type="button" data-step="2" class="btn btn-info btn-next">Previous</button>
                        <button type="button" data-step="4" class="btn btn-info btn-next">Next</button>
                         
                    </div>

                    <div class="step" id="step4">
                        <div class="alert alert-success">Navigation Complete!</div>
                        <h4>Preview:</h4>
                        <div id="element"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-save" disabled="disabled">Save</button>
                </div>
            </div>
        </div>