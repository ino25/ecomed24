-- //// Email
		-- //// RESULTAT DES ANALYSES DU PRESTATAIRE {nom_organisation_prestataire} | COMMANDE: {nro_commande} | PATIENT {patient_full_name} ({patient_id})
		-- //// Cher Partenaire,
		-- //// Veuillez recevoir en pièce-jointe le résultat des analyses ci-après:
		-- //// {liste_prestations_nom_service_nom_prestation_date}	
		-- //// Merci de votre confiance
		-- //// {nom_organisation_prestataire} via ecoMed24.
		
INSERT INTO `autoemailtemplate` (`name`, `message`, `type`, `status`) VALUES
('RESULTAT DES ANALYSES DU PRESTATAIRE {nom_organisation_prestataire} | COMMANDE: {nro_commande} | PATIENT {patient_full_name} ({patient_id})', '<p>Cher&nbsp;Partenaire,</p>\r\n\r\n<p>Veuillez recevoir en pièce-jointe le résultat des analyses ci-après:</p>\r\n\r\n<p>{liste_prestations_nom_service_nom_prestation_date}</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{nom_organisation_prestataire} via ecoMed24.</p>\r\n', 'resultat_analyses_light', 'Active');