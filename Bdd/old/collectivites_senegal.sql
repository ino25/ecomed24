-- collectiviteAtAgentEnrolment
CREATE TABLE `collectivite_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_arrondissement` bigint(20) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE collectivite_senegal AUTO_INCREMENT=812;

INSERT INTO collectivite_senegal (id, id_arrondissement, label) 
VALUES
(812, 352, "Mermoz Sacre Coeur"),
(814, 352, "Ngor"),
(816, 352, "Ouakam"),
(818, 352, "Yoff"),
(822, 354, "Fann Point E Amitie"),
(824, 354, "Goree"),
(826, 354, "Gueule Tapee Fass Colobane"),
(828, 354, "Medina"),
(820, 354, "Plateau"),
(830, 356, "Biscuiterie "),
(832, 356, "Dieuppeul Derkle"),
(834, 356, "Grand Dakar "),
(836, 356, "Hann Bel Air"),
(838, 356, "Hlm "),
(840, 356, "Sicap Liberte"),
(842, 358, "Camberene"),
(844, 358, "Grand Yoff"),
(846, 358, "Parcelles Assainies"),
(848, 358, "Patte D Oie "),
(850, 360, "Golf Sud"),
(852, 360, "Medina Gounass"),
(854, 360, "Ndiareme Limamoulaye"),
(856, 360, "Sam Notaire "),
(858, 360, "Wakhinane Nimzat"),
(860, 362, "Keur Massar "),
(862, 362, "Malika"),
(864, 362, "Yeumbeul Nord"),
(866, 362, "Yeumbeul Sud"),
(868, 364, "Dalifort"),
(870, 364, "Djida Thiaroye Kao"),
(872, 364, "Guinaw Rail Nord"),
(874, 364, "Guinaw Rail Sud"),
(876, 364, "Pikine Est"),
(878, 364, "Pikine Nord "),
(880, 364, "Pikine Ouest"),
(882, 366, "Diamaguene Sicap Mbao"),
(884, 366, "Mbao"),
(886, 366, "Thiaroye Gare"),
(888, 366, "Thiaroye Sur Mer"),
(890, 366, "Tivavouane Diaksao"),
(892, 368, "Rufisque Est"),
(894, 368, "Rufisque Nord"),
(896, 368, "Rufisque Ouest"),
(898, 370, "Sangalkam"),
(900, 370, "Yene"),
(902, 372, "Bargny"),
(904, 374, "Diamniadio"),
(906, 376, "Sebikotane"),
(910, 378, "Baba Garage "),
(912, 378, "Dinguiraye"),
(914, 378, "Keur Samba Kane"),
(916, 380, "Gawane"),
(918, 380, "Lambaye"),
(920, 380, "Ngogom"),
(922, 380, "Refane"),
(924, 382, "Dangalma"),
(926, 382, "Ndondol"),
(928, 382, "Ngoye"),
(930, 382, "Thiakar"),
(908, 384, "Bambey"),
(934, 386, "Dankh Sene"),
(936, 386, "Gade Escale "),
(938, 386, "Keur Ngalgou"),
(940, 386, "Ndindy"),
(942, 386, "Taiba Moutoupha"),
(944, 388, "Ndoulo"),
(946, 388, "Ngohe"),
(948, 388, "Pattar"),
(950, 388, "Tocky Gare"),
(952, 388, "Toure Mbonde"),
(932, 390, "Diourbel"),
(956, 392, "Dandeye Gouygui"),
(958, 392, "Darou Nahim "),
(960, 392, "Darou Salam Typ"),
(962, 392, "Kael"),
(964, 392, "Madina"),
(966, 392, "Ndioumane Taiba Thiekene"),
(968, 392, "Taiba Thiekene"),
(970, 392, "Touba Mboul "),
(972, 394, "Dalla Ngabou"),
(974, 394, "Missirah"),
(976, 394, "Nghaye"),
(978, 394, "Touba Fall"),
(980, 394, "Touba Mosquee"),
(982, 396, "Sadio"),
(984, 396, "Taif"),
(954, 398, "Mbacke"),
(986, 400, "Diakhao"),
(988, 400, "Diaoule"),
(990, 400, "Mbellacadiao"),
(992, 400, "Ndiob"),
(994, 402, "Djilass"),
(996, 402, "Fimela"),
(998, 402, "Loul Sessene"),
(1000, 402, "Palmarin Facao"),
(1002, 404, "Ngayokheme"),
(1004, 404, "Niakhar"),
(1006, 404, "Patar"),
(1008, 406, "Diarrere"),
(1010, 406, "Diouroup"),
(1012, 406, "Tattaguine"),
(1014, 408, "Diofior"),
(1016, 410, "Fatick"),
(1018, 412, "Diossong"),
(1020, 412, "Djilor"),
(1022, 414, "Bassoul"),
(1024, 414, "Dionewar"),
(1026, 414, "Djirnda"),
(1028, 414, "Niodior"),
(1030, 416, "Keur Saloum Diane"),
(1032, 416, "Keur Samba Gueye"),
(1034, 416, "Nioro Alassane Tall"),
(1036, 416, "Toubacouta"),
(1038, 418, "Foundiougne "),
(1040, 420, "Karang Poste"),
(1042, 422, "Passi"),
(1044, 424, "Sokone"),
(1046, 426, "Soum"),
(1048, 428, "Colobane"),
(1050, 428, "Mbar"),
(1052, 430, "Ndiene Lagane"),
(1054, 430, "Ouadiour"),
(1056, 430, "Patar Lia"),
(1058, 432, "Gossas"),
(1060, 434, "Keur Mboucki"),
(1062, 434, "Touba Mbella"),
(1064, 436, "Mabo"),
(1066, 436, "Ndiognick"),
(1068, 438, "Birkilane"),
(1070, 440, "Boulel"),
(1072, 440, "Gniby"),
(1074, 440, "Kahi"),
(1076, 442, "Diamagadio"),
(1078, 442, "Diokoul Mbelbouck"),
(1080, 442, "Kathiote"),
(1082, 442, "Medinatoul Salam 2"),
(1084, 444, "Kaffrine"),
(1086, 446, "Nganda"),
(1088, 448, "Fass Thiekene"),
(1090, 448, "Ida Mouride "),
(1092, 448, "Saly Escale "),
(1094, 450, "Lour Escale "),
(1096, 450, "Ribot Escale"),
(1098, 452, "Maka Yop"),
(1100, 452, "Missirah Wadene"),
(1102, 452, "Ngainthe Pate"),
(1104, 454, "Koungheul"),
(1106, 456, "Darou Minam "),
(1108, 456, "Khelcom"),
(1110, 456, "Ndioum Ngainthe"),
(1112, 458, "Djanke Souf "),
(1114, 458, "Sagna"),
(1116, 460, "Malem Hodar "),
(1118, 462, "Khelcom Birame"),
(1120, 462, "Mbadakhoune "),
(1122, 462, "Ndiago"),
(1124, 462, "Ngathie Naoude"),
(1126, 464, "Mboss"),
(1128, 464, "Ngagnick"),
(1130, 464, "Ngellou"),
(1132, 464, "Ourour"),
(1134, 466, "Guinguineo"),
(1136, 468, "Keur Baka"),
(1138, 468, "Latmingue"),
(1140, 468, "Thiare"),
(1142, 470, "Keur Soce"),
(1144, 470, "Ndiaffate"),
(1146, 470, "Ndiedieng"),
(1148, 472, "Dya "),
(1150, 472, "Ndiebel"),
(1152, 472, "Thiomby"),
(1154, 474, "Gandiaye"),
(1156, 476, "Kahone"),
(1158, 478, "Kaoloack"),
(1160, 480, "Ndoffane"),
(1162, 482, "Kayemor"),
(1164, 482, "Medina Sabakh"),
(1166, 482, "Ngayene"),
(1168, 484, "Gainte Kaye "),
(1170, 484, "Paoskoto"),
(1172, 484, "Porokhane"),
(1174, 484, "Taiba Niassene"),
(1176, 486, "Keur Maba Diakhou"),
(1178, 486, "Keur Madongo"),
(1180, 486, "Ndrame Escale"),
(1182, 486, "Wack Ngouna "),
(1184, 488, "Keur Madiabel"),
(1186, 490, "Nioro Du Rip"),
(1188, 492, "Bandafassi"),
(1190, 492, "Dindefelo"),
(1192, 492, "Ninefecha"),
(1194, 492, "Tomboronkoto"),
(1196, 494, "Dimboli"),
(1198, 494, "Fongolimbi"),
(1200, 496, "Kedougou"),
(1202, 498, "Dakately"),
(1204, 498, "Kevoye"),
(1206, 500, "Dar Salam"),
(1208, 500, "Ethiolo"),
(1210, 500, "Oubadji"),
(1212, 502, "Salemata"),
(1214, 504, "Bembou"),
(1216, 504, "Medina Baffe"),
(1218, 506, "Khossanto"),
(1220, 506, "Missirah Sirimana"),
(1222, 506, "Sabodola"),
(1224, 508, "Saraya"),
(1226, 510, "Dioulacolon "),
(1228, 510, "Guiro Yero Bocar"),
(1230, 510, "Medina El Hadji"),
(1232, 510, "Tankanto Escale"),
(1234, 512, "Bagadaji"),
(1236, 512, "Coumbacara"),
(1238, 512, "Dialambere"),
(1240, 512, "Mampatim"),
(1242, 512, "Medina Cherif"),
(1244, 514, "Sare Bidji"),
(1246, 514, "Thietty"),
(1248, 516, "Dabo"),
(1250, 518, "Kolda"),
(1252, 520, "Salikegne"),
(1254, 522, "Sare Yoba Diega"),
(1256, 524, "Badion"),
(1258, 524, "Fafacourou"),
(1260, 526, "Bignarabe"),
(1262, 526, "Bourouco"),
(1264, 526, "Koulinto"),
(1266, 526, "Ndorna"),
(1268, 528, "Dinguiray"),
(1270, 528, "Kerewane"),
(1272, 528, "Niaming"),
(1274, 530, "Medina Yoro Foulah"),
(1276, 532, "Pata"),
(1278, 534, "Bonconto"),
(1280, 534, "Linkering"),
(1282, 534, "Medina Gounasse"),
(1284, 534, "Sinthiang Koundara"),
(1286, 536, "Ouassadou"),
(1288, 536, "Pakour"),
(1290, 536, "Paroumba"),
(1292, 538, "Kandia"),
(1294, 538, "Kandiaye"),
(1296, 538, "Nemataba"),
(1298, 538, "Sare Coli Salle"),
(1302, 542, "Kounkane"),
(1304, 544, "Velingara"),
(1306, 546, "Darou Marnane"),
(1308, 546, "Darou Mousti"),
(1310, 546, "Mbacke Cajor"),
(1312, 546, "Mbadiane"),
(1322, 546, "Merina"),
(1314, 546, "Ndoyene"),
(1316, 546, "Sam "),
(1320, 546, "Touba"),
(1318, 546, "Yabal"),
(1324, 548, "Bandegne Ouolof"),
(1326, 548, "Diokoul Ndiawrigne"),
(1328, 548, "Kab Gaye"),
(1330, 548, "Ndande"),
(1332, 548, "Thiep"),
(1334, 550, "Kanene Ndiob"),
(1336, 550, "Loro"),
(1338, 550, "Ngourane Ouolof"),
(1340, 550, "Sagata Gueth"),
(1342, 550, "Thiolom Fall"),
(1344, 552, "Gueoul"),
(1346, 554, "Kebemer"),
(1348, 556, "Barkedji"),
(1350, 556, "Gassane"),
(1352, 556, "Thiargny"),
(1354, 556, "Thiel"),
(1356, 558, "Dodji"),
(1358, 558, "Labgar"),
(1360, 558, "Ouarkhokh"),
(1362, 560, "Boulal"),
(1364, 560, "Dealy"),
(1366, 560, "Sagatta Djolof"),
(1368, 560, "Thiamene Passe"),
(1370, 562, "Kambe"),
(1372, 562, "Mbeuleukhe"),
(1374, 562, "Mboula"),
(1376, 562, "Tessekere Forage"),
(1378, 564, "Dahra"),
(1380, 566, "Linguere"),
(1382, 568, "Gande"),
(1384, 568, "Keur Momar Sarr"),
(1386, 568, "Nguer Malal "),
(1388, 568, "Syer"),
(1390, 570, "Koki"),
(1392, 570, "Ndiagne"),
(1394, 570, "Pete Ouarack"),
(1396, 570, "Thiamene Cayor"),
(1398, 572, "Kelle Gueye "),
(1400, 572, "Mbediene"),
(1402, 572, "Nguidile"),
(1404, 572, "Niomre"),
(1406, 574, "Leona"),
(1408, 574, "Ngueune Sarr"),
(1410, 574, "Sakal"),
(1412, 576, "Louga"),
(1414, 578, "Aoure"),
(1416, 578, "Bokiladji"),
(1418, 578, "Orkadiere"),
(1420, 580, "Ndendory"),
(1422, 580, "Wouro Sidy"),
(1424, 582, "Dembancane"),
(1426, 584, "Hamadi Hounare"),
(1428, 586, "Kanel"),
(1430, 588, "Ouaounde"),
(1432, 590, "Semme"),
(1434, 592, "Sinthiou Bamambe Banadji"),
(1436, 594, "Dabia"),
(1438, 594, "Des Agnam"),
(1440, 594, "Orefonde"),
(1442, 596, "Bokidiave"),
(1444, 596, "Nabadji Civol"),
(1446, 596, "Ogo "),
(1448, 598, "Matam"),
(1450, 600, "Ourossogui"),
(1452, 602, "Thilogne"),
(1454, 604, "Lougre Thioly"),
(1456, 604, "Oudalaye"),
(1458, 604, "Velingara Ranerou"),
(1460, 606, "Ranerou"),
(1462, 608, "Bokhol"),
(1464, 608, "Mbane"),
(1466, 610, "Diama"),
(1468, 610, "Gnith"),
(1470, 610, "Ronkh"),
(1472, 612, "Dagana"),
(1474, 614, "Gae "),
(1476, 616, "Richard Toll"),
(1478, 618, "Rosso Senegal"),
(1480, 620, "Doumga Lao"),
(1482, 620, "Madina Ndiathbe"),
(1484, 620, "Meri"),
(1486, 622, "Dodel"),
(1488, 622, "Gamadji Sare"),
(1490, 622, "Guede Village"),
(1492, 624, "Boke Dialloube"),
(1494, 624, "Mbolo Birane"),
(1496, 626, "Fanaye"),
(1498, 626, "Ndiayene Peindao"),
(1500, 628, "Aere Lao"),
(1502, 630, "Bode Lao"),
(1504, 632, "Demette"),
(1506, 634, "Galoya Toucouleur"),
(1508, 636, "Gollere"),
(1510, 638, "Guede Chantier"),
(1512, 640, "Mboumba"),
(1514, 642, "Ndioum"),
(1516, 644, "Niandane"),
(1520, 646, "Pete"),
(1522, 648, "Podor"),
(1524, 650, "Walalde"),
(1526, 652, "Fass Ngom"),
(1528, 652, "Gandon"),
(1530, 652, "Ndiebene Gandiole"),
(1532, 654, "Mpal"),
(1534, 656, "Saint Louis "),
(1536, 658, "Boghal"),
(1538, 658, "Ndiamacouta "),
(1540, 658, "Tankon"),
(1542, 660, "Bona"),
(1544, 660, "Diacounda"),
(1546, 660, "Inor"),
(1548, 660, "Kandion Mangana"),
(1550, 662, "Diambaty"),
(1552, 662, "Diaroume"),
(1554, 662, "Faoune"),
(1556, 664, "Bounkiling"),
(1558, 666, "Madina Wandifa"),
(1560, 668, "Djibanar"),
(1562, 668, "Kaour"),
(1564, 668, "Mangaroungou Santo"),
(1566, 668, "Simbandi Balante"),
(1568, 668, "Yarang Balante"),
(1570, 670, "Karantaba"),
(1572, 670, "Kolibantang "),
(1574, 672, "Baghere"),
(1576, 672, "Dioudoubou"),
(1578, 672, "Niagha"),
(1580, 672, "Simbandi Brassou"),
(1300, 674, "Diaobe Kabendou"),
(1582, 674, "Diattacounda"),
(1584, 676, "Goundomp"),
(1586, 678, "Samine"),
(1588, 680, "Tanaff"),
(1590, 682, "Diannah Ba"),
(1592, 682, "Diende"),
(1594, 682, "Koussy"),
(1596, 682, "Oudoucar"),
(1598, 682, "Sakar"),
(1600, 682, "Same Kanta Peulh"),
(1602, 684, "Bemet Bidjini"),
(1604, 684, "Djibabouya"),
(1606, 684, "Sansamba"),
(1608, 686, "Bambali"),
(1610, 686, "Djiredji"),
(1612, 688, "Dianah Malary"),
(1614, 690, "Marsassoum"),
(1616, 692, "Sedhiou"),
(1618, 694, "Bele"),
(1620, 694, "Sinthiou Fissa"),
(1622, 696, "Gathiari"),
(1624, 696, "Madina Foulbe"),
(1626, 696, "Sadatou"),
(1628, 696, "Toumboura"),
(1630, 698, "Ballou"),
(1632, 698, "Gabou"),
(1634, 698, "Mouderi"),
(1636, 700, "Bakel"),
(1638, 702, "Diawara"),
(1640, 704, "Kidira"),
(1642, 706, "Bala"),
(1644, 706, "Goumbayel"),
(1646, 706, "Koar"),
(1648, 708, "Boynguel Bamba"),
(1650, 708, "Dougue"),
(1652, 708, "Koussan"),
(1654, 708, "Sinthiou Mamadou Boubou"),
(1656, 710, "Bani Israel "),
(1658, 710, "Boutoucoufara"),
(1660, 710, "Dianke Makha"),
(1662, 710, "Komoti"),
(1664, 712, "Koulor"),
(1666, 712, "Sinthiou Bocar Aly"),
(1668, 714, "Goudiry"),
(1670, 716, "Kothiary"),
(1672, 718, "Bamba Thialene"),
(1674, 718, "Kahene"),
(1676, 718, "Mereto"),
(1678, 718, "Ndam"),
(1680, 720, "Kouthia Gaydi"),
(1682, 720, "Kouthiaba Wolof"),
(1684, 720, "Pass Koto"),
(1686, 720, "Payar"),
(1688, 722, "Koumpentoum "),
(1690, 724, "Maleme Niani"),
(1692, 726, "Koussanar"),
(1694, 726, "Sinthiou Maleme"),
(1696, 728, "Makacolibantang"),
(1698, 728, "Ndoga Babacar"),
(1700, 728, "Niani Toucouleur"),
(1702, 730, "Dialokoto"),
(1704, 730, "Missirah"),
(1706, 730, "Netteboulou "),
(1708, 732, "Tambacounda "),
(1710, 734, "Fissel"),
(1712, 734, "Ndiaganiao"),
(1714, 736, "Ngueniene"),
(1716, 736, "Sandiara"),
(1718, 736, "Sessene"),
(1720, 738, "Diass"),
(1722, 738, "Malicounda"),
(1724, 738, "Sindia"),
(1726, 740, "Joal Fadiouth"),
(1728, 742, "Mbour"),
(1730, 744, "Ngaparou"),
(1732, 746, "Nguekhokh"),
(1734, 748, "Popenguine"),
(1736, 750, "Saly Portudal"),
(1738, 752, "Somone"),
(1740, 754, "Thiadiaye"),
(1742, 756, "Diender Guedji"),
(1744, 756, "Fandene"),
(1746, 756, "Keur Moussa "),
(1748, 758, "Notto"),
(1750, 758, "Tassette"),
(1752, 760, "Ndieyene Sirakh"),
(1754, 760, "Ngoundiane"),
(1756, 760, "Thienaba"),
(1758, 760, "Touba Toul"),
(1760, 762, "Thies Nord"),
(1762, 764, "Thies Est"),
(1764, 764, "Thies Ouest "),
(1766, 766, "Kayar"),
(1768, 768, "Khombole"),
(1770, 770, "Pout"),
(1772, 772, "Darou Khoudoss"),
(1774, 772, "Meouane"),
(1776, 772, "Taiba Ndiaye"),
(1778, 774, "Koul"),
(1780, 774, "Merina Dakhar"),
(1782, 774, "Pekesse"),
(1784, 776, "Mbayene"),
(1786, 776, "Ngandiouf"),
(1788, 776, "Niakhene"),
(1790, 776, "Thilmakha"),
(1792, 778, "Cherif Lo"),
(1794, 778, "Mont Rolland"),
(1796, 778, "Notto Gouye Diama"),
(1798, 778, "Pire Goureye"),
(1800, 780, "Mboro"),
(1802, 782, "Meckhe"),
(1804, 784, "Tivaouane"),
(1806, 786, "Djinaki"),
(1808, 786, "Kafountine"),
(1810, 786, "Kataba 1"),
(1812, 788, "Djibidione"),
(1814, 788, "Oulampane"),
(1816, 788, "Sindian"),
(1818, 788, "Suel"),
(1820, 790, "Balingore"),
(1822, 790, "Diegoune"),
(1824, 790, "Kartiack"),
(1826, 790, "Mangagoulack"),
(1828, 790, "Mlomp"),
(1830, 790, "Tendouck"),
(1832, 792, "Coubalan"),
(1834, 792, "Niamone"),
(1836, 792, "Ouonck"),
(1838, 792, "Tenghori"),
(1840, 794, "Bignona"),
(1842, 796, "Diouloulou"),
(1844, 798, "Thionck Essyl"),
(1846, 800, "Diembering"),
(1848, 800, "Santhiaba Manjaque"),
(1850, 802, "Mlomp"),
(1852, 802, "Oukout"),
(1854, 804, "Oussouye"),
(1856, 806, "Adeane"),
(1858, 806, "Boutoupa Camaracound"),
(1860, 806, "Niaguis"),
(1862, 808, "Enampor"),
(1864, 808, "Niassia"),
(1866, 810, "Ziguinchor");

