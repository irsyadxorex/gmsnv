<?php

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_report extends TCPDF
{
    protected $ci;

    function __construct()
    {
        $this->ci = &get_instance();
    }
}