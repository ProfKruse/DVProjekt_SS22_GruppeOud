<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require("functions/functions.php");

class functionTest extends TestCase
{
    public function test_this_checkIfIdProtocoleExist():void
    {
        $_SESSION['mietvertragid'] = 1;
        $this->assertTrue(checkIfIdProtocoleExist());
    }
    public function test_this_mietVertragsanzeige():void
    {
            $array = array("mietvertragid" => 1);
            $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
            mietVertragsanzeige($array,$con); 
            $this->assertTrue($_SESSION['kundenid']==1);
            $this->assertTrue($_SESSION['vertragid']==1);

    }
    public function test_this_sendeRuecknahmeprotokoll_mit_ungueltiger_ID():void
    {
        try
        {
            $nutzungsdaten = array("tank" => 1,"kilometerstand" => 100,"sauberkeit"=>"sehr sauber","mechanik"=>"Teststing");
            $mietvertragid = 12323453241234;
            $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
            sendeRuecknahmeprotokoll($nutzungsdaten,$con,$mietvertragid); 
            $this->fail("Ein Fehler haette geworfen werden muessen");
        }
        catch(mysqli_sql_exception $error)
        {
            $this->assertStringStartsWith('Cannot add or update a child row: a foreign key constraint fails (`autovermietung`.`ruecknahmeprotokolle`, CONSTRAINT `ruecknahmeprotokolle_mietvertragID` FOREIGN KEY (`mietvertragID`) REFERENCES `mietvertraege` (`mietvertragID`))',$error->getMessage());
        }
    }
    public function test_this_sendeRuecknahmeprotokoll_mit_gueltiger_ID():void
    {
        try{
            $nutzungsdaten = array("tank" => 1,"kilometerstand" => 100,"sauberkeit"=>"sehr sauber","mechanik"=>"Teststing");
            $mietvertragid = 1;
            $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
            sendeRuecknahmeprotokoll($nutzungsdaten,$con,$mietvertragid);
            $statement = "SELECT * FROM ruecknahmeprotokolle WHERE mietvertragID = 1"; 
            $ergebnis = $con->query($statement);
            while($tupel = mysqli_fetch_assoc($ergebnis)){
                $tank = $tupel["tank"];
                $kilometerstand = $tupel["kilometerstand"];
                $sauberkeit = $tupel["sauberkeit"];
                $mechanik = $tupel["mechanik"];
            }
            $this->assertTrue($tank==12);
            $this->assertTrue($kilometerstand==234);
            $this->assertTrue($sauberkeit=="sehr sauber");
            $this->assertTrue($mechanik=="345");
        }
        catch(Error $error)
        {
            $this->fail("Dies haette nicht fehlschlagen sollen");
        }

    }
}
?>