<?php

$handle = fopen('tmp/log', 'a+');
fwrite($handle, 'hello');

$files = var_export($_FILES, true);
$post = var_export($_POST, true);
fwrite($handle, PHP_EOL. $files .PHP_EOL);

$filename = basename($_FILES['cameraData']['name']);
$is_image = preg_match('/^image\//', $_FILES['cameraData']['type']);
if ($is_image) {
  if (move_uploaded_file($_FILES['cameraData']['tmp_name'], 'tmp/' . $filename)) {
    $data = array('status' => 'OK');
  } else {
    $data = array('status' => 'Failed to save');
  }
} else {
  $data = array('status' => 'File is not an Image, not uploaded');
}

header('Content-type: text/html');
echo json_encode($data);

