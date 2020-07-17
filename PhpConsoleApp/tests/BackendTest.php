<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class BackendTest extends TestCase
{

    
    /** @test */
    public function canReadAndReturnDataFromFileJsonData() : void{

        $path = __DIR__."\..\data";
        $this->assertFileExists($path.'\data.json');
        $this->assertFileIsReadable($path.'\data.json');
    }

}
