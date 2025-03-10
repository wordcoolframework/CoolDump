<?php

namespace Config;

use Configuration\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase{

    private string $path = '';
    protected function setUp(): void {
        $this->path = __DIR__ . '/config/app.php';

        if (!is_dir(__DIR__ . '/config')) {
            mkdir(__DIR__ . '/config', 0777, true);
        }

        file_put_contents($this->path, "<?php return ['platform' => 'cool'];");
    }

    public function testGetReturnConfigValueIfExists(){
        $value = Config::get('app.platform');

        $this->assertEquals('cool', $value);
    }

    public function testGetReturnDefaultValueIfNotExistValue(){
        $value = Config::get('app.unknown','default_value');
        $this->assertEquals('default_value', $value);
    }

    public function testSeparationFileAndKey(){
        $separation = explode('.', 'app.platform');
        $this->assertEquals(['app', 'platform'], $separation);
    }
}