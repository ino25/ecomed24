-- departementAtAgentEnrolment

CREATE TABLE `departement_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_region` bigint(20) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE departement_senegal AUTO_INCREMENT=262;

INSERT INTO departement_senegal (id, id_region, label) 
VALUES
(262, 234, "Dakar"),
(264, 234, "Guediawaye"),
(266, 234, "Pikine"),
(268, 234, "Rufisque"),
(270, 236, "Bambey"),
(272, 236, "Diourbel"),
(274, 236, "Mbacke"),
(276, 238, "Fatick"),
(278, 238, "Foundiougne"),
(280, 238, "Gossas"),
(282, 240, "Birkilane"),
(284, 240, "Kaffrine"),
(286, 240, "Koungheul"),
(288, 240, "Malem Hodar"),
(290, 242, "Guinguineo"),
(292, 242, "Kaolack"),
(294, 242, "Nioro du Rip"),
(296, 244, "Kedougou"),
(298, 244, "Salemata"),
(300, 244, "Saraya"),
(302, 246, "Kolda"),
(304, 246, "Medina Yoro Foulah"),
(306, 246, "Velingara"),
(308, 248, "Kebemer"),
(310, 248, "Linguere"),
(312, 248, "Louga"),
(314, 250, "Kanel"),
(316, 250, "Matam"),
(318, 250, "Ranerou Ferlo"),
(320, 252, "Dagana"),
(322, 252, "Podor"),
(324, 252, "Saint Louis"),
(326, 254, "Bounkiling"),
(328, 254, "Goundomp"),
(330, 254, "Sedhiou"),
(332, 256, "Bakel"),
(334, 256, "Goudiry"),
(336, 256, "Koumpentoum"),
(338, 256, "Tambacounda"),
(340, 258, "Mbour"),
(342, 258, "Thies"),
(344, 258, "Tivaouane"),
(346, 260, "Bignona"),
(348, 260, "Oussouye"),
(350, 260, "Ziguinchor");

