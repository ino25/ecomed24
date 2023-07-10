<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container" style="padding-top:-20%">
            <!-- Header -->
            <style>
                .rowStyle {
                    background-color: #0D4D99;
                    color: #ffffff;
                }

                .container-fluid {
                    padding: 5px;
                }
            </style>
            <div style="display:none">
                <h6><?php echo !empty($organisation) ? $organisation->description_courte_activite : ""; ?><h6>
                        <input hidden id="descOrganisation" type="text" value="<?php echo !empty($organisation) ? $organisation->description_courte_activite : ""; ?>">
                        <span><?php echo !empty($organisation) ? $organisation->description_courte_services : ""; ?></span>
                        <h6 style="text-transform:italic;"><?php echo !empty($organisation) ? $organisation->slogan : ""; ?></h6>
                        <input hidden id="slogan" type="text" value="<?php echo !empty($organisation) ? $organisation->slogan : ""; ?>">

                        <h6><?php echo !empty($organisation) && !empty($organisation->horaires_ouverture) ? "Horaires d'ouverture:" : ""; ?></h6>
                        <input hidden id="horaire" type="text" value="<?php echo !empty($organisation) && !empty($organisation->horaires_ouverture) ? "Horaires d'ouverture:" : ""; ?>">
                        <p>
                            <?php echo !empty($organisation) ? $organisation->horaires_ouverture : ""; ?>

                        </p>
                        <input hidden id="horaireOuverture" type="text" value="<?php echo $organisation->horaires_ouverture; ?>">
                        <label hidden id="descriptionConfirmation"><?php echo $organisation->horaires_ouverture; ?>
                        </label>
                        <div class="col-sm-4 text-center text-sm-right">
                            <h4 class="text-7 mb-0">Reçu</h4>
                        </div>
            </div>


            <div class="panel panel-primary" id="invoice">
                <header>
                    <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                        <img id="logo" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:100%;height:18%" title="Koice" alt="Koice" />
                        <input hidden type="text" id="logo2" value="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>">
                    </div>
                    <hr>
                </header>
                </br></br>
                <main>
                    <div class="col-sm-12">
                        <div class="col-sm-6 text-sm-left order-sm-1"><strong>Date :</strong><br> <?php
                                                                                                    if (!empty($payment->date)) {
                                                                                                        echo date('d/m/Y H:i', $payment->date);
                                                                                                    }
                                                                                                    ?></div>
                        <input hidden id="dateFacture" type="text" value="<?php
                                                                            if (!empty($payment->date)) {
                                                                                echo date('d/m/Y H:i', $payment->date);
                                                                            }
                                                                            ?>">
                        <div class="col-sm-6 text-sm-right order-sm-1"> <strong>Numéro de Reçu:</strong><br> <?php
                                                                                                                if (!empty($payment->id)) {
                                                                                                                    echo $payment->code;
                                                                                                                }
                                                                                                                ?>
                            <input hidden id="codeFacture" type="text" value="<?php
                                                                                if (!empty($payment->id)) {
                                                                                    echo $payment->code;
                                                                                }
                                                                                ?>">

                        </div>

                    </div>

                    <hr><br>
                    <hr>
                    <div class="col-sm-12" style="padding-top:15px">
                        <?php $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row(); ?>

                        <?php
                        if (!empty($patient_info)) {
                            $patient_info->name . '  ' . $patient_info->last_name . ' <br>';
                        }
                        ?>
                        <input hidden id="agePatient" type="text" value="<?php
                                                                            if (!empty($patient_info->age)) {
                                                                                echo $patient_info->age;
                                                                            } ?>">


                        <input hidden id="codePatient" type="text" value="<?php
                                                                            if (!empty($patient_info)) {
                                                                                echo $patient_info->patient_id;
                                                                            }
                                                                            ?>">

                        <input hidden id="prenom" type="text" value="<?php
                                                                        if (!empty($patient_info)) {
                                                                            echo   $patient_info->name;
                                                                        }
                                                                        ?>">
                        <input hidden id="nom" type="text" value="<?php
                                                                    if (!empty($patient_info)) {
                                                                        echo   $patient_info->last_name;
                                                                    }
                                                                    ?>">

                        <input hidden id="phonePatient" type="text" value="<?php
                                                                            if (!empty($patient_info)) {
                                                                                echo   $patient_info->phone;
                                                                            }
                                                                            ?>">

                        <input hidden id="addressPatient" type="text" value="<?php
                                                                                if (!empty($patient_info->address)) {
                                                                                    echo $patient_info->address;
                                                                                }
                                                                                ?>">

                        <input type="hidden" id="sexePatient" type="text" value="<?php $sexe = json_encode($patient_info->sex);
                                                                                    echo $patient_info->sex;
                                                                                    ?>">




                        <div class="col-sm-6 text-sm-left order-sm-1">
                            <h4 style="color:#0D4D99"><?php echo $nom_organisation; ?></h4>
                            <input hidden id="nomOrganisation" type="text" value="<?php echo $nom_organisation; ?>">
                            <address>
                                <?php
                                if (!empty($user->first_name)) {
                                    echo 'Prénom et Nom : ' . $user->first_name . ' ' . $user->last_name . ' <br>';
                                }
                                ?>
                                <input hidden id="user_name" type="text" value="<?php
                                                                                if (!empty($user->first_name)) {
                                                                                    echo $user->first_name . ' ' . $user->last_name;
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?>">
                                <?php

                                if (!empty($organisation->portable_responsable_legal)) {
                                    echo 'Téléphone mobile : ' . $organisation->portable_responsable_legal . ' <br>';
                                }
                                ?>
                                <input hidden id="user_phone" type="text" value="<?php
                                                                                    if (!empty($organisation->portable_responsable_legal)) {
                                                                                        echo $organisation->portable_responsable_legal;
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>">

                               <?php if (!empty($organisation->numero_fixe)) {
                                echo 'Téléphone fixe : ' . $organisation->numero_fixe . ' <br>';
                                }
                                ?>
                                <input hidden id="user_fixe" type="text" value="<?php
                                                                                    if (!empty($organisation->numero_fixe)) {
                                                                                        echo $organisation->numero_fixe;
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>">
                                <?php

                                if (!empty($user->email)) {
                                    echo 'Email : ' . $user->email . ' <br>';
                                }
                                ?>
                                <input hidden id="user_email" type="text" value="<?php
                                                                                    if (!empty($user->email)) {
                                                                                        echo $user->email;
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>">


                                <?php
                                if (!empty($payment->doctor_name)) {
                                    echo 'Médecin Prescripteur : ' . $payment->doctor_name . ' <br>';
                                }

                                ?>
                                <input hidden id="prescripteur" type="text" value="<?php
                                                                                    if (!empty($payment->prescripteur)) {
                                                                                        echo  'Dr ' . $doctor->first_name . ' ' . $doctor->last_name;
                                                                                    } else echo '';

                                                                                    ?>">
                            </address>
                        </div>
                        <div class="col-sm-6 text-sm-right order-sm-1">
                            <h4 style="color:#0D4D99">INFOS PATIENT</h4>
                            <address>
                                <?php
                                if (!empty($patient_info)) {
                                    echo 'Code : ' . $patient_info->patient_id . ' <br>';
                                }
                                ?>
                                <?php
                                if (!empty($patient_info)) {
                                    echo 'Prénom et Nom : ' . $patient_info->name . ' ' . $patient_info->last_name . ' <br>';
                                }
                                ?>
                                <?php
                                if (!empty($patient_info->phone)) {
                                    echo 'Téléphone : '  . $patient_info->phone . ' <br>';
                                } else {
                                    echo 'Téléphone :  Non renseigné <br>';
                                }
                                ?>
                                <?php
                                if (!empty($patient_info->address)) {
                                    echo 'Adresse : '  . $patient_info->address . ' <br>';
                                } else {
                                    echo 'Adresse :  Non renseigné <br>';
                                }
                                ?>
                                <!-- <?php
                                        if (!empty($patient_info->passport)) {
                                            echo 'Passeport : '  . $patient_info->passport . ' <br>';
                                        }
                                        ?> -->
                                <?php
                                if (!empty($patient_info->email)) {
                                    echo 'Email : '  . $patient_info->email . ' <br>';
                                }
                                ?>
                                <?php
                                if (!empty($patient_info->age)) {
                                    echo 'Age : ' . $patient_info->age . ' An(s) <br>';
                                } else { ?>
                                    Age : <span class="agePatient" id="age"></span> <br>
                                <?php }
                                ?>



                                Sexe : <?php $sexe = json_encode($patient_info->sex);
                                        echo $sexe == '"Masculin"' ? "M" : "F";
                                        ?>


                            </address>

                            <span id="logoFooter" style="display:none"></span>
                            <span id="logoHeader" style="display:none"></span>

                            <input hidden id="prenom" type="text" value="<?php
                                                                            if (!empty($patient_info)) {
                                                                                echo   $patient_info->name;
                                                                            }
                                                                            ?>">
                            <input hidden id="nom" type="text" value="<?php
                                                                        if (!empty($patient_info)) {
                                                                            echo   $patient_info->last_name;
                                                                        }
                                                                        ?>">
                            <input hidden id="phonePatient" type="text" value="<?php
                                                                                if (!empty($patient_info)) {
                                                                                    echo   $patient_info->phone;
                                                                                }
                                                                                ?>">

                            <input hidden id="addressPatient" type="text" value="<?php
                                                                                    if (!empty($patient_info->address)) {
                                                                                        echo $patient_info->address;
                                                                                    }
                                                                                    ?>">

                            <!-- <input hidden id="patientPassport" type="text" value="<?php
                                                                                        if (!empty($patient_info->passport)) {
                                                                                            echo $patient_info->passport;
                                                                                        }
                                                                                        ?>"> -->

                            <input hidden id="patientEmail" type="text" value="<?php
                                                                                if (!empty($patient_info->email)) {
                                                                                    echo $patient_info->email;
                                                                                }
                                                                                ?>">

                            <input hidden id="sexePatient" type="text" value="<?php $sexe = json_encode($patient_info->sex);
                                                                                echo $sexe == '"Masculin"' ? "M" : "F";
                                                                                ?>">

                        </div>
                    </div><br>
                    <div class="card">
                        <div>
                            <table class="table mb-0">
                                <thead class="rowStyle">
                                    <tr>
                                        <td class="col-1 border-0" style="width: 10%;"><strong>#</strong></td>
                                        <td class="col-4 border-0" style="width: 40%;"><strong><?php echo lang('description'); ?></strong></td>
                                        <td class="col-3 border-0" style="width: 20%;"><strong><?php echo lang('unit_price'); ?></strong></td>
                                        <td class="col-1 border-0" style="width: 15%;"><strong>Quantité</strong></td>
                                        <td class="col-2 border-0" style="width: 15%;"><strong><?php echo lang('amount'); ?></strong></td>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table class="table mb-0">
                                <tbody>
                                    <?php
                                    if (!empty($payment->category_name)) {
                                        $category_name = $payment->category_name;
                                        $category_name1 = explode(',', $category_name);
                                        $i = 0;
                                        foreach ($category_name1 as $category_name2) {
                                            $i = $i + 1;
                                            $category_name3 = explode('*', $category_name2);
                                            if ($category_name3[3] > 0 && $category_name3[1]) {
                                    ?>

                                                <tr class="ligneFacture">
                                                    <td class="col-1 border-0" style="width: 10%;"><strong><span class="idFacture"><?php echo $i; ?></span> </strong></td>
                                                    <td class="col-4 border-0" style="width: 40%;"><span class="prestationFacture"><?php if ($category_name3[5] == 'service') { ?><?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation; ?><?php
                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                echo $this->lab_model->getLabTestImportedById($category_name3[0])->name;
                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                ?></span></td>
                                                    <td class="col-3 border-0" style="width: 20%;"><span class="puFacture"><?php echo number_format($category_name3[1], 0, ",", "."); ?> <?php echo $settings->currency; ?></span></td>
                                                    <td class="col-1 border-0 text-right" style="width: 15%;"><span class="qtFacture"><?php echo $category_name3[3]; ?></span></td>
                                                    <td class="col-2 border-0 text-right" style="width: 20%;"><span class="montantFacture"><?php echo number_format($category_name3[1] * $category_name3[3], 0, ",", "."); ?> <?php echo $settings->currency; ?></span></strong></td>
                                                    <td class="no-print" style="padding-top:2px;">
                                                        <?php
                                                        // Check si de Type Labos
                                                        if ($category_name3[5] == 'service') {
                                                            $prestation_en_cours = $this->finance_model->getPaymentCategoryByOrganisationById2($category_name3[0]);
                                                            $est_labo = $prestation_en_cours->code_service == "labo" ? TRUE : FALSE;
                                                            if ($est_labo) {
                                                        ?>
                                                                <a style="cursor: pointer;" class="pull-right editbutton2" data-toggle="modal" data-id="<?php echo $category_name2; ?>">
                                                                    <div class="pull-right" style="font-size:24px;color:#f7bb19;"><i class="fa fa-ticket-alt" style="margin-top:0;"></i></div>
                                                                </a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>


                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body px-2">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <?php if (!empty($payment->frais_service)) { ?>
                                    <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><?php echo lang('frais_service'); ?> :</td>
                                            <td colspan="4" class="bg-light-2 text-right"> <?php $frais_service = $payment->frais_service;
                                                echo number_format($frais_service, 0, ",", "."); ?> <?php echo $settings->currency;?>
                                                <input hidden type="text" id="frais_service" value="<?php $frais_service = $payment->frais_service;
                                                echo number_format($frais_service, 0, ",", "."); ?> <?php echo $settings->currency;?>">
                                            </td>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><strong><?php echo lang('sub_total') . ':'; ?></strong></td>
                                            <td colspan="4" class="bg-light-2 text-right"> <?php echo number_format($payment->amount, 0, ",", "."); ?> <?php echo $settings->currency; ?>
                                                <input hidden type="text" id="tPartiel" value="<?php echo number_format($payment->amount, 0, ",", "."); ?> <?php echo $settings->currency; ?>">
                                            </td>
                                        </tr>
                                        <?php if (!empty($payment->remarks)) { ?>
                                            <input hidden id="codeAssurance" type="text" value="<?php echo $payment->remarks; ?>">
                                            <tr>
                                                <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                                <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                                <td colspan="4" class="bg-light-3 text-right"><?php echo lang('nom_mutuelle'); ?> : </td>
                                                <td colspan="4" class="bg-light-2 text-right"> <?php echo $payment->remarks; ?>
                                                    <input hidden id="nomAssureur" type="text" value="<?php echo $payment->remarks; ?>">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                                <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                                <td colspan="4" class="bg-light-3 text-right"><?php echo lang('charge_mutuelless'); ?> : </td>
                                                <td colspan="4" class="bg-light-2 text-right"> <?php echo  number_format($payment->charge_mutuelle, 0, ",", "."); ?> <?php echo $settings->currency; ?>
                                                    <input hidden id="priseCharge" type="text" value="<?php echo  number_format($payment->charge_mutuelle, 0, ",", "."); ?> <?php echo $settings->currency; ?>">
                                                </td>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><strong><?php echo lang('discount'); ?> :</strong></td>
                                            <td colspan="4" class="bg-light-2 text-right"><span class="remiseClient"><?php
                                                                                                                        $discount = explode('*', $payment->discount);
                                                                                                                        if (!empty($discount[1])) {
                                                                                                                            echo $discount[0] . ' %  =  ' . $settings->currency . ' ' . $discount[1];
                                                                                                                        } else {
                                                                                                                            echo number_format($discount[0], 0, ",", ".");
                                                                                                                        }
                                                                                                                        ?>
                                                    <?php
                                                    if ($discount_type == 'percentage') {
                                                        echo '(%) : ';
                                                    } else {
                                                        echo ' ' . $settings->currency;
                                                    }
                                                    ?></span>
                                                <input hidden type="text" id="remise" value="<?php
                                                                                                $discount = explode('*', $payment->discount);
                                                                                                if (!empty($discount[1])) {
                                                                                                    echo $discount[0] . ' %  =  ' . $settings->currency . ' ' . $discount[1];
                                                                                                } else {
                                                                                                    echo number_format($discount[0], 0, ",", ".");
                                                                                                }
                                                                                                ?>
                                                <?php
                                                if ($discount_type == 'percentage') {
                                                    echo '(%) : ';
                                                } else {
                                                    echo ' ' . $settings->currency;
                                                }
                                                ?>">
                                            </td>
                                            </td>
                                        </tr>
                                        <?php if (!empty($payment->vat)) { ?>
                                            <tr>
                                                <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                                <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                                <td colspan="4" class="bg-light-3 text-right">VAT : </td>
                                                <td colspan="4" class="bg-light-2 text-right"> <?php
                                                                                                if (!empty($payment->vat)) {
                                                                                                    echo $payment->vat;
                                                                                                } else {
                                                                                                    echo '0';
                                                                                                }
                                                                                                ?> % = <?php echo number_format($payment->flat_vat, 0, ",", "."); ?> <?php echo $settings->currency; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><?php echo lang('grand_total'); ?> :</td>
                                            <td colspan="4" class="bg-light-2 text-right"> <?php if(!empty($payment->frais_service)){
                                                $g = $payment->gross_total + $payment->frais_service;
                                                echo number_format($g, 0, ",", "."); ?> <?php echo $settings->currency;} 
                                                else {
                                                    $g = $payment->gross_total;
                                                    echo number_format($g, 0, ",", "."); ?> <?php echo $settings->currency;
                                                } ?>
                                                
                                             
                                                <input hidden type="text" id="mtotal" value="<?php if(!empty($payment->frais_service)){
                                                $g = $payment->gross_total + $payment->frais_service;
                                                echo number_format($g, 0, ",", "."); ?> <?php echo $settings->currency;} 
                                                else {
                                                    $g = $payment->gross_total;
                                                    echo number_format($g, 0, ",", "."); ?> <?php echo $settings->currency;
                                                } ?>">
                                            </td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><?php echo lang('amount_received'); ?> :</td>
                                            <td colspan="4" class="bg-light-2 text-right"> <?php $r = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                            echo number_format($r, 0, ",", "."); ?> <?php echo $settings->currency; ?>
                                                <input hidden type="text" id="mrecu" value="<?php $r = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                            echo number_format($r, 0, ",", "."); ?> <?php echo $settings->currency; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light-3 text-right" style="width: 25%;"></td>
                                            <td class="bg-light-3 text-right" style="width: 35%;"></td>
                                            <td colspan="4" class="bg-light-3 text-right"><?php echo lang('amount_to_be_paid'); ?> : </td>
                                            <td colspan="4" class="bg-light-2 text-right"> <?php $rp = $g - $r;
                                                                                            echo number_format($rp, 0, ",", "."); ?> <?php echo $settings->currency; ?>
                                                <input hidden type="text" id="mpayer" value="<?php $rp = $g - $r;
                                                                                                echo number_format($rp, 0, ",", "."); ?> <?php echo $settings->currency; ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                                    <h5><strong>Effectué par : </strong><?php
                                                                        $users = $this->home_model->getUserById($payment->user);
                                                                        echo $users->first_name . ' ' . $users->last_name;

                                                                        ?></h5>
                                    <input hidden id="effectuerPar" type="text" value="<?php
                                                                                        $users = $this->home_model->getUserById($payment->user);
                                                                                        echo $users->first_name . ' ' . $users->last_name;

                                                                                        ?>">
                                    <input hidden id="users" type="text" value="<?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?>">
                                    <input hidden type="text" id="signatureBase64" value="<?php echo $signatureBase64 ?>">
                                </div>

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
                <p style="display:none" class="text-4"><strong></strong> <span style=""> <?php echo  $nom_organisation . ', ' . $settings->address . ',  Tel: ' . $settings->phone . ' Mail : ' . $settings->email; ?></span></p>
                <div class="btn-group btn-group-sm d-print-none text-center" style="width: 62%;">
                    <?php
                    $page = '';
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } ?>
                    <?php if ($page == 'patient') {  ?>
                        <a href="patient/medicalHistory?id=<?php echo $payment->patient; ?>&type=payment" class="btn btn-info btn-sm invoice_button pull-left"><i class="fa fa-arrow-circle-left"></i> <?php echo lang('back_to_patient'); ?> </a>
                    <?php } else if ($page == 'historique') { ?>
                        <a href="finance/patientPaymentHistory?patient=<?php echo $payment->patient; ?>" class="btn btn-info btn-sm invoice_button pull-left"><i class="fa fa-arrow-circle-left"></i> <?php echo lang('back_to_payment_histo'); ?> </a>
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('Receptionist'))) { ?>
                        <a href="finance/payment" class="btn btn-info btn-sm invoice_button pull-left"><i class="fa fa-arrow-circle-left"></i> <?php echo lang('back_to_payment_modules'); ?> </a>
                    <?php   } else { ?>
                        <a href="finance/paymentLabo" class="btn btn-info btn-sm invoice_button pull-left"><i class="fa fa-arrow-circle-left"></i> <?php echo lang('back_to_payment_modules'); ?> </a>
                    <?php  } ?>
                    <button type="submit" onclick="print()" class="btn btn-info btn-sm invoice_button pull-left" style="margin-left: 2%;"><i class="fa fa-print"></i> Imprimer</button>
                    <button type="submit" onclick="download()" class="btn btn-info btn-sm detailsbutton pull-left download" style="margin-left: 2%;"><i class="fa fa-download"></i> Télécharger</button>


                    <div class="no-print" style="display:none;">
                        <a href="finance/addPaymentView" class="pull-left">
                            <div class="btn-group">
                                <button id="" class="btn btn-info green btn-sm">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_another_payment'); ?>
                                </button>
                            </div>
                        </a>

                    </div>

                    <div class="panel_button" style="display:none;">

                        <div class="text-center invoice-btn no-print pull-left ">
                            <a href="finance/previousInvoice?id=<?php echo $payment->id ?>" class="btn btn-info btn-lg green previousone1"><i class="glyphicon glyphicon-chevron-left"></i> </a>
                            <a href="finance/nextInvoice?id=<?php echo $payment->id ?>" class="btn btn-info btn-lg green nextone1 "><i class="glyphicon glyphicon-chevron-right"></i> </a>

                        </div>

                    </div>

                </div>
                <!-- <div class="btn-group btn-group-sm d-print-none text-center" style="width: 60%;"><a href="finance/expense" class="btn btn-info btn-sm invoice_button pull-left"><i class="fa fa-arrow-circle-left"></i>Retour</a> <button type="submit" onclick="print()" class="btn btn-info btn-sm invoice_button pull-left" style="margin-left: 2%;"><i class="fa fa-print"></i> Imprimer</button> <button type="submit" onclick="download()" class="btn btn-info btn-sm detailsbutton pull-left download" style="margin-left: 2%;"><i class="fa fa-download"></i> Télécharger</button></div> -->
            </footer>

        </div>


    </section>



    <style>
        th {
            text-align: center;
        }

        td {
            text-align: center;
        }

        tr.total {
            color: green;
        }



        .control-label,
        .control-label2 {
            width: 100px;
        }

        .control-label2 {
            font-weight: 800;
        }



        h1 {
            margin-top: 5px;
        }


        .print_width {
            width: 50%;
            float: left;
        }

        ul.amounts li {
            padding: 0px !important;
        }

        .invoice-list {
            margin-bottom: 10px;
        }




        .panel {
            border: 0px solid #5c5c47;
            background: #fff !important;
            height: 100%;
            margin: 20px 5px 5px 5px;
            border-radius: 0px !important;
            min-height: 700px;

        }



        .table.main {
            margin-top: -50px;
        }



        .control-label,
        .control-label2 {
            margin-bottom: 0px;
        }

        tr.total td {
            color: green !important;
        }

        .theadd th {
            background: #edfafa !important;
            background: #fff !important;
        }

        td {
            font-size: 12px;
            padding: 5px;
            font-weight: bold;
        }

        .details {
            font-weight: bold;
        }

        hr {
            border-bottom: 0px solid #f1f1f1 !important;
        }

        .corporate-id {
            margin-bottom: 5px;
        }

        .adv-table table tr td {
            padding: 5px 10px;
        }



        .btn {
            margin: 10px 10px 10px 0px;
        }

        .invoice_head_left h3 {
            color: #2f80bf !important;
            font-family: cursive;
        }


        .invoice_head_right {
            margin-top: 10px;
        }

        .invoice_footer {
            margin-bottom: 10px;
        }










        @media print {

            h1 {
                margin-top: 5px;
            }

            #main-content {
                padding-top: 0px;
            }

            .print_width {
                width: 50%;
                float: left;
            }

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }

            .wrapper {
                margin-top: 0px;
            }

            .wrapper {
                padding: 0px 0px !important;
                background: #fff !important;

            }



            .wrapper {
                border: 2px solid #777;
            }

            .panel {
                border: 0px solid #5c5c47;
                background: #fff !important;
                padding: 0px 0px;
                height: 100%;
                margin: 5px 5px 5px 5px;
                border-radius: 0px !important;

            }

            .site-min-height {
                min-height: 950px;
            }



            .table.main {
                margin-top: -50px;
            }



            .control-label {
                margin-bottom: 0px;
            }

            tr.total td {
                color: green !important;
            }

            .theadd th {
                background: #777 !important;
            }

            td {
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }

            .details {
                font-weight: bold;
            }

            hr {
                border-bottom: 0px solid #f1f1f1 !important;
            }

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }

            .invoice_head {
                width: 100%;
            }

            .invoice_head_left {
                float: left;
                width: 40%;
                color: #2f80bf;
                font-family: cursive;
            }

            .invoice_head_right {
                float: right;
                width: 40%;
                margin-top: 10px;
            }

            .hr_border {
                width: 100%;
            }

            .invoice_footer {
                margin-bottom: 10px;
            }


        }

        .modal-dialog {
            max-width: 350px;
            /* New width for default modal */
        }
    </style>
    <style id="dynamic-style">
        /* Default pour Modal */
        @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            body {
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            #printSection,
            #printSection * {
                visibility: visible;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

    <input id="annif" type="hidden" value="<?php echo $patient_info->birthdate; ?>">
    <input id="datejour" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
    <input id="datejourfooter" type="hidden" name="date" value='<?php echo date('d/m/Y H:i'); ?>' placeholder="">


    <!-- Edit Event Modal-->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header no-print" style="border-bottom:0;">
                    <div class="panel-body" style="font-size: 10px;">
                        <!--<div class="row invoice-list">
								<div class="col-md-12" style="">

									<div class="col-md-12 row details" style="">-->
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <!--<h4 class="modal-title" style="text-align:center;">Labels d'échantillons</h4>-->
                        <!--</div>
						</div>
						</div>-->
                    </div>
                </div>
                <div class="modal-body">
                    <!--<div class="panel-body" style="font-size: 10px;">-->
                    <div class="row invoice-list" style="font-size: 10px;">
                        <div class="col-md-12" style="">

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">ID Acte: </label>
                                        <span class="modal_id_acte">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">Patient: </label>
                                        <span class="modal_identite_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Date de naissance: </label>
                                        <span class="modal_date_naissance_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Téléphone: </label>
                                        <span class="modal_tel_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Sexe: </label>
                                        <span class="modal_sexe_patient">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;font-weight:bold;" class="">
                                        <label class="control-label2">Prélèvement</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12 hr_border" style="margin-top:1px;margin-bottom:1px;">
                            <hr>
                        </div>
                        <div class="col-md-12" style="">

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">ID Acte: </label>
                                        <span class="modal_id_acte">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">Patient: </label>
                                        <span class="modal_identite_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Date de naissance: </label>
                                        <span class="modal_date_naissance_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Téléphone: </label>
                                        <span class="modal_tel_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Sexe: </label>
                                        <span class="modal_sexe_patient">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;font-weight:bold;" class="">
                                        <label class="control-label2">Prélèvement</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12 hr_border" style="margin-top:1px;margin-bottom:1px;">
                            <hr>
                        </div>
                        <div class="col-md-12" style="">

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">ID Acte: </label>
                                        <span class="modal_id_acte">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2">Patient: </label>
                                        <span class="modal_identite_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Date de naissance: </label>
                                        <span class="modal_date_naissance_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Téléphone: </label>
                                        <span class="modal_tel_patient">
                                            ...
                                        </span>
                                    </span>
                                    <br /><span style="text-transform: uppercase;">
                                        <label class="control-label2">Sexe: </label>
                                        <span class="modal_sexe_patient">
                                            ...
                                        </span>
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-12 row details" style="">
                                <p>
                                    <span style="text-transform: uppercase;font-weight:bold;" class="">
                                        <label class="control-label2">Prélèvement</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br />
                                    </span>
                                    <span style="text-transform: uppercase;">
                                        <label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->

                </div>
            </div><!-- /.modal-content -->
            <div class="btn-group btn-group-sm d-print-none" style="width:100%">
                <!-- <a class="btn btn-info btn-sm invoice_button pull-left" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Retour </a> -->
                <button type="submit" onclick="print()" class="btn btn-info btn-sm invoice_button pull-right" style="margin-left: 2%;"><i class="fa fa-print"></i> Imprimer</button>
                <a data-dismiss="modal" class="btn btn-info btn-sm invoice_button pull-right" style="margin-left: 2%;color:#edfafa">Retour</a>
            </div>

        </div><!-- /.modal-dialog -->
    </div>
    <!-- Edit Event Modal-->


    <!-- <input hidden type="text" id="logo2" value="<?php echo !empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>">
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
    <input hidden type="text" id="effectuerPar" value="<?php echo $expense->first_name . ' ' . $expense->last_name; ?>"> -->


</section>

<script src="common/js/codearistos.min.js"></script>
<script src="common/js/autoNumeric.min.js"></script>

<script>
    var dateAnnif = $('#annif').val();
    var datejourFooter = $('#datejourfooter').val();
    var dateFooter = datejourFooter.match(/\d{2}\/\d{2}\/\d{4}/)[0];
    var Heure = datejourFooter.match(/\d{2}:\d{2}/)[0];
    var Age = '';
    if (dateAnnif != '') {
        dateAnnif = dateAnnif.split("/")[2];
        dateAnnif = parseInt(dateAnnif);
        var datejour = $('#datejour').val();
        datejour = datejour.split("/")[2];
        datejour = parseInt(datejour);
        var Age = datejour - dateAnnif;
        document.querySelector("#age").innerHTML = Age + ' An(s)';

    } else {
        document.querySelector("#age").innerHTML = 'Non renseigné';
    }




    // if (isNaN(Age)) {
    //      return 0;
    //  }




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


<script src="common/js/ecomed24.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#btnPrint0").click(function(e) {
            e.preventDefault(e);
            // Readaptation au k où un print des tickets a été fait auparavant
            $("#dynamic-style").text("");

            var $printSection = document.getElementById("printSection");

            if ($printSection) {
                document.body.removeChild($printSection);
            }


            // alert($("#dynamic-style").text());
        });
        $(".editbutton2").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var paymentCode = <?php echo json_encode($payment->code); ?>;
            var prestationId = (iid.split("*"))[0];
            // var acteId = paymentCode+"-"+prestationId;
            var acteId = paymentCode + "" + prestationId;
            var identitePatient = <?php echo json_encode($patient_info->last_name . ", " . $patient_info->name); ?>;
            var telPatient = <?php echo json_encode($patient_info->phone); ?>;
            var dateNaissancePatient = <?php echo json_encode($patient_info->birthdate); ?>;
            var sexePatient = <?php echo json_encode($patient_info->sex); ?>;
            sexePatient = sexePatient == "Masculin" ? "M" : "F";
            // var sexePatient = <?php echo $patient_info->sex == "Masculin" ? "M" : "F"; ?>;
            // alert("$(this).attr('data-id'): "+paymentCode+"-"+prestationId);
            // $('#editServiceForm').trigger("reset");
            // $.ajax({
            // url: 'service/editServiceByJason?id=' + iid,
            // method: 'GET',
            // data: '',
            // dataType: 'json',
            // }).success(function (response) {
            // Populate the form fields with the data returned from server
            // $('#editServiceForm').find('[name="id"]').val(response.service.id).end()
            // $('#editServiceForm').find('[name="title"]').val(response.service.title).end()
            // $('#editServiceForm').find('[name="description"]').val(response.service.description).end()
            $('.modal_id_acte').text(acteId);
            $('.modal_identite_patient').text(identitePatient);
            $('.modal_tel_patient').text(telPatient);
            $('.modal_date_naissance_patient').text(dateNaissancePatient);
            $('.modal_sexe_patient').text(sexePatient);
            $('#myModal2').modal('show');
            // });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script>
    $('#download').click(function() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addHTML($('#invoice'), function() {
            pdf.save('invoice_id_<?php echo $payment->code; ?>.pdf');
        });
    });

    // This code is collected but useful, click below to jsfiddle link.
</script>
<script>
    document.getElementById("btnPrint").onclick = function() {
        printElement(document.getElementById("myModal2"));
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        $("#dynamic-style").text(
            "@media screen {" +
            "#printSection {" +
            "display: none;" +
            "}" +
            "}" +
            "@media print {" +
            "body * {" +
            "visibility:hidden;" +
            "}" +
            "#printSection, #printSection * {" +
            "visibility:visible;" +
            "}" +
            "#printSection {" +
            "position:absolute;" +
            "left:0;" +
            "top:0;" +
            "}" +
            "}"
        );


    }
</script>



</section>
<!-- invoice end-->
</section>
</section>
<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
<script>
    var agePatient = ' ';
    <?php if (!empty($patient_info->age)) :
    ?>
        var agePatient = $('#agePatient').val() + ' Ans';
    <?php else : ?>
        agePatient = Age + ' An(s)';
    <?php endif; ?>
    var descOrganisation = $('#descOrganisation').val();
    var slogan = $('#slogan').val();
    var horaire = $('#horaire').val();
    var dateFacture = $('#dateFacture').val();
    var codeFacture = $('#codeFacture').val();
    var email = $('#email').val();
    var nomOrganisation = $('#nomOrganisation').val();
    var tel = $('#tel').val();
    var telfooter = $('#tel').val();
    var codePatient = $('#codePatient').val();
    var prenom = $('#prenom').val();
    var nom = $('#nom').val();
    var phonePatient = $('#phonePatient').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var addressPatient = $('#addressPatient').val();
    var tpartiel = $('#tPartiel').val();
    var remise = $('#remise').val();
    var mpayer = $('#mpayer').val();
    var mrecu = $('#mrecu').val();
    var mtotal = $('#mtotal').val();
    var frais_service = $('#frais_service').val();
    var users = $('#users').val();
    var prescripteur = $('#prescripteur').val();
    var nomAssureur = $('#nomAssureur').val();
    var priseCharge = $('#priseCharge').val();
    var user_email = $('#user_email').val();
    var user_name = $('#user_name').val();
    var user_phone = $('#user_phone').val();
    var user_fixe = $('#user_fixe').val();
    var sexePatient = $('#sexePatient').val();
    var date_naissance = $('#annif').val();
    if (sexePatient === 'Masculin') {
        sexePatient = 'M';
    }
    if (sexePatient === 'Feminin') {
        sexePatient = 'F';
    }
    // var patientPassport = $('#patientPassport').val();
    var patientEmail = $('#patientEmail').val();
    var codeAssurance = $('#codeAssurance').val();
    var effectuerPar = $('#effectuerPar').val();
    var remiseClient = document.querySelector('.remiseClient').textContent;
    remiseClient = remiseClient.replace('                     ', '').replace('                     ', '').replace('     ', '').replace('     ', '');
    var horaireOuverture = document.getElementById('descriptionConfirmation').innerText;
    var signatureBase64 = $('#signatureBase64').val();

    //   var montantFacture = document.querySelector('.montantFacture').textContent;

    // if (patientPassport) {
    //     patientPassport = patientPassport;
    // } else {
    //     patientPassport = 'Non renseigné';
    // }

    if (patientEmail) {
        patientEmail = patientEmail;
    } else {
        patientEmail = 'Non renseigné';
    }
    // horaireOuverture = horaireOuverture.replace('<p>', '').replace('</p>', '');
    //alert(codeAssurance);

    if(frais_service === undefined){
        frais_service = '0 FCFA';
    }
    
    if (codeAssurance === undefined) {
        nomAssureur = "Pas d'assureur";
        priseCharge = "Pas de prise en charge";
    } else {
        nomAssureur = nomAssureur;
        priseCharge = priseCharge;
    }
    if (telfooter == '') {
        telfooter = '';
    } else {
        telfooter = ', Tel: ' + tel;
    }

    if (addressPatient != '') {
        addressPatient = addressPatient;

    } else {
        addressPatient = 'Non renseigné';
    }


    if (phonePatient != '') {
        phonePatient = phonePatient;
    } else {
        phonePatient = 'Non renseigné';
    }

    var qr_details = 'Patient Prénom: ' + prenom + ' ' + nom + ', date de naissance: ' + date_naissance + ', date de facturation :' + dateFacture + ', montant total : ' + mrecu;

   



    async function download() {
        // pdfMake.createPdf(dd).download();


        await pdfMake.createPdf(dd).download('Facture_' + codeFacture + '.pdf');
        setTimeout(() => {
            window.location.reload(true);
        }, 2000);

    }

    async function print() {
        pdfMake.createPdf(dd).print();
        setTimeout(() => {
            window.location.reload(true);
        }, 2000);
    }

    var dd = {
        pageSize: 'A4',
        //pageMargins: [40, 40, 40, 100],
        footer: [{
            columns: [{
                image: '/sampleImage.jpg/',
                width: 550,
                height: 20
            }],
            margin: [0, 0]
        }],
        content: [
            'Page Contents'
        ],
        content: [{

                columns: [

                    {
                        image: '/sampleImage.jpg/',
                        width: 550,
                        height: 90
                    }
                ],
                margin: [-8, -8]
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
                alignment: 'justify',
                columns: [
                    [{
                        text: 'Emise le :',
                        style: 'tableHeader',
                        fit: [50, 50]
                    }, {
                        text: dateFacture,
                        fit: [50, 50]
                    }],
                    [{
                        text: 'Numéro Reçu :',
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
                style: 'tableExample',
                layout: 'noBorders',
                table: {
                    headerRows: 1,
                    widths: [220, '*', 220],

                    // dontBreakRows: true,
                    // keepWithHeaderRows: 1,
                    body: [
                        [{
                            text: nomOrganisation,
                            style: 'tableHeader',
                            color: '#0D4D99'
                        }, {
                            text: '',
                            style: 'tableHeader'
                        }, {
                            text: 'Infos Patient',
                            style: 'tableHeader',
                            color: '#0D4D99'
                        }],
                        [{
                                text: [{
                                        text: 'Prénom et Nom : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    user_name + '\n',
                                    {
                                        text: 'Téléphone Mobile : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    user_phone + '\n',
                                    {
                                        text: 'Téléphone Fixe : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    user_fixe + '\n',
                                    {
                                        text: 'Email : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    user_email + '\n',
                                    {
                                        text: 'Médecin Prescripteur : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    prescripteur + '\n'
                                ],

                            },
                            {
                                text: ''
                            },
                            {
                                text: [{
                                        text: 'Code : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    codePatient + '\n',
                                    {
                                        text: 'Prénom et Nom : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    prenom + ' ' + nom + '\n',
                                    {
                                        text: 'Téléphone : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    phonePatient + '\n',
                                    {
                                        text: 'Adresse : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    addressPatient + '\n',
                                    {
                                        text: 'Age : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    agePatient + '\n',
                                    {
                                        text: 'Sexe: ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    sexePatient + '\n',
                                    // {
                                    //     text: 'Passeport: ',
                                    //     fontSize: 12,
                                    //     bold: true
                                    // },
                                    // patientPassport + '\n',
                                    {
                                        text: 'Email: ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    patientEmail + '\n',


                                ],

                            },


                        ]
                    ],

                }
            },
            {
                style: 'tableExample',
                table: {
                    widths: [15, '*', 110, 70, 80],
                    headerRows: 1,
                    lineColor: '#0D4D99',
                    body: [
                        [{
                                text: '#',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            }, {
                                text: 'Description',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            }, {
                                text: 'Prix Unitaire',
                                alignment: 'right',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            },
                            {
                                text: 'Quantitié',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            },
                            {
                                text: 'Montant',
                                style: 'tableHeader',
                                alignment: 'right',
                                color: '#0D4D99'
                            },
                        ],
                        ...Array.from(document.querySelectorAll('.ligneFacture'))
                        .map(e => ([{
                                text: e.querySelector('.idFacture').textContent,
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.prestationFacture').textContent,
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.puFacture').textContent,
                                alignment: 'right',
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.qtFacture').textContent,
                                alignment: 'center',
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.montantFacture').textContent,
                                fontSize: 10,
                                alignment: 'right'
                            },
                        ])),
                    ]
                },
                layout: 'lightHorizontalLines',
            },
            {
                style: 'tableExample',
                table: {
                    widths: ['*', 130, 80],
                    body: [
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Frais de Service', {
                            text: frais_service,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Montant Total', {
                            text: tpartiel,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Remise  ', {
                            text: remiseClient,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Montant dû', {
                            text: mtotal,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Montant reçu', {
                            text: mrecu,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Reste à payer', {
                            text: mpayer,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Nom assureur', {
                            text: nomAssureur,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 8,
                            text: ''
                        }, 'Prise en Charge', {
                            text: priseCharge,
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
                text: '',
                style: 'header'
            },
            {
                style: 'tableExample',
                layout: 'noBorders',
                table: {
                    headerRows: 1,
                    widths: [150, "*", 200],
                    body: [
                        [{
                                qr: qr_details,
                                fit: '120',
                                margin: [0, 40, 0, 0]

                            },
                            {
                                text: '',
                                style: 'header'
                            },
                            {
                                columns: [{
                                    image: signatureBase64,
                                    width: 190,
                                    height: 190,
                                    margin: [0, -10, 0, 0]
                                }],
                            },

                        ],
                    ],
                },
            },
            {
                text: 'Scanner ce QR Code à l\'aide de votre Smartphone connecté à internet pour vérifier l\'authenticité des informations contenues dans ce document',
                alignment: 'left',
                fontSize: 11,
                margin: [0, -20, 0, 0]
            }
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
        document.querySelector("#logoHeader").innerHTML = dataUrl;
    })

    toDataURL(footer, function(dataUrl) {
        document.querySelector("#logoFooter").innerHTML = dataUrl;
        dd.footer[0].columns[0].image = dataUrl;
        //   dd.footer.image = dataUrl;
        // alert(dataUrl);
    })



    // document.querySelectorAll('.ligneFacture').forEach(e => {
    //     console.log(e.querySelector('.dateFacture').textContent);
    //     console.log(e.querySelector('.codeFacture').textContent);
    //     console.log(e.querySelector('.codePatientFacture').textContent);
    //     console.log(e.querySelector('.prestationFacture').textContent);
    //     console.log(e.querySelector('.montantFacture').textContent);
    // })

    const avengers = ['thor', 'captain america', 'hulk'];
    avengers.forEach((item, index) => {
        console.log(index, item)
    })

    function getImage(base64) {
        let canvas = document.createElement('canvas');
        let img = document.createElement('img');
        img.src = base64;


        canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height,
            0, 0, canvas.width, canvas.height);

        return canvas.toDataURL('image/png');
    }
</script>