<!DOCTYPE html>
<html>
    <head> 
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/register.css">
        <title>Registrierung</title>
    </head>
    <body>
        <main>
            <h1>Registrierung</h1>
            <center>
                <div class="frame">
                    <form action="" method="POST">
                        <div class="group">
                            <label for="vorname">*Vorname</label>
                            <input type="text" name="vorname" placeholder="Vorname" required>
                            <label for="nachname">*Nachname</label>
                            <input type="text" name="nachname" placeholder="Nachname" required>

                            <label for="strasse">*Straße</label>
                            <input type="text" name="strasse" placeholder="Straße" required>

                            <label for="hausnr">*Haus-Nr</label>
                            <input type="number" name="hausnr" placeholder="Haus Nr." required>

                            <label for="plz">*PLZ</label>
                            <input type="number" name="plz" placeholder="Postleitzahl" required>


                        </div>
                       
                        <div class="group">
                            <label for="iban">*IBAN</label>
                            <input type="text" name="iban" placeholder="IBAN" required>

                            <label for="bic">*BIC</label>
                            <input type="text" name="bic" placeholder="BIC" required>
  
                            <label for="telefonnr">*Telefonnummer</label>
                            <input type="text" name="telefonnr" placeholder="Telefonnummer" required>

                            <label for="email">*E-Mail</label>
                            <input type="text" name="email" placeholder="E-Mail" required>

                            <label for="land">*Land</label>
                            <input type="text" name="land" placeholder="Land" required>
                        </div>

                        <br>
                        <button type="submit">Registrieren</button>
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>