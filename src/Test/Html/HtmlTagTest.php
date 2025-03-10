<?php

use PHPUnit\Framework\TestCase;

class HtmlTagTest extends TestCase {
    use \CoolDump\Html\HtmlTag;

    public function testStartUl() {
        $this->assertEquals("<ul style='list-style-type: none; margin-left: 20px; padding: 0;'>", $this->startUl());
    }

    public function testEndUl() {
        $this->assertEquals("</ul>", $this->endUl());
    }

    public function testStartLi() {
        $this->assertEquals("<li>", $this->startLi());
    }

    public function testEndLi() {
        $this->assertEquals("</li>", $this->endLi());
    }

    public function testSummary() {
        $key = "testKey";
        $expected = "<summary> <span style='font-size: 10px;color: chartreuse;'>(array)</span> <span style='color: #fff'>[testKey]</span> </summary>";
        $this->assertEquals($expected, $this->summary($key));
    }

    public function testValueHtml() {
        $this->assertEquals("<span style='font-size: 10px; color: chartreuse;'>(string)</span> <span style='color: #fff'>Hello</span>", $this->valueHtml("string", "Hello"));
    }

    public function testInvalidDataHtml() {
        $this->assertEquals("<span style='color: #f00;'>Invalid data type!</span>", $this->invalidDataHtml());
    }

    public function testDebuggingAt() {
        $this->assertStringContainsString("Debugging at", $this->debuggingAt("file.php", 10));
    }

    public function testExecutionTime() {
        $this->assertStringContainsString("Execution Time", $this->executionTime(123.45));
    }
}