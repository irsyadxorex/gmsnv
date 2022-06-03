<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/TCPDF-master/tcpdf.php';
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}
class PKWT_TUNAS extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    public function Header()
    {
        // Logo
        $image_file = base_url('assets/images/kop_tunas.jpg');
        $this->Image($image_file, 0, 0, 200, '', 'JPG', '', 'T', false, 9000, '', false, false, 0, false, false, false);
    }
}
