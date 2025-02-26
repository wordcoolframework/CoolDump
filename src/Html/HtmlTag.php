<?php

namespace CoolDump\Html;
trait HtmlTag {

    public function startHtml(bool $verbose){
        if (!$this->verbose) {
            echo '<style>details{background: #f7f7f7; border-radius: 5px;} summary{color: #333; cursor: pointer;} </style>';
        }
    }

    public function endHtml(){
        echo '
            <link rel="stylesheet" href="../src/assets/app.css" >
            </body></html>
        ';
    }
    public function startUl() : string {
        return "<ul style='list-style-type: none; margin-left: 20px; padding: 0;'>";
    }

    public function endUl() : string {
        return "</ul>";
    }

    public function startLi() : string {
        return "<li>";
    }

    public function endLi() : string {
        return "</li>";
    }

    public function startDetails() : string {
        return "<details>";
    }

    public function endDetails() : string {
        return "</details>";
    }

    public function summary($key) : string {
        return "<summary> <span style='font-size: 10px;color: chartreuse;'>(array)</span> <span style='color: #fff'>[$key]</span> </summary>";
    }

    public function valueHtml($type, $value) : string {
        return "<span style='font-size: 10px; color: chartreuse;'>($type)</span> <span style='color: #fff'>$value</span>";
    }

    public function invalidDataHtml() : string {
        return "<span style='color: #f00;'>Invalid data type!</span>";
    }

    public function debuggingAt(string $file, int|string $line) : string {
        return "<br><span style='font-size: 13px'>🕵️ Debugging at <strong>{$file}:{$line}</strong></span>";
    }

    public function executionTime(float $executionTime) : string {
        return "<br><span style='font-size: 13px'>⏳ Execution Time: <strong>{$executionTime} ms</strong></span>";
    }

    public function getFunQuoteString(string $getFunQuote) : string {
       return "<br><span style='font-size: 11px'>$getFunQuote</span>";
    }

    public function memoryUsage(string $memoryUsage) : string {
       return "<br><span style='font-size: 11px'>🧠 memory: $memoryUsage</span>";
    }
}