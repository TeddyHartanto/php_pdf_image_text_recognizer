<?php

/**
 * Created by PhpStorm.
 * User: teddy
 * Date: 10/3/17
 * Time: 1:51 PM
 */

$pdf_dir = 'pdfs/';
$dir_items = array_diff(scandir($pdf_dir), ['.', '..']);


foreach ($dir_items as $dir_item) {
    $filename_no_ext = substr($dir_item, 0, -4);
    $input = $pdf_dir . $dir_item;
    $output = "jpgs/{$filename_no_ext}.jpg";
    hq_pdf_to_jpeg($input, 0, $output);
}

// This code is to show: the image in a webpage
//$imagick = new Imagick();
//$imagick->setResolution(150, 150);
//$imagick->readImage('pdfs/test.pdf[0]');
//$imagick->setFormat('jpeg');
//header( "Content-Type: image/jpeg" );
//echo $imagick->getImageBlob();


/**
 * Equivalent to the following CLI command:
 *     exec("convert -density 150 {$src}[{$pageNum}] -quality 100 -flatten -sharpen 0x1.0
 *      {$dest}");
 *
 *
 * @param $input        -> input PDF filename
 * @param $pageNum      -> input PDF's page number to be converted to JPEG
 * @param $output       -> output JPEG's filename
 */
function hq_pdf_to_jpeg($input, $pageNum, $output) {
    $imagick = new Imagick();
    $imagick->setResolution(150, 150);
    $imagick->readImage($input . "[{$pageNum}]");
    $imagick->setImageFormat('jpeg');
    $imagick->setImageCompressionQuality(100);
    $imagick->sharpenImage(0, 1.0);
    $imagick = $imagick->flattenImages();
    $imagick->writeImage($output);
}
