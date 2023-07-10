<!DOCTYPE html>
<html lang="fr" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>>

<head>
    <base href="<?php echo base_url(); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Rizvi">
    <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/faviconZ.png">
    <title><?php echo $this->router->fetch_class(); ?> | <?php echo $this->db->get('settings')->row()->system_vendor; ?> </title>
    <!-- Web Fonts INVOICE
======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>
    <!-- Bootstrap core CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="common/css/stylesheet2.css"/> -->
    <!-- Web Fonts INVOICE -->

    <link href="<?php echo base_url(); ?>common/css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>common/css/bootstrap-reset.css?<?php echo time(); ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>common/assets/DataTables/datatables.css?<?php echo time(); ?>" rel="stylesheet" />
    <!-- <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>common/css/style.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>common/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="common/css/jquery-ui.css" />
    <!--<link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-timepicker/compiled/timepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/jquery-multi-select/css/multi-select.css" />
    <link href="<?php echo base_url(); ?>common/css/invoice-print.css" rel="stylesheet" media="print">
    <link href="<?php echo base_url(); ?>common/assets/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/select2/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/css/lightbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="https://github.com/pipwerks/PDFObject/blob/master/pdfobject.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>

    <!-- Google Fonts -->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
    </style>
</head>

<body>

    <header>
        <img class="header_img" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" width="750" height="120" alt="alt" />
    </header>
    <?php
    $patient_details = $this->patient_model->getPatientById($report_details->patient);
    ?>


    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">
            <h5>
                Date: <strong><?php echo $date_prescription ?></strong><br>
                <small>Date:</small>
            </h5>
            <h5>
                ID Rapport: <strong><?php echo $report_details->report_code; ?></strong><br>
                <small>Report ID:
                </small>
            </h5>
            <h5>
                Date de pr&eacute;l&egrave;vement: <strong><?php echo $report_details->sampling_date; ?></strong><br>
                <small>Sample date:</small>
            </h5>
            <h5>
                <?php echo lang('type_of_sampling'); ?> <strong><?php echo $this->db->get_where('sampling', array('id' => $report_details->sampling))->row()->name; ?></strong><br>
                <small>Type of sample:</small>
            </h5>
            <h5>
                Passeport: <strong><?php if (strtolower($lab_details->name) == 'pcr') {
                                        echo $patient_details->passport;
                                    } ?></strong><br>
                <small>Passport:</small>
            </h5>
            <h5>
                Motif: <strong><?php if (strtolower($lab_details->name) == 'pcr') {
                                    echo $this->db->get_where('purpose', array('id' => $payments->purpose))->row()->name;
                                } ?></strong><br>
                <small>Reasons:</small>
            </h5>


        </div>
        <div class="col-md-6 invoice_head_right">
            <h5>
                Pr&eacute;nom et Nom : <strong><?php echo $patient_details->name . ' ' . $patient_details->last_name; ?></strong><br>
                <small>Last and first name:</small>
            </h5>
            <h5>
                Code : <strong><?php echo $patient_details->id; ?></strong><br>
                <small>Code:</small>
            </h5>
            <h5>
                Age: <strong><?php echo $patient_details->age; ?> An(s) / years</strong><br>
                <small>Age:</small>
            </h5>
            <h5>
                Sexe: <strong><?php if ($patient_details->sex === 'Feminin') {
                                    echo 'Feminin / Female';
                                } else {
                                    echo 'Masculin / Male';
                                }; ?></strong><br>
                <small>Gender:</small>
            </h5>
            <h5>
                Adresse: <strong><?php echo $patient_details->address; ?></strong><br>
                <small>Address:</small>
            </h5>

        </div>



    </div>
    <br>
    <div class="panel panel-default" style="width: 80%;">
        <div class="panel" style="background-color:#eeeeee;margin-left: 20%; text-align:center;">
            <h4 style="color:#0D4D99;font-weight: bold;font-style: italic;font-size: 1.2em;">R&Eacute;SULTATS DES ANALYSES | TEST RESULTS</h4>
        </div>
    </div>
    <h4 style="font-weight: bold;font-style: italic;font-size: 1.2em;text-align:center">Biologie mol&eacute;culaire | Molecular biology</h4>
    <h5 style="font-weight: bold;font-style: italic;font-size: 1.0em;text-align:center">RECHERCHE D’ARN DU SARS-COV-2(qRT-PCR) | PCR TEST FOR SARS-COV-2(qRT-PCR)</h5>

    <br>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-3 invoice_head_left">
            <h5>RÉSULTAT </h5>
        </div>
        <div class="col-md-7 invoice_head_right">
            <h5 style="font-weight: bold;font-style: italic;font-size: 1.2em;"><?php echo $resultatPCR; ?></h5>
        </div>
    </div>
    <br>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-3 invoice_head_left">
            <h5>CONCLUSION </h5>
        </div>
        <div class="col-md-7 invoice_head_right">
            <h5 style="font-weight: bold;font-style: italic;font-size: 1.2em;"><?php echo $conclusionPCR; ?></h5>
            <h5 style="font-weight: bold;font-style: italic;font-size: 1.2em;"><?php echo $conclusionPCRConvert; ?>
            </h5>
        </div>
    </div>
    <br>

    <div class="col-md-3 invoice_head_left">
        <img class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $report_details->qr_code; ?>" width="150" height="150" alt="alt" />

    </div>
    <div class="col-md-5">
        <img class="qr_code" style="margin-left: 50%;" src="<?php echo $signature ?>" width="350" height="350" alt="alt" />
    </div>
    <div class="col-md-12 invoice_head clearfix">
        <p style="font-style: italic;font-size:1em">Scanner ce QR Code à l'aide de votre Smartphone connecté à internet pour vérifier l'authenticité des informations contenues dans ce document</p>
    </div>

    <style>
        .header_img {
            width: 1200px;
            height: 140px;
        }

        .col-md-6 {
            width: 45%;

        }

        .col-md-12 {
            width: 100%;

        }

        .invoice_head_right {
            float: right;

        }

        .invoice_head_left {
            float: left;
        }

        .col-md-9 {
            width: 70%;
        }

        .col-md-3 {
            width: 20%;
        }

        h5 {
            font-weight: bold;font-style: italic;font-size: 1em;
        }
        
    </style>
</body>

</html>