<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require("../../htdocs/rentalCar/functions/functions.php");

class return_dialogTest extends TestCase
{
    public function test_this_checkIfIdProtocoleExist():void
    {
        $_SESSION['mietvertragid'] = 1;
        $this->assertTrue(checkIfIdProtocoleExist());
    }
}
?>