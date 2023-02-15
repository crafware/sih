<?php
echo 1;
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
/*require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/vendor/autoload.php';
use spipu\html2pdf\Html2Pdf;
$html2pdf = new Html2Pdf('P', 'A4', 'fr', 'UTF-8');
$html2pdf->output('example01.pdf');*/
require dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/vendor/autoload.php';
echo 2;
//require_once '/../vendor/autoload.php';
//use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
echo 3;
try {
    //ob_start();
    //include dirname(__FILE__).'/res/example01.php';
    //$content = ob_get_clean();
    echo 4;
    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    echo 5;
    //$html2pdf->writeHTML($content);
    echo 6;
    $html2pdf->output('example01.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
