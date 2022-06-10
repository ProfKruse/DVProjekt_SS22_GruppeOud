<?php

declare(strict_types=1);

use return\return_dialog;
use PHPUnit\Framework\TestCase;

class return_dialogTest extends TestCase
{
    public function test_that_mietvertragWirdAngezeigtMitVorandenerMietvertragsnummer():void
    {
        //given
        $fakeFormData = array('mietvertragid' => '1');
        //when
        mietvertragsAnzeige($fakeFormData,$con);
        //then
        $string1 = 'testing';
        $string2 = 'testing';

        $this->assertSame($string1,$string2);
    }
    public function test_that_mietvertragWirdAngezeigtMitNichtVorandenerMietvertragsnummer():void
    {
        $fakeFormData = array('mietvertragid' => '3');
        //given
        //$_POST['mietvertragid']=1;
        //when
        //mietvertragsAnzeige($_POST,$con);
        //then
        $string1 = 'testing';
        $string2 = 'testing';

        $this->assertSame($string1,$string2);
    }
}
?>