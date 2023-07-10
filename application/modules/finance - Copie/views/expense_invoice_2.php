<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container">
            <!-- Header -->
            <style>
                .rowStyle {
                    background-color: #0D4D99;
                    color: #ffffff;
                }

                .invoice-container {
                    padding: 10px;
                }
            </style>
            <div class="panel panel-primary" id="invoice">
                <header>
                    <div class="row align-items-center">
                        <header>
                            <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                                <img id="logo" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:100%;height:18%" title="Koice" alt="Koice" />
                                <input hidden type="text" id="logo2" value="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>">
                            </div>
                            <hr>
                        </header>

                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6 text-sm-right">
                            <h4>Justificatif de Paiement</h4>
                        </div>
                    </div>
                    <hr>
                </header>
                <main>
                    <div class="row">
                        <div class="col-sm-6"><strong>Date et Heure:</strong><br> <?php echo $expense->datestring; ?></div>
                        <div class="col-sm-6 text-sm-right"> <strong>Numéro Facture:</strong><br> <?php echo $expense->codeFacture; ?></div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 text-sm-right order-sm-1"> <strong>Payer pour:</strong>
                            <address>
                                <?php echo $expense->beneficiaire; ?><br />
                            </address>
                        </div>
                        <div class="col-sm-6 order-sm-0"> <strong>Facturer à :</strong>
                            <address>
                                <?php echo $nom_organisation; ?><br />
                                Adresse : <?php echo $settings->address ?><br />
                                Téléphone : <?php echo $settings->phone ?><br />
                                Email : <?php echo $settings->email ?>
                            </address>
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <table class="table mb-0">
                                <thead class="rowStyle">
                                    <tr>
                                        <td class="col-3 border-0" style="width: 25%;"><strong>TYPE</strong></td>
                                        <td class="col-4 border-0" style="width: 35%;"><strong>BÉNÉFICIAIRE</strong></td>
                                        <td class="col-3 border-0" style="width: 25%;"><strong>RÉFÉRENCE</strong></td>
                                        <td class="col-2 border-0 text-right" style="width: 15%;"><strong>MONTANT</strong></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="col-3 border-0" style="width: 25%;"><?php echo $expense->category; ?> </td>
                                        <td class="col-4 border-0" style="width: 35%;"><?php echo $expense->beneficiaire; ?></td>
                                        <td class="col-3 border-0" style="width: 25%;"><?php if ($expense->category == "Achat Crédit" || $expense->category == "Paiement Senelec" || $expense->category == "Paiement SenEau" || $expense->category == "Achat Woyofal") { ?>
                                                <span style='font-weight:300;'>ID zuuluPay:</span><br /> <?php echo $expense->numeroTransaction; ?></span>
                                            <?php } ?>
                                        </td>
                                        <td class="col-2 border-0 text-right" style="width: 15%;"><span class="money"><?php echo $expense->amount; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body px-2">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><strong>Total HT:</strong></td>
                                            <td colspan="4" class="bg-light-2 text-right"><span class="money"><?php echo $expense->amount; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><strong>TVA:</strong></td>
                                            <td colspan="4" class="bg-light-2 text-right">0 FCA</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><strong>Total TTC:</strong></td>
                                            <td colspan="4" class="bg-light-2 text-right"><span class="money"><?php echo $expense->amount; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>


            <!-- Main Content -->
            <!-- Footer -->
            <footer class="text-center mt-6">
                <div class="col-sm-12 text-center">
                    <img id="logo3" src="<?php echo !empty($footer) ? $footer : "uploads/entetePartenaires/defaultFooter.PNG"; ?>" style="max-width:76%;height:5%" title="Koice" alt="Koice" />
                    <input hidden type="text" id="logo4" value="<?php echo !empty($footer) ? $footer : "uploads/entetePartenaires/defaultFooter.PNG"; ?>">
                </div>
                <p style="display: none;" class="text-4"><strong></strong> <span style=""> <?php echo  $nom_organisation . ', ' . $settings->address . ',  Tel: ' . $settings->phone . ' Mail : ' . $settings->email; ?></span></p>
                <div class="btn-group btn-group-sm d-print-none text-center" style="width: 40%;"><a href="finance/expense" class="btn btn-info btn-sm invoice_button pull-left"><i class="fa fa-arrow-circle-left"></i>Retour</a> <button type="submit" onclick="print()" class="btn btn-info btn-sm invoice_button pull-left" style="margin-left: 2%;"><i class="fa fa-print"></i> Imprimer</button> <button type="submit" onclick="download()" class="btn btn-info btn-sm detailsbutton pull-left download" style="margin-left: 2%;"><i class="fa fa-download"></i> Télécharger</button></div>
            </footer>

        </div>

        </div>
    </section>

    <input hidden type="text" id="logo2" value="<?php echo !empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>">
    <input hidden type="text" id="dateHeure" value="<?php echo $expense->datestring; ?>">
    <input hidden type="text" id="codeFacture" value="<?php echo $expense->codeFacture; ?>">
    <input hidden type="text" id="nomOrganisation" value="<?php echo $nom_organisation; ?>">
    <input hidden type="text" id="address" value="<?php echo $settings->address; ?>">
    <input hidden type="text" id="phone" value="<?php echo $settings->phone; ?>">
    <input hidden type="text" id="email" value="<?php echo $settings->email; ?>">
    <input hidden type="text" id="beneficiaire" value="<?php echo $expense->beneficiaire; ?>">
    <input hidden type="text" id="typeOperation" value="<?php echo $expense->category; ?>">
    <input hidden type="text" id="reference" value="<?php if ($expense->category == "Achat Crédit" || $expense->category == "Paiement Senelec" || $expense->category == "Paiement SenEau" || $expense->category == "Achat Woyofal") { ?>
                                                ID zuuluPay: <?php echo $expense->numeroTransaction; ?>
                                            <?php } ?>">
    <input hidden type="text" id="montant" value="<?php echo $expense->amount; ?>">
    <input hidden type="text" id="effectuerPar" value="<?php echo $expense->first_name . ' ' . $expense->last_name; ?>">


</section>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>

<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>


<script>
    var autoNumericInstance = new AutoNumeric.multiple('.money', {
        currencySymbol: " FCFA",
        currencySymbolPlacement: "s",
        emptyInputBehavior: "min",
        // maximumValue : "100000",
        // minimumValue : "1000",
        decimalPlaces: 0,
        decimalCharacter: ',',
        digitGroupSeparator: '.'
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<script>
    var dateHeure = $('#dateHeure').val();
    var codeFacture = $('#codeFacture').val();
    var nomOrganisation = $('#nomOrganisation').val();
    var address = $('#address').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var beneficiaire = $('#beneficiaire').val();
    var typeOperation = $('#typeOperation').val();
    var reference = $('#reference').val();
    var effectuerPar = $('#effectuerPar').val();
    var montant = $('#montant').val();
    montant = formatCurrencyFacture(montant);

    async function download() {
        // pdfMake.createPdf(dd).download();
        await pdfMake.createPdf(dd).download('Facture_' + codeFacture + '.pdf');
        setTimeout(() => {
            window.location.reload(true);
        }, 2000);

    }

    function print() {
        pdfMake.createPdf(dd).print();
        window.location.reload(true);
    }

    function formatCurrencyFacture(number) {
        return (number || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' FCFA';
    }



    var dd = {
        pageSize: 'A4',
        footer: [{
            columns: [
                {
                    image: '/sampleImage.jpg/',
                    width: 550,
                    height: 20
                }
            ],margin: [0, 0]
        }],
        content: [
            'Page Contents'
        ],
        content: [{
                alignment: 'justify',
                columns: [

                    {
                        image: '/sampleImage.jpg/',
                        width: 550,
                        height: 100
                    },
                    {
                        text: 'Justificatif de Paiement',
                        style: 'header',
                        alignment: 'right',
                        widths: ['*', '*', '*', 150]
                    }
                ]
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                text: '',
                style: 'header'
            },
            {
                alignment: 'justify',
                columns: [
                    [{
                        text: 'Date et Heure :',
                        style: 'tableHeader',
                        fit: [50, 50]
                    }, {
                        text: dateHeure,
                        fit: [50, 50]
                    }],
                    [{
                        text: 'Numéro Facture :',
                        style: 'tableHeader',
                        fit: [50, 50],
                        alignment: 'right'
                    }, {
                        text: codeFacture,
                        fit: [50, 50],
                        alignment: 'right'
                    }],
                    // {
                    //   text: 'Numéro Facture : FA03230', style: 'tableHeader', alignment: 'right',
                    //   widths: ['*', '*', '*', 200]
                    // }
                ]
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                text: '',
                style: 'header'
            },
            {
                alignment: 'justify',
                columns: [

                    {
                        text: 'Facturer à: ',
                        style: 'header',
                        alignment: 'left',
                        widths: ['*', '*', '*', 150]
                    },
                    {
                        text: 'Payer pour: ',
                        style: 'header',
                        alignment: 'right',
                        widths: ['*', '*', '*', 150]
                    }
                ]
            },
            {
                alignment: 'justify',
                columns: [

                    {
                        text: nomOrganisation + '\n Adresse : ' + address + '\n Téléphone : ' + phone + '\n Email : ' + email,
                        alignment: 'left',
                        widths: 200,
                    },
                    {
                        text: '',
                        widths: '*',
                    },
                    {
                        text: beneficiaire,
                        alignment: 'right',
                        widths: 200,
                    }
                ]
            },
            {
                text: '',
                style: 'header'
            },
            {
                style: 'tableExample',
                table: {
                    widths: [120, '*', 130, 80],
                    body: [
                        [{
                            text: 'TYPE',
                            style: 'tableHeader',
                            color: '#ffffff'
                        }, {
                            text: 'BÉNÉFICIAIRE',
                            style: 'tableHeader',
                            color: '#ffffff'
                        }, {
                            text: 'RÉFÉRENCE',
                            style: 'tableHeader',
                            color: '#ffffff'
                        }, {
                            text: 'MONTANT',
                            style: 'tableHeader',
                            alignment: 'right',
                            color: '#ffffff'
                        }],
                        [typeOperation, {
                            text: beneficiaire
                        }, {
                            text: reference
                        }, {
                            text: montant,
                            alignment: 'right'
                        }],
                    ]
                },

                layout: {
                    fillColor: function(rowIndex, node, columnIndex) {
                        return (rowIndex % 2 === 0) ? '#0D4D99' : null;
                    }
                }
            },
            {
                style: 'tableExample',
                table: {
                    widths: ['*', 130, 80],
                    body: [
                        [{
                            rowSpan: 3,
                            text: ''
                        }, 'Total HT', {
                            text: montant,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 3,
                            text: ''
                        }, 'TVA', {
                            text: '0 FCFA',
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 3,
                            text: ''
                        }, 'Total TTC', {
                            text: montant,
                            alignment: 'right'
                        }],
                    ]
                },
                layout: {
                    fillColor: function(rowIndex, node, columnIndex) {
                        return '#F7F7F7';
                    }
                }
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                text: '',
                style: 'header'
            },
            {
                alignment: 'justify',
                columns: [
                    [{
                        text: 'Effectué par :',
                        style: 'tableHeader',
                        fit: [50, 50]
                    }, {
                        text: effectuerPar,
                        fit: [50, 50]
                    }],
                    //[{ text: 'Numéro Facture :', style: 'tableHeader',fit: [50, 50],alignment: 'right'}, { text: 'FA03230',fit: [50, 50],alignment: 'right'}],
                    // {
                    //   text: 'Numéro Facture : FA03230', style: 'tableHeader', alignment: 'right',
                    //   widths: ['*', '*', '*', 200]
                    // }
                ]
            },
        ],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                margin: [0, 0, 0, 10]
            },
            subheader: {
                fontSize: 16,
                bold: true,
                margin: [0, 10, 0, 5]
            },
            tableExample: {
                margin: [0, 5, 0, 15]
            },
            tableHeader: {
                bold: true,
                fontSize: 13,
                color: 'black'
            }
        },
        defaultStyle: {
            // alignment: 'justify'
        }

    }


    function toDataURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var reader = new FileReader();
            reader.onloadend = function() {
                callback(reader.result);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }
    var logo = $('#logo2').val();
    var footer = $('#logo4').val();
    toDataURL(logo, function(dataUrl) {
        console.log('RESULT:', dataUrl);
        dd.content[0].columns[0].image = dataUrl;
    })

    toDataURL(footer, function(dataUrl) {
        dd.footer[0].columns[0].image = dataUrl;
        //   dd.footer.image = dataUrl;
        // alert(dataUrl);
    })

</script>