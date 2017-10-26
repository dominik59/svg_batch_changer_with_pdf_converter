<?php

use SvgGenerator\SvgGenerator;

require_once __DIR__ . '/vendor/autoload.php';

$shortopts = "c";
$options = getopt($shortopts);
if (isset($options['c'])) {
    $convertToPdf = true;
    echo 'PDF conversion option is set';
} else {
    $convertToPdf = false;
    echo 'You can add -c option to convert to PDF also';
}
$svgGenerator = new SvgGenerator();
$svgGenerator->run($convertToPdf);
?>