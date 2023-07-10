<?php
require __DIR__ . '/../../../../autoload.php';

use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PrintHelper extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('accountant/accountant_model');
        $this->load->model('receptionist/receptionist_model');
        $this->load->model('home/home_model');
        $this->load->model('depot/depot_model');
        $this->load->model('donor/donor_model');
        $this->load->model('lab/lab_model');
    }

    function index()
    {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $nombre_impresora = "ecoMed24";

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $logo = EscposImage::load("uploads/entetePartenaires/logo.jpg", false);
        $printer->bitImage($logo);

        $printer->setTextSize(2, 2);
        $printer->text("Ticket de caisse");

        $printer->setTextSize(2, 1);
        $printer->feed();
        $printer->text("Diadia & Maman \n\n les deux soeurs\n\n ");

        $printer->feed(15);
        $printer->cut();


        /*
Por medio de la impresora mandamos un pulso.
Esto es útil cuando la tenemos conectada
por ejemplo a un cajón
 */
        $printer->pulse();

        /*
Para imprimir realmente, tenemos que "cerrar"
la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
 */
        $printer->close();

        // $this->load->view('home/dashboard', $data);
        $this->load->view('printhelper', $data);
        $this->load->view('home/footer');
    }
}
