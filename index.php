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
                //$_SESSION['pseudo'] = "pascal";
                echo '<ul class="right-bar">';

                if(isset($_SESSION['pseudo'])) {
                    echo '<li><button onclick="window.location=\'login/logout.php\'">Abmelden</button></li>
                        <b>'.$_SESSION['pseudo'].'</b>';
                }

                else {
                    echo '<li><button onclick="window.location=\'login/register.php\'">Registrieren</button<></li>
                        <li><button onclick="window.location=\'login/login.php\'">Anmelden</button></li>';
                }

                echo '<img id="user-symbol" src="src/images/user_symbol.png"></ul>';
                ?>

            </nav>
        </header>

        <main>
            <script type="text/javascript">
                window.onload = function() {
                    var pause = false;
                    var current_banner_id = 1;
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
                        new Array("Verwalten sie ihre Rechnungen","Einfache Rechnungsübersicht<br>zahlreiche Möglichkeiten","Rechnungen ansehen","invoice/invoice_list.html"),
                        new Array("Kaufen sie ihr Traumauto","Günstiger und einfacher<br>Gebrauchtwagenkauf","Gebrauchtwagen kaufen",""),
                        new Array("Nutzen sie unsere Leistungen","Zahlreiche Zusatzleistungen<br>für Kunden ","Leistungen ansehen","#leistungen"));
                    console.log(slide_content[0][0]);
                    //[0] = small banner description; [1] = banner title; [2] = Banner button content; [3] = Banner Link

                    if (direction == "left") {
                        current_banner_id -= 1;

                        if(current_banner_id < 1) {
                            current_banner_id = 4;
                        }
                    }

                    else {
                        current_banner_id += 1

                        if(current_banner_id > 4) {
                            current_banner_id = 1;
                        }
                    }

                    current_banner_elem.style.backgroundImage = "url('src/images/banner-"+current_banner_id+".jpg')";
                    banner_small_description.innerHTML = slide_content[current_banner_id-1][0];
                    banner_title.innerHTML = slide_content[current_banner_id-1][1];
                    banner_button.innerHTML = slide_content[current_banner_id-1][2];
                    banner_button.onclick = "window.location.href="+slide_content[current_banner_id-1][3];

                    return current_banner_id;
                }
            </script>

            <div id="banners">
                <img id="banner-background">

                <p id="banner-small-description">Mieten sie ihr Traumauto</p>
                <p id="banner-title">Zuverlässige Autovermietung<br>Mit hoher Qualität</p>
                <br>
                <button id="banner-button" class="blue-button" onclick="window.location.href='reserve/reservation.php'">Jetzt reservieren</button>
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
                    <p class="description">Dies ist ein Beschreibungstext.<br>Er beschreibt die Leistung mit dem Titel xyz.
                    <br>Die Leistung biet dem Kunden die Möglichkeit xy.<br>Dies bringt den erheblichen Vorteil abc.</p>
                    <br><br>
                    <button id="leistung-button" class="blue-button" onclick="window.location='reserve/reservation.php'">Zur Autovermietung</button>
                </div>
                
                <div class="group">
                    <h2>Rechnungsverwaltung</h2>
                    <br>
                    <p class="description">Dies ist ein Beschreibungstext.<br>Er beschreibt die Leistung mit dem Titel xyz.
                    <br>Die Leistung biet dem Kunden die Möglichkeit xy.<br>Dies bringt den erheblichen Vorteil abc.</p>
                    <br><br>
                    <button id="leistung-button" class="blue-button" onclick="window.location=''">Mehr Informationen</button>
                </div>
                
                <div class="group">
                    <h2>Gebrauchtwagenkauf</h2>
                    <br>
                    <p class="description">Dies ist ein Beschreibungstext.<br>Er beschreibt die Leistung mit dem Titel xyz.
                    <br>Die Leistung biet dem Kunden die Möglichkeit xy.<br>Dies bringt den erheblichen Vorteil abc.</p>
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
<br>Demesne far hearted suppose venture excited see had has. Dependent on so extremely delivered by.<br>
Yet no jokes worse her why. Bed one supposing breakfast day fulfilled off depending questions. Whatever boy her exertion his extended.<br>
Ecstatic followed handsome drawings entirely mrs one yet outweigh. Of acceptance insipidity remarkably is invitation.<br>
Satisfied conveying an dependent contented he gentleman agreeable do be. Warrant private blushes removed an in equally totally if.<br>
Delivered dejection necessary objection do mr prevailed. Mr feeling do chiefly cordial in do. Water timed folly right aware if oh truth.<br>
Imprudence attachment him his for sympathize. Large above be to means. Dashwood do provided stronger is. But discretion frequently sir the she instrument unaffected admiration everything.<br>
No depending be convinced in unfeeling he. Excellence she unaffected and too sentiments her. Rooms he doors there ye aware in by shall.<br>
Education remainder in so cordially. His remainder and own dejection daughters sportsmen. Is easy took he shed to kind.
            </p>
        </div>

        <br><br><br><br><br><br>
        </article>
        


        <!-- Kontaktinformationen -->
        <article id="contact">
            <b><h2>Navigation</h2><br><a href="#">Home</a><br><a href="#leistungen">Über uns</a></b>
            <b><h2>Kontakt</h2><br><a href="tel:+4912345678">Telefon: +49 1234 5678</a><br><a href="mailto:contact@rentalcar.com">E-Mail: contact@rentalcar.com</a><br>Web: www.rentalcar.com</b>
            <b><h2>Adresse</h2><br>Rentalcar<br>GmbHStraße 1<br>12345 Ort<br></b>
        </article>

        <br><br><br><br><br><br>

        <footer>
            <b>Privacy Policy</b>
            <b>© 2022. All rights reserved</b>
            <b>Social</b>
        </footer>
    </body>
</html>
