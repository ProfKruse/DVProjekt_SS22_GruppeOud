![Github commits](https://img.shields.io/github/commit-activity/w/som-ould/rentalCar) <br>
Gamma Autovermietung
====================

 * [Einleitung](#einleitung)
 * [Installation](#installation)
 * [Dokumentation](#dokumentation)
 
### Einleitung

Dieses Repository befasst sich mit der Entwicklung eines Teil der Webseite Autovermietung. Das Team Gamma liefert folgede features des Mietvorgangs Durchführung:

- Anmeld- und Regestrierung System
- Auto reservieren
- Rückgabe Auto
- Rechnung erstellen
- Mahnwesen


### Installation

1. Installieren Sie [XAMPP](https://www.apachefriends.org/de/index.html) PHP 7.4.29.
2. Starten Sie PhpMyAdmin and Apache Server
3. Erstellen Sie eine Datenbank name: "autovermietung"
4. Führen Sie den [SQL-Script]([https://github.com/som-ould/rentalCar/blob/feature/database/Database/autovermietung.sql](https://github.com/som-ould/rentalCar/blob/main/Database/autovermietung_mit_testdaten.sql)) durch
5. Passen Sie [DB-Config](https://github.com/som-ould/rentalCar/blob/feature/database/Database/db_inc.php) an, nur falls Sie die Default Parameter der Datanbank geändert haben
6. Rufen sie mit dem Betriebssystem Windows die Aufgabenplanung (ggf. unter dem Namen "taskschd") auf
7. Klicken sie in der rechts befindlichen Leiste unter "Aktionen" auf die Option "Aufgabe importieren" und importeren sie nacheinander die Dateien
[Sammelrechnungen_Versand.xml](https://github.com/som-ould/rentalCar/trigger/Sammelrechnungen_Versand.xml) und [Mahnungen_Versand.xml](https://github.com/som-ould/rentalCar/trigger/Mahnungen_Versand.xml) und klicken sie auf "OK"
8. Rufen Sie Local/rentalCar/index.html 

### Dokumentation

#### Auftrag
- [Lastenheft](https://github.com/som-ould/rentalCar/blob/develop/Projektauftrag/20220403_Lastenheft_DVProjektWinfo_SS2022_Autovermietung.pdf)
- [Projektauftrag](https://github.com/som-ould/rentalCar/wiki/Projektauftrag)

#### Protokole
- [Logbuch](https://docs.google.com/document/d/1gyoO3umH7sQYfjQJlo43idK8eAwMnH-QW_iQgBw24R0/edit#)
- [Leistungserfassung](https://docs.google.com/spreadsheets/d/1pIhPirbzJjo5-i-Uyj6I9yZHlmOF9URTQR_yK-8TZAc/edit#gid=0)
- [Projektplanung](https://docs.google.com/spreadsheets/d/1pIhPirbzJjo5-i-Uyj6I9yZHlmOF9URTQR_yK-8TZAc/edit#gid=1287143819)
- [Risikomanagement](https://docs.google.com/spreadsheets/d/1pIhPirbzJjo5-i-Uyj6I9yZHlmOF9URTQR_yK-8TZAc/edit#gid=2017540598)
- [Sprint](https://github.com/som-ould/rentalCar/wiki/Projektplan---Sprints)
- [Kanbanboard](https://trello.com/b/hfhRnngV/mietvorgang-durchf%C3%BChren-und-abrechnen)
- [Präsentation](https://docs.google.com/presentation/d/1iW4qCfWezLK3xSINQNOWRDD_FVTMBnKBksKLLdLec3g/edit#slide=id.g12f74f780d8_0_646)

#### Design

- [BPMN](https://github.com/som-ould/rentalCar/wiki/BPMN)
- [Sequenz- und Anwendungsfalldiagramme](https://github.com/som-ould/rentalCar/wiki/UML)
- [Mockup](https://claritee.io/public-view/nDkaooP70sWy2DDGCRoJow%253d%253d/tree)

#### Webanwendung
- [Autovermietung](http://localhost/rentalCar/index.php)

Kontakt:
=========

- Anne Lötter 
<br>Backend Entwicklerin
<br>Anne.loettert@studmail.w-hs.de

- Bastian Oymanns 
<br>Backend Entwickler
<br>Bastian.oymanns@studmail.w-hs.de

- Julian Eckerskorn 
<br>Backend Entwickler
<br>Julian.Eckerskorn@studmail.w-hs.de

- Pascal Ewald 
<br>Front- und Backend Entwickler, Datenbank Beauftragter
<br>pascal.ewald@studmail.w-hs.de

- Sihem Ould Mohand 
<br>Projektleiterin, Backend Entwicklerin und Scrum Master
<br>sihem.mohand@studmail.w-hs.de

- Tim Middeke 
<br>Backend Entwickler
<br>Tim.middeke@studmail.w-hs.de

- Christian Kruse 
<br>Produkt Owner
<br>Christian.Kruse@w-hs.de
