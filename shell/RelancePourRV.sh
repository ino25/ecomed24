#!/bin/bash

#MYSQL="mysql --host=172.18.89.212 --port=3306 -u zuulu -p1ZAwdWAh2bHHxYWy8i7 zuulu -Nbe"
MYSQL="mysql -u root -pbayete dbzuulumedTest -Nbe"
dateDuJour=`date --utc +%d/%m/%Y_%H:%M:%S`
# MYSQL="mysql -u zuulu -p1ZAwdWAh2bHHxYWy8i7 zuulu -Nbe"

$MYSQL "select CONCAT_WS('#', appointment.id_organisation, organisation.id_partenaire_zuuluPay) from appointment join organisation on organisation.id = appointment.id_organisation where appointment.date <= CURDATE() and appointment.status='Confirmed' group by appointment.id_organisation" \
| while IFS='#' read -r id_organisation_grouped id_partenaire_zuuluPay;
do
				numero_fixe_organisation=$($MYSQL "select numero_fixe from organisation where id = '$id_organisation_grouped' LIMIT 1;")
					
				while IFS='#' read -r patient id_organisation dayFormatted monthFormatted yearFormatted time_slot status patient_identity patient_email patient_phone nom_organisation numero_fixe_organisation id_partenaire_zuuluPay date_diff_between;
				do
					# Check des regles pour chaque partenaire depuis le fichier config
					rulesArray=($(sed -n 's/relance.'$id_partenaire_zuuluPay'.*: //p' /home/zuulu/ebills_reloaded/RelancePatenaireConfig.txt))
					# Boucle sur les regles du fichier config regles.relance.for_owner_name.*
					for i in "${rulesArray[@]}"
					do
						#echo $id_organisation_grouped $id_partenaire_zuuluPay $i $date_diff_between
						# Si regle.value = date_diff_between
						if [ $date_diff_between -eq $i ]; then
							# Cas où la regler de relance rule et days_remaining match.
							# Envoyer mail & SMS de relance
							#echo $patient_identity" a un RV dans "$date_diff_between" jours."
							echo "On va lui envoyer un petit rappel"
							smsTextPrefix=""
							smsTextSuffix=""
							
							
							# Envoi SMS
							# Recuperer template mail
								# Message
								smsTemplate=$($MYSQL "select REPLACE(REPLACE(message, '\r', ''), '\n', '') from autosmstemplate where type='appointment_reminder' LIMIT 1;")
								# echo "$subjectTemplate"
								sms=$(echo $smsTemplate | sed -e "s/{name}/$patient_identity/" -e "s/{company}/$nom_organisation/" -e "s/{appointmentdate}/$dayFormatted\/$monthFormatted\/$yearFormatted/" -e "s/{time_slot}/$time_slot/" -e "s/{numero_telephone}/$numero_fixe_organisation/" -e "s/{company}/$nom_organisation/")
								# echo $message
								$MYSQL "INSERT INTO sms (message, recipient) VALUES(\"$sms\", \"$patient_phone\");";
							
							# Envoi Mail
								# Recuperer template mail
								# Sujet
								subjectTemplate=$($MYSQL "select name from autoemailtemplate where type='appointment_reminder' LIMIT 1;")
								echo "$subjectTemplate"
								subject=$(echo $subjectTemplate | sed -e "s/{name}/$patient_identity/" -e "s/{company}/$nom_organisation/")
								# Message
								messageTemplate=$($MYSQL "select REPLACE(REPLACE(message, '\r', ''), '\n', '') from autoemailtemplate where type='appointment_reminder' LIMIT 1;")
								# echo "$messageTemplate"
								message=$(echo $messageTemplate | sed -e "s/{name}/$patient_identity/" -e "s/{company}/$nom_organisation/" -e "s/{appointmentdate}/$dayFormatted\/$monthFormatted\/$yearFormatted/" -e "s/{time_slot}/$time_slot/" -e "s/{numero_telephone}/$numero_fixe_organisation/" -e "s/{company}/$nom_organisation/")
								# echo $message
								$MYSQL "INSERT INTO email (subject, message, reciepient) VALUES(\"$subject\",\"$message\", \"$patient_email\");";
						fi
					done
					
				done < <($MYSQL "select CONCAT_WS('#', appointment.patient,appointment.id_organisation, DATE_FORMAT(DATE(FROM_UNIXTIME(appointment.date)),'%d') ,DATE_FORMAT(DATE(FROM_UNIXTIME(appointment.date)),'%m') ,DATE_FORMAT(DATE(FROM_UNIXTIME(appointment.date)),'%Y'),appointment.time_slot, appointment.status, CONCAT(patient.name, ' ',patient.last_name), patient.email, patient.phone, organisation.nom, organisation.numero_fixe, organisation.id_partenaire_zuuluPay,DATEDIFF(DATE(FROM_UNIXTIME(appointment.date)), CURDATE())) from appointment join patient on patient.id = appointment.patient join organisation on organisation.id = appointment.id_organisation and organisation.id = $id_organisation_grouped where appointment.date <= CURDATE() and appointment.status='Confirmed'")
		
done
