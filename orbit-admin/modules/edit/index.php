<?php
if (empty($_GET['id'])) {
    header("Location: /orbit-admin/modules/new/");
    exit;
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');
    $moduleID = $_GET['id'];

    $query = $con->prepare("SELECT * FROM modules WHERE `id` = '$moduleID'");
    $query -> execute();
    $module = $query->fetch(PDO::FETCH_ASSOC);
}

if (empty($module)) {
    header("Location: /orbit-admin/modules/new/");
    exit;
}

$dashboard = 'modules/';
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Module <?php echo $module['name']; ?> | OrbitD Admin</title>
    
<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>

    <script>
        var moduleType = '<?php echo $module['type']; ?>';
        var moduleSize = '<?php echo $module['size']; ?>';
        var mID = '<?php echo $module['id']; ?>';
        <?php 
            if (!empty($_GET['layoutID'])) {
                echo "var layoutID = '" . $_GET['layoutID'] . "';";
            }
        ?>
    </script>

</head>
<body>
    <div id="template-builder">
       <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/topbar.php'); ?>

        <div class="sidebar">
            <div class="sidebar-inner">
                <form id="new-module" role="form">
                    <div class="sidebar-options">
                        <h4>Edit Module</h4>

                        <div class="form-group default">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required placeholder="Name your module" autocomplete="off" value="<?php echo $module['name']; ?>">
                        </div>

                        <div class="form-group default">
                            <label for="type">Type:</label>
                            <select class="form-control" name="type" id="type" required autocomplete="off">
                                <option selected="selected" value="">Please wait&hellip;</option>
                            </select>
                        </div>

                        <div class="form-group module-size">
                            <label for="size">Size</label>
                            <select class="form-control" id="size" name="size" required autocomplete="off">
                                <option selected="selected" value="">Module Size</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                        <div class="form-group accordion background-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".background-accordion" href="#background">Background <span class="caret"></span></a>

                            <div id="background" class="panel-collapse collapse">
                                <div class="background-container">
                                    <div class="form-group">
                                        <label for="background">Background color:</label>
                                        <input id="background" type="color" class="form-control" name="background">
                                    </div>
                                    <div class="form-group">
	                                    <label for="background-image">Background image:</label>
	                                    <input type="text" class="form-control" name="background-image" placeholder="Background Image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group accordion border-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".border-accordion" href="#border">Border <span class="caret"></span></a>

                            <div id="border" class="panel-collapse collapse">
                                <div class="form-group">
                                    <label for="border-size">Border Size:</label>
                                    <input id="border-size" type="text" class="form-control" name="border-size">
                                </div>
                                <div class="form-group">
                                    <label for="border-style">Border Style:</label>
                                    <select id="border-style" class="form-control" name="border-style">
                                        <option value="dotted">dotted</option>
                                        <option value="dashed">dashed</option>
                                        <option value="solid">solid</option>
                                        <option value="double">double</option>
                                        <option value="groove">groove</option>
                                        <option value="ridge">ridge</option>
                                        <option value="inset">inset</option>
                                        <option value="outset">outset</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="border-colour">Border Colour:</label>
                                    <input type="color" class="form-control" name="border-colour">
                                </div>
                            </div>
                        </div>

                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox" name="corners">
                                Rounded Corners:
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="padding">Padding:</label>
                            <input id="padding" type="text" class="form-control" name="padding">
                        </div>

						<?php if ($_SESSION['site_details']['orbitType'] == 'dev') { ?>
                        <div class="accordion custom-accordion">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent=".custom-accordion" href="#custom">Custom Settings <span class="caret"></span></a>

                            <div id="custom" class="panel-collapse collapse">
                                <div class="form-group">
                                    <label>Custom CSS:</label>
                                    <textarea class="form-control" name="headCSS"><?php echo $module['headCSS']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Custom Classes:</label>
                                    <input type="text" class="form-control" name="classes" value="<?php echo $module['classes']; ?>">
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <div class="actions">
                        <input type="button" class="btn btn-info btn-edit btn-lg" value="Edit">
                        <input type="submit" class="btn btn-primary btn-lg" value="Save">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm-10" id="builder">
	        <div id="notifications"></div>
            <div id="main">          
                <?php echo $module['element']; ?>
            </div>
        </div>

    </div>

    <div class="modal fade" id="navModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

    <div class="modal fade" id="carouselModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

    <div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    
    <div class="modal fade" id="backgroundModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    
    <div id="updateModules"></div>

    <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
    <script src="/js/admin/module-builder.js"></script>
  </body>
</html>