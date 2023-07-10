-- regionAtAgentEnrolment

CREATE TABLE `region_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE region_senegal AUTO_INCREMENT=234;



INSERT INTO region_senegal (id, label) 
VALUES
( 234, "Dakar"),
( 236, "Diourbel"),
( 238, "Fatick"),
( 240, "Kaffrine"),
( 242, "Kaolack"),
( 244, "Kedougou"),
( 246, "Kolda"),
( 248, "Louga"),
( 250, "Matam"),
( 252, "SaintLouis"),
( 254, "Sedhiou"),
( 256, "Tambacounda"),
( 258, "Thies"),
( 260, "Ziguinchor");




