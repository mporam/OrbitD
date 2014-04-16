<?php
if (empty($_GET['id'])) {
    header("Location: /orbit-admin/layouts/new/");
    exit;
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');
    $id = $_GET['id'];

    $query = $con->prepare("SELECT * FROM layout WHERE `id` = '$id'");
    $query -> execute();
    $layout = $query->fetch(PDO::FETCH_ASSOC);
}

$query = $con->prepare("SELECT id FROM layout WHERE `homepage` = 1 AND `id` <> $id");
$query->execute();
$hp = $query->fetch();

if (empty($layout)) {
    header("Location: /orbit-admin/layouts/new/");
    exit;
}
$dashboard = 'layouts/';
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Layout <?php echo $layout['name']; ?> | OrbitD Admin</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
    <style data-css="headCSS">
        <?php echo $layout['head']; ?>
    </style>
    <script>
        var lID = <?php echo $_GET['id']; ?>;
    </script>
</head>
<body>
    <div id="template-builder">
        <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/topbar.php'); ?>

        <div id="edit-layout" class="sidebar">
            <div class="sidebar-inner">
                <form>
                    <div class="sidebar-options">
                        <h4>Edit Page Layout</h4>
                        <div class="form-group">
                            <label>Page Name:</label>
                            <input type="text" class="form-control" name="name" required value="<?php echo $layout['name']; ?>">
                            <div>Page Location: http://<?php echo $_SESSION['site_details']['domain'];?>/orbit-site/<span><?php echo str_replace(" ", "-", $layout['name']); ?></span>/</div>
                        </div>

                        <div class="form-group">
                            <label data-toggle="tooltip" data-placement="right" title="<?php echo (!empty($hp) ? 'Homepage already created' : ''); ?>">
                            	<input type="checkbox" name="homepage"<?php if($layout['homepage']) echo " checked='checked'"; echo (!empty($hp) ? ' disabled' : ''); ?>>
                                Homepage
                            </label>
                        </div>

                        <div class="form-group accordion background-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".background-accordion" href="#background">Background Settings<span class="caret"></span></a>

                            <div id="background" class="panel-collapse collapse">
                                <label>Body background color:</label>
                                <input type="color" class="form-control" name="layout-colour">
                                <label>Body background image:</label>
                                <input type="text" class="form-control" name="background-image" placeholder="Click here to select a file" />
                            </div>
                        </div>

                        <div class="form-group accordion container-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".container-accordion" href="#container">Container Settings<span class="caret"></span></a>

                            <div id="container" class="panel-collapse collapse">
                                <label><input type="checkbox" name="container" autocomplete="off"<?php if ($layout['container']) echo " checked='checked'"; ?>> Container</label>
                                <div class="container-color">
                                    <label>Container background colour:</label>
                                    <input type="color" class="form-control" name="container-colour">
                                    <label>Container background image:</label>
                                    <input type="text" class="form-control" name="container-image" placeholder="Click here to select a file" />
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs" id="editSettings">
                            <li class="active"><a href="#content">Edit Layout</a></li>
                            <li><a href="#module">Edit Modules</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="content">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a data-action="add-content" href="#addContent">Add Content Container</a></li>
                                    <li><a data-action="layout-choice" href="#layoutChoice">Change Layout</a></li>
                                </ul>
                            </div>

                            <div class="tab-pane" id="module">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a data-action="select-module" href="#addModule">Add Module</a></li>
                                    <li><a href="/orbit-admin/new-module">Create New Module</a></li>
                                </ul>
                            </div>
                        </div>

						<?php if ($_SESSION['site_details']['orbitType'] == 'dev') { ?>
                        <div class="form-group accordion js-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".js-accordion" href="#js">JavaScript<span class="caret"></span></a>

                            <div id="js" class="panel-collapse collapse">
                                <label>JavaScript:</label>
                                <textarea name="script" class="form-control" rows="10"><?php echo $layout['script']; ?></textarea>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <div class="actions">
                        <button type="button" data-action="preview" class="btn btn-lg btn-default">Preview</button>
                        <input type="submit" class="btn btn-lg btn-primary" data-action="save-layout" value="Save">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm-10" id="builder">
        	<div id="notifications"></div>
            <div id="main" style='background: <?php echo $layout['background']; ?>;'>
                <?php echo $layout['content']; ?> 
            </div>
        </div>
    </div>

<div class="modal fade" id="layoutChoice" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Choose a layout</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Changing layout will remove all current layout containers and modules!</div>
                <p>Choose from a set layout below or start with a blank page. All layouts are fully editable</p>

                <p>Add a fixed width container <input type="checkbox" name="container" autocomplete="off"></p>

                <div class="center">
                    Loading&hellip;
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Dashboard</button>
                <button type="button" class="btn btn-primary" data-action="save" disabled="disabled">Create Layout</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="backgroundModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="addModule" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="offsetModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="editContentContainer" tabindex="-1" role="dialog" aria-hidden="true"></div>

    <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
    <script src="/js/admin/layout-builder.js"></script>
    <script>request.id = <?php echo $_GET['id']; ?>;</script>
  </body>
</html>