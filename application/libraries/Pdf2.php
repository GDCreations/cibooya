<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('FPDF_FONTPATH','/home/www/font');
require('Fpdf2.php');
class Pdf2 extends FPDF2
{
    // Extend FPDF using this class
    // More at fpdf.org -> Tutorials
    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        // Call parent constructor
        parent::__construct($orientation,$unit,$size);
    }
}
?>