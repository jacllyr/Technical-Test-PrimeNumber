<?php

// Load our template
$header = file_get_contents("header.html");
// form template
$form = file_get_contents("form.html");
$footer = file_get_contents("footer.html");

echo $header . $form . $footer;

?>