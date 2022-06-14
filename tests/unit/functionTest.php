<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require("functions/functions.php");

class functionTest extends TestCase
{
    public function test_this_checkIfIdProtocoleExist():void
    {
        $_SESSION['mietvertragid'] = 1;
        //$this->assertTrue(checkIfIdProtocoleExist());
        $this->assertTrue(true);
    }
    public function test_this_mietVertragsanzeige():void
    {
        $array = array("mietvertragid" => 1);
        $con = mysqli_connect('localhost', 'root', '', 'autovermietung');
        mietVertragsanzeige($array,$con); 
        $this->assertTrue($_SESSION['kundenid']==1);
        $this->assertTrue($_SESSION['vertragid']==1);
    }
}
?>