	-- //// FACTURE {nro_facture} DU PRESTATAIRE {nom_organisation_prestataire} | PERIODE: {periode_facture}
		-- //// Cher Partenaire,
	-- //// Veuillez recevoir en pièce-jointe la facture numéro {nro_facture} pour la periode {periode_facture}.
		-- //// Merci de votre confiance
		-- //// {nom_organisation_prestataire} via ecoMed24.
		
INSERT INTO `autoemailtemplate` (`name`, `message`, `type`, `status`) VALUES
('FACTURE {nro_facture} DU PRESTATAIRE {nom_organisation_prestataire} | PERIODE: {periode_facture}', '<p>Cher&nbsp;Partenaire,</p>\r\n\r\n<p>Veuillez recevoir en pièce-jointe la facture numéro {nro_facture} pour la periode {periode_facture}.</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{nom_organisation_prestataire} via ecoMed24.</p>\r\n', 'facture_light', 'Active');