<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>HTML Media Capture Demo</title>

    <body>
    <a href="./">upload page</a>

<?php
$path = "tmp";
$array = scandir($path,1);
$num = count($array);

print("<table class='table table-bordered'><tbody><tr>");
$max = 1;
$cnt = 0;
for ($i=0;$i<$num;$i++){
    $filename = $path . "/" . $array[$i];
    if  (Eregi('gif$', $filename) OR
         Eregi('jpg$', $filename) OR
         Eregi('jpeg$',$filename) OR
         Eregi('png$', $filename)) {
        print("<td>" . $filename . "</td>");
        print("<td><a href=" .$filename . "><img src = " .$filename. " style='width:180px;height180px;'></a></td>");
        $cnt = $cnt + 1;
        if ($cnt >= $max) {
            print("</tr><tr>");
            $cnt = 0;
        }
    }
}
print("</tr></tbody></table>");

?>

    </body>
</html>
