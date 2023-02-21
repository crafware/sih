<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */
require_once '/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
$html2pdf = new Html2Pdf('P', 'A4', 'fr');
$html2pdf->output('example01.pdf');

