CREATE DATABASE verkkolomake;
use verkkolomake;

CREATE TABLE `lahetykset` (
  `id` int(10) UNSIGNED NOT NULL,
  `yrityksen_nimi` varchar(50) NOT NULL,
  `ytunnus` char(9) NOT NULL,
  `lah_katuosoite` varchar(50) NOT NULL,
  `lah_postinro` char(5) NOT NULL,
  `lah_postitmp` varchar(50) NOT NULL,
  `sposti` varchar(70) NOT NULL,
  `tilinumero` varchar(50) NOT NULL,
  `lahetystunnus` varchar(50) NOT NULL,
  `summa` decimal(7,2) NOT NULL,
  `tuotteet` varchar(500) NOT NULL,
  `vas_nimi` varchar(50) NOT NULL,
  `vas_katuosoite` varchar(50) NOT NULL,
  `vas_postinro` char(5) NOT NULL,
  `vas_postitmp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;