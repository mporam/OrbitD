<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');

$query = $con->prepare("SELECT id FROM layout WHERE homepage = 1");
$query->execute();
$hp = $query->fetch();

$dashboard = 'layouts/';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Layout | OrbitD Admin</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
    <style data-css="headCSS"></style>
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
                            <input type="text" class="form-control" name="name" required>
                            <div>Page Location: http://<?php echo $_SESSION['site_details']['domain'];?>/orbit-site/<span></span></div>
                        </div>

       			<div class="form-group">
                            <label data-toggle="tooltip" data-placement="right" title="<?php echo (!empty($hp) ? 'Homepage already created' : ''); ?>">
                            	<input type="checkbox" data-toggle="tooltip" data-placement="right" name="homepage"<?php echo (!empty($hp) ? ' disabled' : ''); ?>>
                                Homepage
                            </label>
                        </div>

                        <div class="form-group accordion background-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".background-accordion" href="#background">Background Settings<span class="caret"></span></a>

                            <div id="background" class="panel-collapse collapse">
                                <div class="form-group">
                                    <label>Body background color:</label>
                                    <input type="color" class="form-control" name="layout-colour">
                                </div>
                                <div class="form-group">
                                    <label>Body background image:</label>
                                    <input type="text" class="form-control" name="background-image" placeholder="Click here to select a file" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group accordion container-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".container-accordion" href="#container">Container Settings<span class="caret"></span></a>

                            <div id="container" class="panel-collapse collapse">
                                <label><input type="checkbox" name="container" autocomplete="off" checked>Container</label>
                                <div class="container-color">
                                    <div class="form-group">
                                            <label>Container background colour:</label>
                                            <input type="color" class="form-control" name="container-colour">
                                     </div>
                                     <div class="form-group">
                                         <label>Container background image:</label>
                                         <input type="text" class="form-control" name="container-image" placeholder="Click here to select a file" />
                                     </div>
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
                                <textarea name="script" class="form-control" rows="10"></textarea>
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
            <div id="main">

            </div>
        </div>
    </div>

<div class="modal fade" id="layoutChoice" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="backgroundModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="containerModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="addModule" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="offsetModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div class="modal fade" id="editContentContainer" tabindex="-1" role="dialog" aria-hidden="true"></div>

<div id="updateNavs"></div>

    <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
    <script src="/js/admin/layout-builder.js"></script>
  </body>
</html>