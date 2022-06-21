<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require("functions/functions.php");

class functionTest extends TestCase
{
    public function test_this_checkIfIdProtocoleExist_mit_Schon_Existierendem_Ruecknahmeprotkoll():void
    {
        $_SESSION['mitarbeiterID'] = 1;
        $_SESSION['mietvertragid'] = 1;
        $this->assertTrue(checkIfIdProtocoleExist());
    }
    public function test_this_checkIfIdProtocoleExist_mit_Nicht_Existierendem_Ruecknahmeprotkoll():void
    {
        $_SESSION['mitarbeiterID'] = 1;
        $_SESSION['mietvertragid'] = 1213443242434;
        $this->assertFalse(checkIfIdProtocoleExist());
    }
    public function test_this_mietVertragsanzeige():void
    {
            $array = array("mietvertragid" => 1);
            $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
            mietVertragsanzeige($array,$con); 
            $this->assertTrue($_SESSION['kundenid']==487);
            $this->assertTrue($_SESSION['vertragid']==1);

    }
    public function test_this_sendeRuecknahmeprotokoll():void
    {
        try
        {
            $nutzungsdaten = array("tank" => 1,"kilometerstand" => 100,"sauberkeit"=>"sehr sauber","mechanik"=>"Teststring");
            $mietvertragid = rand(201,500);
            $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
            sendeRuecknahmeprotokoll($nutzungsdaten,$con,$mietvertragid); 
            $statement = "SELECT * FROM ruecknahmeprotokolle WHERE mietvertragID = ".  $mietvertragid; 
            $ergebnis = $con->query($statement);
            while($tupel = mysqli_fetch_assoc($ergebnis)){
                $tank = $tupel["tank"];
                $kilometerstand = $tupel["kilometerstand"];
                $sauberkeit = $tupel["sauberkeit"];
                $mechanik = $tupel["mechanik"];
            }
            $this->assertTrue($tank==1);
            $this->assertTrue($kilometerstand==100);
            $this->assertTrue($sauberkeit=="sehr sauber");
            $this->assertTrue($mechanik=="Teststring");
        }
        catch(mysqli_sql_exception $error)
        {
            $this->fail("Fehlschlag");
        }
    }
        public function test_this_sendeRuecknahmeprotokoll_Ungueltig():void
    {
        try
        {
            $nutzungsdaten = array("tank" => 1,"kilometerstand" => 100,"sauberkeit"=>"sehr sauber","mechanik"=>"Teststring");
            $mietvertragid = 100;
            $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
            sendeRuecknahmeprotokoll($nutzungsdaten,$con,$mietvertragid); 
            $this->fail("Fehlschlag");
        }
        catch(mysqli_sql_exception $error)
        {
            $this->assertStringStartsWith('Cannot add or update a child row: a foreign key constraint fails (`autovermietung`.`ruecknahmeprotokolle`, CONSTRAINT `ruecknahmeprotokolle_mietvertragID` FOREIGN KEY (`mietvertragID`) REFERENCES `mietvertraege` (`mietvertragID`))',$error->getMessage());
        }
    }
}
?>