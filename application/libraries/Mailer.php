<?php defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $_ci;
    protected $email_pengirim = 'pkwt@tpmgroup.id'; // Isikan dengan email pengirim
    protected $nama_pengirim = 'PKWT Online TPM Group'; // Isikan dengan nama pengirim
    protected $password = 'Tpmpkwt26'; // Isikan dengan password email pengirim

    public function __construct()
    {
        $this->_ci = &get_instance(); // Set variabel _ci dengan Fungsi2-fungsi dari Codeigniter

        require_once(APPPATH . 'third_party/phpmailer/Exception.php');
        require_once(APPPATH . 'third_party/phpmailer/PHPMailer.php');
        require_once(APPPATH . 'third_party/phpmailer/SMTP.php');
    }

    public function send($data)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        // $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = $data['username'];
        $mail->Password = $data['password'];
        $mail->setFrom($data['email'], $data['email_name']);
        $mail->addReplyTo($data['email'], $data['email_name']);
        $mail->addAddress($data['email_penerima'], $data['nama']);
        $mail->Subject = $data['subjek'];
        //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
        $mail->isHTML(true);
        $mail->Body = $data['content'];

        // $mail = new PHPMailer;
        // $mail->isSMTP();

        // $mail->Host = 'smtp.hostinger.com';
        // $mail->Username = $this->email_pengirim; // Email Pengirim
        // $mail->Password = $this->password; // Isikan dengan Password email pengirim
        // $mail->Port = 587;
        // $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'ssl';
        // // $mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging

        // $mail->setFrom($this->email_pengirim, $this->nama_pengirim);
        // $mail->addAddress($data['email_penerima'], '');
        // $mail->isHTML(true); // Aktifkan jika isi emailnya berupa html

        // $mail->Subject = $data['subjek'];
        // $mail->Body = $data['content'];
        //$mail->AddEmbeddedImage('image/logo.png', 'logo_mynotescode', 'logo.png'); // Aktifkan jika ingin menampilkan gambar dalam email

        $send = $mail->send();

        if ($send) {
            return true;
        } else {
            return false;
            // return 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
