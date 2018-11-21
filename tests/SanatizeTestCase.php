<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class SanatizeTestCase extends TestCase
{
    public function testStringMethods(): void
    {
        $f = new \Pollus\Sanitizer\Types\StringType('fOo bAr ', false);
        
        $this->assertEquals('foo bar ', $f->lower()->val());
        $this->assertEquals('FOO BAR ', $f->upper()->val());
        $this->assertEquals('Foo Bar ', $f->captalize()->val());
        $this->assertEquals('Foo bar ', $f->upperFirst()->val());
        $this->assertEquals('Foo bar', $f->trim()->val());
        $this->assertEquals('oo bar', $f->ltrim('F')->val());
        $this->assertEquals('oo ba', $f->rtrim('r')->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType('<b>"fOo" "bAr"<b>', false);
        $this->assertEquals('"fOo" "bAr"', $f->sanitize()->val());
        $this->assertEquals('\"fOo\" \"bAr\"', $f->escape()->val());
        $this->assertEquals('\"bar\" \"bAr\"', $f->replace("fOo", "bar")->val());
        $this->assertEquals('$\"bar\" \"bAr\"^', $f->concat("$", "^")->val());
        $this->assertEquals('^"\rAb"\ "\rab"\$', $f->reverse()->val());
        $this->assertEquals('^"', $f->substr(0, 2)->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("<br>àèìòùáéíóúãõäëïöüâêîôû</br>", false);
        $this->assertEquals("àèìòùáéíóúãõäëïöüâêîôû", $f->sanitize()->val());
        $this->assertEquals("ÀÈÌÒÙÁÉÍÓÚÃÕÄËÏÖÜÂÊÎÔÛ", $f->upper()->val());
    }
    
    
    public function testCapitalizeName()
    {
        $f = new \Pollus\Sanitizer\Types\StringType("Sant'ana Sant\"ana", false);
        $this->assertEquals("Sant'ana Sant\"ana", $f->sanitize()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("joana d'arc", false);
        $this->assertEquals("Joana d'Arc", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("JOANA D'ARC", false);
        $this->assertEquals("Joana d'Arc", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("pedro i do brasil", false);
        $this->assertEquals("Pedro I do Brasil", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("kleinhüningen", false);
        $this->assertEquals("Kleinhüningen", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("kleinhüningen", false);
        $this->assertEquals("KLEINHÜNINGEN", $f->capitalizeName()->upper()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("fjæreveien", false);
        $this->assertEquals("Fjæreveien", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("fjæreveien", false);
        $this->assertEquals("FJÆREVEIEN", $f->capitalizeName()->upper()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("Łódź", false);
        $this->assertEquals("ŁÓDŹ", $f->capitalizeName()->upper()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("noël doiron", false);
        $this->assertEquals("Noël Doiron", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("john mclaren", false);
        $this->assertEquals("John McLaren", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("allan l. bittner", false);
        $this->assertEquals("Allan L. Bittner", $f->capitalizeName()->val());
        
        $f = new \Pollus\Sanitizer\Types\StringType("ZARA BURKE-GAFFNEY", false);
        $this->assertEquals("Zara Burke-Gaffney", $f->capitalizeName()->val());
        
   
    }
    
    public function testStringException(): void
    {
        $this->expectException(Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        $f = new \Pollus\Sanitizer\Types\StringType(null, false);
    }
    
    public function testFloatMethods(): void
    {
        $f = new Pollus\Sanitizer\Types\FloatType(14.45, true);
        $this->assertEquals(14.45, $f->val());
        $this->assertEquals(14, $f->round()->val());
        
        $f = new Pollus\Sanitizer\Types\FloatType(14.45, true);
        $this->assertEquals(15, $f->ceil()->val());
        
    }
    
    public function testFloatException(): void
    {
        $this->expectException(Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        $f = new \Pollus\Sanitizer\Types\FloatType(null, false);
    }
    
    public function testIntmethods(): void
    {
        $f = new Pollus\Sanitizer\Types\FloatType(54, true);
        $this->assertEquals(54, $f->val());
    }
    
    public function testIntException(): void
    {
        $this->expectException(Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        $f = new \Pollus\Sanitizer\Types\IntType(null, false);
    }
    
    public function testBoolmethods(): void
    {
        $f = new Pollus\Sanitizer\Types\BoolType(false, true);
        $this->assertEquals(false, $f->val());
    }
    
    public function testBoolException(): void
    {
        $this->expectException(Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        $f = new \Pollus\Sanitizer\Types\BoolType(null, false);
    }
}