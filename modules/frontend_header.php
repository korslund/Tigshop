<?php
/* TODO: no sanitation on title
 */
function html_header($title)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><?php echo $title ?></title>
</head>
<body>
<?php
}

function html_footer()
{
?>
</body>
</html>
<?php
}
?>