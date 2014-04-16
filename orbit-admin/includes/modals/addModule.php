<div class="modal-dialog large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add a module</h4>
            </div>
            <div class="modal-body">
                <p>Choose from your list of modules below or <a href="/orbit-admin/new-module">Create a new one</a>.</p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="list-group">
                            <a href="navigation" class="list-group-item">Navigation</a>
                            <a href="jumbatron" class="list-group-item">Jumbatron</a>
                            <a href="module-1" class="list-group-item">Module 1</a>
                            <a href="module-2" class="list-group-item">Module 2</a>
                            <a href="module-3" class="list-group-item">Module 3</a>
                            <a href="footer" class="list-group-item">Footer</a>
                            <!-- this will be generated in php -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default" id="preview">
                            <div class="panel-heading">
                                <h3 class="panel-title">Preview</h3>
                            </div>
                            <div class="panel-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="button" class="btn btn-primary" data-action="add-module" disabled="disabled">Add Module</button>
            </div>
        </div>
    </div>