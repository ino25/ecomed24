<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Infos Patient
            </header>
            <div class="">
                <input type="hidden" id="id_patient" value="<?php echo $id_patient ?>">
                <div class="container">
                    <h2>Informations JSON PATIENT </h2>
                    <div class="panel panel-default">
                        <div class="responseJson" class="panel-body" style="font-size: 1.2em;"></div>
                    </div>
                </div>

            </div>

            <style>
                table,
                th,
                td {
                    border: 1px solid #f1f2f7;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 2px;
                    text-align: left;
                    font-size: 12px;
                }
            </style>

            <table style="margin-bottom:5px;width: 100%;">
                <thead>
                    <tr>
                        <th>Donnée</th>
                        <th colspan="2">Description</th>
                    </tr>
                </thead>
                <tbody>

                    <tr onclick="updateLogin('admin@zuulumed.net','12345')">
                        <td>id</td>
                        <td>Numéro d'insertion du patient</td>
                    </tr>

                    <tr onclick="updateLogin('adminmedecin@zuulumed.net','12345')">
                        <td>id_organisation</td>
                        <td>l'identifiant de l'organisation</td>
                    </tr>
                    <tr onclick="updateLogin('docteur@zuulumed.net','12345')">
                        <td>img_url</td>
                        <td>la photo du patient</td>
                    </tr>
                    <tr onclick="updateLogin('infirmiere@zuulumed.net','12345')">
                        <td>name</td>
                        <td>Prenom du patient</td>
                    </tr>


                    <tr onclick="updateLogin('labo@zuulumed.net','12345')">
                        <td>last_name</td>
                        <td>Nom du patient </td>
                    </tr>

                    <tr onclick="updateLogin('comptable@zuulumed.net','12345')">
                        <td>doctor</td>
                        <td>l'identifiant du doctor (facultatif)</td>
                    </tr>

                    <tr onclick="updateLogin('reception@zuulumed.net','12345')">
                        <td>address</td>
                        <td>Adress du patient</td>
                    </tr>

                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>phone</td>
                        <td>Le numero du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>phone_recuperation</td>
                        <td>Le numero du patient avec indicatif (facultatif)</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>sex</td>
                        <td>Le sexe du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>birthdate</td>
                        <td>Date de naissance du patient</td>
                    </tr>
                    <tr onclick="updateLogin('reception@zuulumed.net','12345')">
                        <td>age</td>
                        <td>Age du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>bloodgroup</td>
                        <td>Groupe Sanguin du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>ion_user_id</td>
                        <td>L'utilisateur qui a créé le patient (facultatif)</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>patient_id</td>
                        <td>Le code du patient </td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>add_date</td>
                        <td>La date de création du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>registration_time</td>
                        <td>L'heure de création du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>status</td>
                        <td>Statut du client s'il est actif</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>matricule</td>
                        <td>Matricule du patient (non civil) </td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>birth_position</td>
                        <td>Date de naissance du tuteur</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>nom_contact</td>
                        <td>Prenom et Nom du tuteur</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>phone_contact</td>
                        <td>Téléphone du tuteur</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>phone_contact_recuperation</td>
                        <td>Téléphone avec indicatif du tuteur (facultatif)</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>region</td>
                        <td>Région du patient</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>lien_parente</td>
                        <td>Lien de parenté avec un tuteur</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>parent_id</td>
                        <td>Code du tuteur</td>
                    </tr>
                    <tr onclick="updateLogin('patient@zuulumed.net','12345')">
                        <td>passport</td>
                        <td>Numéro passport Patient</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </section>
    <!--main content end-->
    <!--footer start-->




    <!-- Add Patient Material Modal-->

    <!-- Add Patient Modal-->


    <script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>



    <script>
        $(document).ready(function() {
            idpatient = $('#id_patient').val();
            resultat = "";
            $.ajax({
                url: 'patient/getPatientByJason?id=' + idpatient,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                console.log("***** Response JSON");
                console.log(JSON.stringify(response));
                console.log("***** Response JSON");
                resultat = JSON.stringify(response.patient, null, 2);
                $('.responseJson').append(resultat).end();
                // alert(JSON(response.patient.img_url));
                //  var img_tag = JSON.stringify(response.patient.img_url) !== "null" ? "<img class='avatar' src='" + response.patient.img_url + "' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>" : "<img class='avatar' src='uploads/imgUsers/contact-512.png' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>";

            });
        });
    </script>