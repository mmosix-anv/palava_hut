<?php
require_once 'system/bootstrap.php';
require_once 'app/Helpers/dev_tools_helper.php';

$scss = array(
    'assets/scss/style.scss',
    'assets/scss/dashboard.scss'
);

write_scss($scss);
echo 'SCSS compilation completed successfully!';
?>