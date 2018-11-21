<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CastTestCase extends TestCase
{
    public function testStringCasting(): void
    {
        $f = new Pollus\Sanitizer\TypeCast("foo bar");
        $this->assertSame('foo bar', $f->toString()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(32.5);
        $this->assertSame('32.5', $f->toString()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(false);
        $this->assertSame('', $f->toString()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame('', $f->toString()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame(null, $f->nullable()->toString()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(0);
        $this->assertSame('0', $f->nullable()->toString()->val());
    }
    
    public function testFloatCasting() : void
    {
        $f = new Pollus\Sanitizer\TypeCast("R$ 3.290,93");
        $this->assertSame(3290.93, $f->toFloat(',')->val());
        
        $f = new Pollus\Sanitizer\TypeCast("$3,290.93");
        $this->assertSame(3290.93, $f->toFloat('.')->val());
        
        $f = new Pollus\Sanitizer\TypeCast("$329093");
        $this->assertSame(329093.00, $f->toFloat()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(3290.93);
        $this->assertSame(3290.93, $f->toFloat()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame(0.0, $f->toFloat()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame(null, $f->nullable()->toFloat()->val());
    }
    
    public function testIntCasting() : void
    {
        $f = new Pollus\Sanitizer\TypeCast("59,8");
        $this->assertSame(59, $f->toInt()->val());
        
        // invalid int
        $f = new Pollus\Sanitizer\TypeCast("R$59");
        $this->assertSame(0, $f->toInt('.')->val());
        
        // valid int, php logic
        $f = new Pollus\Sanitizer\TypeCast("59$");
        $this->assertSame(59, $f->toInt('.')->val());
        
        $f = new Pollus\Sanitizer\TypeCast("0");
        $this->assertSame(0, $f->toInt('.')->val());

        $f = new Pollus\Sanitizer\TypeCast(1);
        $this->assertSame(1, $f->toInt('.')->val());
        
        $f = new Pollus\Sanitizer\TypeCast(1.0);
        $this->assertSame(1, $f->toInt('.')->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame(null, $f->nullable()->toInt('.')->val());
    }
    
    public function testBoolCasting() : void
    {
        $f = new Pollus\Sanitizer\TypeCast("false");
        $this->assertSame(false, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast("true");
        $this->assertSame(true, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(0);
        $this->assertSame(false, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(1);
        $this->assertSame(true, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(false);
        $this->assertSame(false, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(true);
        $this->assertSame(true, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame(false, $f->toBool()->val());
        
        $f = new Pollus\Sanitizer\TypeCast(null);
        $this->assertSame(null, $f->nullable()->toBool()->val());
        
    }
    
    
    
    
}