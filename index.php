<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="src/styles/index.css">
        <title>Autovermietung</title>
    </head>
    <body>
        <header>
            <nav>
                <ul class="left-bar">
                    <img id="car-symbol" src="src/images/car_symbol.png">
                    <li><b><a href="reserve/reservation.php">Auto reservieren</a></b></li>
                    <li><b><a href="return/return_dialog.php">KFZ zurücknehmen</a></b></li>
                    <li><b><a href="invoice/invoice_list.php">Rechnungen</a></b></li>
                    <li><b><a href="#about">Über uns</a></b></li>
                    <li><b><a href="#contact">Kontakt</a></b></li>
                </ul>
                <?php
                echo '<ul class="right-bar">';

                if(isset($_SESSION['pseudo'])) {
                    echo '<li><button onclick="window.location.href=window.location.href+\'login/logout.php\'">Abmelden</button></li>
                        <b>'.$_SESSION['pseudo'].'</b>';
                }

                else {
                    echo '<li><button onclick="window.location.href=window.location.href+\'login/register.php\'">Registrieren</button<></li>
                        <li><button onclick="window.location.href=window.location.href+\'login/login.php\'">Anmelden</button></li>';
                }

                echo '<img id="user-symbol" src="src/images/user_symbol.png"></ul>';
                ?>

            </nav>
        </header>

        <main>
            <script type="text/javascript">
                window.onload = function() {
                    var pause = false;
                    var current_banner_id = 0;
                    var left_next = document.getElementById("next-button-left");
                    var right_next = document.getElementById("next-button-right");

                    left_next.addEventListener("click",function() {
                        if(!pause) {
                            current_banner_id = slide("left",current_banner_id);
                            pause = true;
                            setTimeout(function() { pause=false; }, 1000);
                        }
                    });

                    right_next.addEventListener("click",function() {
                        if(!pause) {
                            current_banner_id = slide("right",current_banner_id);
                            pause = true;
                            setTimeout(function() { pause=false; }, 1000);
                        }
                    });
                }

                function slide(direction, current_banner_id) {
                    var current_banner_elem = document.getElementById("banner-background");
                    var banner_small_description = document.getElementById("banner-small-description");
                    var banner_title = document.getElementById("banner-title");
                    var banner_button = document.getElementById("banner-button");
                    var slide_content = new Array(
                        new Array("Mieten sie ihr Traumauto","Zuverlässige Autovermietung<br>Mit hoher Qualität","Jetzt reservieren","reserve/reservation.php"),
                        new Array("Verwalten sie ihre Rechnungen","Einfache Rechnungsübersicht<br>zahlreiche Möglichkeiten","Rechnungen ansehen","invoice/invoice_list.php"),
                        new Array("Kaufen sie ihr Traumauto","Günstiger und einfacher<br>Gebrauchtwagenkauf","Gebrauchtwagen kaufen",""),
                        new Array("Nutzen sie unsere Leistungen","Zahlreiche Zusatzleistungen<br>für Kunden ","Leistungen ansehen","#leistungen"));
                    //[0] = small banner description; [1] = banner title; [2] = Banner button content; [3] = Banner Link

                    if (direction == "left") {
                        current_banner_id -= 1;

                        if(current_banner_id < 0) {
                            current_banner_id = 3;
                        }
                    }

                    else {
                        current_banner_id += 1

                        if(current_banner_id > 3) {
                            current_banner_id = 0;
                        }
                    }
                    current_banner_elem.style.backgroundImage = "url('src/images/banner-"+current_banner_id+".jpg')";
                    console.log( current_banner_elem.style.backgroundImage);
                    banner_small_description.innerHTML = slide_content[current_banner_id][0];
                    banner_title.innerHTML = slide_content[current_banner_id][1];
                    banner_button.innerHTML = slide_content[current_banner_id][2];
                    banner_button.onclick = function(){window.location.href=window.location.href+slide_content[current_banner_id][3]};

                    return current_banner_id;
                }
            </script>

            <div id="banners">
                <img id="banner-background">

                <p id="banner-small-description">Mieten sie ihr Traumauto</p>
                <p id="banner-title">Zuverlässige Autovermietung<br>Mit hoher Qualität</p>
                <br>
                <button id="banner-button" class="blue-button" onclick="window.location.href=window.location.href+'reserve/reservation.php'">Jetzt reservieren</button>
                <img id="next-button-left" src="src/images/next_button.png">
                <img id="next-button-right" src="src/images/next_button.png">
            </div>
            
        </main>

        <!-- Über das Unternehmen -->
        <article id="about">
            <h1>ÜBER UNS</h1>
            <br>
            <br>
            <div id="leistungen">
                <div class="group">
                    <h2>Autovermietung</h2>
                    <br>
                    <p class="description">Kostengünstig und einfach<br>aus einer großen Anzahl verschiedenster Autotypen
                    <br>ihren Traumwagen zuverlässig<br>und schnell reservieren und mit <br>garantierter Qualität mieten.</p>
                    <br><br>
                    <button id="leistung-button" class="blue-button" onclick="window.location='reserve/reservation.php'">Zur Autovermietung</button>
                </div>
                
                <div class="group">
                    <h2>Rechnungsverwaltung</h2>
                    <br>
                    <p class="description">Alle Rechnungen einfach<br>im Überblick behalten.
                    <br>Listenübersicht und Versand als PDF.<br>Flexibel per Direktzahlung oder per Sammelrechnungen
                    <br>die Rechnungen begleichen.</p>
                    <br><br>
                    <button id="leistung-button" class="blue-button" onclick="window.location=''">Mehr Informationen</button>
                </div>
                
                <div class="group">
                    <h2>Gebrauchtwagenkauf</h2>
                    <br>
                    <p class="description">Mehr als nur Mieten? Klar!<br>Profitieren sie von unserem Gebrauchtwagenverkauf.
                    <br>Ganz einfach aus einer großen Auswahl ihr Lieblingsauto.<br>gebraucht und günstig kaufen.</p>
                    <br><br>
                    <button id="leistung-button" class="blue-button" onclick="window.location=''">Zum Gebrauchtwarenverkauf</button>
                </div>                
            </div>



        <br><br><br>
        <hr>
        <br><br><br>

        <div id="hintergrund">
            <h1>Unternehmensgeschichte</h1>
            <br>
            <p class="description">
<br>Seit über 20 Jahren fokussieren wir uns leidenschaftlich auf die Vermietung und den Verkauf von Gebrauchtwagen.<br>
Nach langjähriger Erfahrung haben wir unser Angebot an Services erweitert und angepasst um den Kundenanforderungen gerecht zu werden.<br>
Unsere Prozesse und Angebote wurden langjährig optimiert und optimal für die Kunden gestaltet.<br>
Kundenrezensionen sorgen kontinuierlich für die Verbesserung unserer Leistungen und für die Erweiterung unseres Angebots an Wagen zur
Vermietung und für den Verkauf.<br>
            </p>
        </div>
        </article>
        


        <!-- Kontaktinformationen -->
        <article id="contact">
            <b><h2>Navigation</h2><br><a href="#">Home</a><br><a href="#leistungen">Über uns</a></b>
            <b><h2>Kontakt</h2><br><a href="tel:+4912345678">Telefon: +49 1234 5678</a><br><a href="mailto:contact@rentalcar.com">E-Mail: contact@rentalcar.com</a><br>Web: www.rentalcar.com</b>
            <b><h2>Adresse</h2><br>Rentalcar<br>GmbHStraße 1<br>12345 Ort<br></b>
        </article>

        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>
