<?php
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file']['TMP_NAME']);
switch ($mime) {

   case 'application/pdf':

   default:
       die("Unknown/not permitted file type");
}
?>


INCOMPLETE!