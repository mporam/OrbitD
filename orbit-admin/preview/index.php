<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');

if (!empty($_POST['preview'])) { ?>
<!DOCTYPE html>
<html>
<head>
    <title>
<?php if (!empty($_POST['pageName'])) {
echo $_POST['pageName'];
} else {
echo 'Untitled Page';
} ?> | Page Preview
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <link href="/css/core.css" rel="stylesheet" media="screen">
    <link href="/css/generic.css" rel="stylesheet" media="screen">

    <!--[if lt IE 9]>
      <script src="/js/libraries/html5shiv.js"></script>
      <script src="/js/libraries/respond.min.js"></script>
    <![endif]-->

    <style>
        <?php echo $_POST['headcss']; ?>
    </style>

</head>
<body style="background-color: <?php echo $_POST['background-color']; ?>">
<?php
    echo stripslashes($_POST['preview']);
?>
</body>
</html>
<?php
} else {

echo '<p>No Preview available.</p>';
}