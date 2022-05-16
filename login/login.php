<!DOCTYPE html>
<html>
    <head> 
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../src/styles/login.css">
        <title>Anmeldung</title>
    </head>
    <body>
        <main>
            <h1>Anmelden</h1>
            <center>
                <div class="frame">
                    <form action="" method="POST">
                        <label for="nutzerid">*Nutzer-ID</label>
                        <input type="text" name="nutzerid" placeholder="User-ID">

                        <label for="nutzerpassw">*Passwort</label>
                        <input type="password" name="nutzerpassw" placeholder="Passwort">
                        <button type="submit">Anmelden</button>
                        <b id="fehlermeldung">Falsche Benutzer ID oder falsches Passwort!!</b>
                    </form>
                </div>
            </center>
        </main>
    </body>
</html>