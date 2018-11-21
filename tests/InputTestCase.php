<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class InputTestCase extends TestCase
{
    public function testGetInputNonStrict(): void
    {
        // user input
        $_GET["name"] = "john doe mcfly i";
        $_GET["age"] = "41";
        $_GET["size"] = "150.5 cm";
        $_GET["money"] = "";
        $_GET["obs"] = null;
        
        
        // controller
        $f = new \Pollus\Sanitizer\Input();
        
        $name = $f->get('name')->toString()->sanitize()->capitalizeName()->val();
        $age = $f->get('age')->toInt()->val();
        $size = $f->get('size')->toFloat(".")->val();
        $money = $f->get('money')->toFloat(".")->val();
        $obs = $f->get('obs')->nullable()->toString()->sanitize()->val();
        $zero = $f->get('this-shouldnt-exists')->toInt()->val();
        
        // sanitized data
        $this->assertSame('John Doe McFly I', $name);
        $this->assertSame(41, $age);
        $this->assertSame(150.5, $size);
        $this->assertSame(0.0, $money);
        $this->assertSame(null, $obs);
        $this->assertSame(0, $zero);
    }
    
    public function testGetInputStrict(): void
    {
        $this->expectException(\Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        
        // user input
        $_GET["name"] = "john doe mcfly i";

        // controller
        $f = new \Pollus\Sanitizer\Input();
        $f->setStrictMode(true);
        
        $name = $f->get('name')->toString()->sanitize()->capitalizeName()->val();
        $zero = $f->get('this-shouldnt-exists')->toInt()->val();
    }
    
    public function testPostInputNonStrict(): void
    {
        // user input
        $_POST["names"] = "john doe mcfly i";
        $_POST["age"] = "41";
        $_POST["size"] = "150.5 cm";
        $_POST["money"] = "";
        $_POST["obs"] = null;

        // controller
        $f = new \Pollus\Sanitizer\Input();
        
        $name = $f->post('names')->toString()->sanitize()->capitalizeName()->val();
        $age = $f->post('age')->toInt()->val();
        $size = $f->post('size')->toFloat(".")->val();
        $money = $f->post('money')->toFloat(".")->val();
        $obs = $f->post('obs')->nullable()->toString()->sanitize()->val();
        $zero = $f->post('this-shouldnt-exists')->toInt()->val();
        
        // sanitized data
        $this->assertSame('John Doe McFly I', $name);
        $this->assertSame(41, $age);
        $this->assertSame(150.5, $size);
        $this->assertSame(0.0, $money);
        $this->assertSame(null, $obs);
        $this->assertSame(0, $zero);
    }
    
    public function testPostInputStrict(): void
    {
        $this->expectException(\Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        
        // user input
        $_POST["name"] = "john doe mcfly i";

        // controller
        $f = new \Pollus\Sanitizer\Input();
        $f->setStrictMode(true);
        
        $name = $f->post('name')->toString()->sanitize()->capitalizeName()->val();
        $zero = $f->post('this-shouldnt-exists')->toInt()->val();
    }
    
    public function testServerInputNonStrict(): void
    {
        // user input
        $_SERVER["my-sv-name"] = "<b>pollus web server</b>";
        

        // controller
        $f = new \Pollus\Sanitizer\Input();
        
        $name = $f->server('my-sv-name')->toString()->sanitize()->capitalizeName()->val();
        $zero = $f->server('this-shouldnt-exists')->toInt()->val();
        
        // sanitized data
        $this->assertSame('Pollus Web Server', $name);
        $this->assertSame(0, $zero);
    }
    
    public function testServerInputStrict(): void
    {
        $this->expectException(\Pollus\Sanitizer\Exceptions\InvalidInputException::class);
        
        $_SERVER["my-sv-name"] = "<b>pollus web server</b>";
        
        $f = new \Pollus\Sanitizer\Input();
        $f->setStrictMode(true);
        
        $name = $f->server('name')->toString()->sanitize()->capitalizeName()->val();
        $zero = $f->server('this-shouldnt-exists')->toInt()->val();
    }
    
    
    public function testVarInputNonStrict(): void
    {
        // user input
        $var_hello = "World";
        
        // controller
        $f = new \Pollus\Sanitizer\Input();
        
        $name = $f->var($var_hello)->toString()->val();
        // sanitized data
        $this->assertSame('World', $name);
        
    }


    
    
    
}