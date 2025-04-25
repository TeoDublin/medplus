<?php
$_REQUEST['skip_cookie'] = true;
require_once 'includes.php';
$output=root('archive/pdf_output/'.($_REQUEST['name']??'') . uniqid() . '.pdf');
$url=url_no_port("pdf.php?component={$_REQUEST['component']}&PHPSESSID={$_REQUEST['sid']}");
shell_exec("wkhtmltopdf '{$url}' '{$output}'");
echo str_replace(root(''), '', $output);