<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';


use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Tag extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('Pdf_report');
        $this->load->model('M_site');
        $this->load->model('M_tag');
        // check_role();
        // check_role_danru();
    }

    public function index()
    {
        $tags = $this->M_tag->getTag()->result_array();
        $data = [
            'title' => 'Tag',
            'tags' => $tags
        ];
        $this->template->load('templates/template', 'tags/tag_data', $data);
    }

    public function add()
    {
        $kode = randomString();
        $data = [
            'title' => 'Tambah Tag',
            'kode' => $kode,
            'sites' => $this->db->get('sites')->result_array()
        ];
        $this->form_validation->set_rules('is_tag', 'Jenis Tag', 'required');
        $this->form_validation->set_rules('label', 'Label', 'required');
        if ($this->form_validation->run() ==  false) {
            $this->template->load('templates/template', 'tags/tag_add', $data);
        } else {
            $this->M_tag->addTag();
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($this->input->post('qrcode', true))
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->build();

            // header('Content-Type: ' . $result->getMimeType());
            // echo $result->getString();

            // Save it to a file
            $result->saveToFile('./assets/qrcode/'  . $this->input->post('qrcode', true) . '.png');

            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! Tag baru berhasil ditambahkan!
            </div>');
            redirect('tag');
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Update Tag',
            'tag' => $this->M_tag->getTag($id)->row_array()
        ];
        $this->form_validation->set_rules('label', 'Label', 'required');
        if ($this->form_validation->run() ==  false) {
            $this->template->load('templates/template', 'tags/tag_edit', $data);
        } else {
            $data = [
                'label' => $this->input->post('label', true),
                'lokasi' => $this->input->post('location', true),
                'latitude_longitude' => $this->input->post('latitude_longitude', true),
                'is_tag' => $this->input->post('is_tag', true),
                'status' => $this->input->post('status', true),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id_qrcode', $this->input->post('id_qrcode'));
            $this->db->update('gms_qrcode_tags', $data);
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! Tag  berhasil diupdate!
            </div>');
            redirect('tag');
        }
    }

    function qrcode_tag($id)
    {
        $tag = $this->db->query("select  * from gms_qrcode_tags gqt ,sites s WHERE gqt.idsite =s.site_id and gqt.tagid = $id  ORDER by gqt.tagid DESC ;")->row_array();

        $data = [
            'title' => 'View QRCode',
            'tag' => $tag
        ];
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($tag['code'])
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            // ->logoPath('./assets/tpm.png',)
            // ->labelText('tpm-secuirty')
            // ->labelFont(new NotoSans(12))
            // ->labelAlignment(new LabelAlignmentCenter())
            ->build();

        header('Content-Type: ' . $result->getMimeType());
        echo $result->getString();

        // Save it to a file
        $result->saveToFile('./assets/qrcode/' . $tag['code'] . '.png');
        redirect('tag');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $result->getDataUri();
        //$this->template->load('templates/template', 'tags/tag_qrcode', $data);
    }

    public function print($id)
    {

        $tag = $this->db->query("select  * from gms_qrcode_tags gqt ,sites s WHERE gqt.id_site =s.id_site and gqt.tagid = '$id'  ORDER by gqt.tagid DESC ;")->row_array();
        // print_r($tag['tagid']);
        // die;
        $data = [
            'tag' => $tag,
        ];

        $this->load->view('tags/tag_print', $data);
        // redirect('tag');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $result->getDataUri();
        //$this->template->load('templates/template', 'tags/tag_qrcode', $data);
    }
}
