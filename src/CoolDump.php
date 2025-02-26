<?php

namespace CoolDump;

use CoolDump\Contract\ICoolDump;
use CoolDump\Html\HtmlTag;

final class CoolDump implements ICoolDump {

    use HtmlTag;
    public function __construct(public bool $verbose = false) {}

    public function wc(...$data) {
        $data = count($data) === 1 && is_array($data[0]) ? $data[0] : $data;

        if ($this->isWeb()) {
            $this->renderHtml($data, 5);
        } else {
            $this->renderCli($data, 5);
        }
        exit;
    }

    public function wcJson(...$data) {
        $data = count($data) === 1 && is_array($data[0]) ? $data[0] : $data;
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    private function renderHtml($data, $level): void {
        $this->startHtml($this->verbose);
        echo '<details open style="font-size: 13px;">';
        echo '<summary style="padding: 10px; color: #4e626c">📦 Output</summary>';
        echo $this->renderArrayHtml($data, $level, 0);
        echo '</details>';
        echo $this->renderDebugInfo();
        $this->endHtml();
    }

    private function renderCli($data, $level) : void{
        echo $this->renderArrayCli($data, $level, 0);
        echo $this->renderDebugInfo();
    }

    private function renderArrayHtml($data, $level, $currentLevel) : string{
        if (is_array($data) || is_object($data)) {
            $html = $this->startUl();

            foreach ($data as $key => $value) {
                $html .= $this->startLi();

                if (is_array($value) || is_object($value)) {
                    $html .= $this->startDetails();
                    $html .= $this->summary($key);
                    $html .= $this->renderArrayHtml($value, $level, $currentLevel + 1);
                    $html .= $this->endDetails();
                } else {
                    $type = $this->getType($value);
                    $html .= $this->valueHtml($type, $value);
                }

                $html .= $this->endLi();
            }

            $html .= $this->endUl();
            return $html;
        } else {
            return $this->invalidDataHtml();
        }
    }

    private function getType($value) : int|string|array|null|float|bool|object{
        return !empty($value) ? gettype($value) : null;
    }

    private function renderArrayCli($data, $level, $currentLevel){
        $output = '';

        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                $indent = str_repeat("  ", $currentLevel);
                $output .= "$indent 🔹 [$key] => ";

                if (is_array($value) || is_object($value)) {
                    $output .= "📦 Array (" . count((array)$value) . ")\n";
                    $output .= $this->renderArrayCli($value, $level, $currentLevel + 1);
                } else {
                    $type = $this->getType($value);
                    $output .= "($type) $value\n";
                }
            }
        } else {
            $output .= "Invalid data type!\n";
        }

        return $output;
    }

    private function isWeb() : ? bool{
        return !(php_sapi_name() === 'cli');
    }

    private function getCodeSnippet($file, $line, $padding = 5) : string{
        if (!file_exists($file)) {
            return "<pre style='color: red;'>[Error] File not found: $file</pre>";
        }

        $lines = file($file);
        $totalLines = count($lines);

        $start = max(0, $line - $padding - 3);
        $end = min($totalLines, $line + $padding);
        $html = '<details style="font-size: 13px; margin-top: 10px"><summary style="padding: 10px; color: #4e626c">📦 Codesnippet</summary>';
        $html .= "<pre style='background: #282c34; color: #ffffff; padding: 10px; border-radius: 5px;'>";
        foreach (range($start, $end - 1) as $i) {
            $currentLine = $i + 1;
            $lineContent = htmlspecialchars($lines[$i]);

            if ($currentLine == $line) {
                $html .= "<span style='background: #dc7070; padding: 3px; border-radius: 3px; color: white;'>$currentLine: $lineContent</span>\n";
            } else {
                $html .= "<span style='color: #f15b5b;'>$currentLine: </span>$lineContent\n";
            }
        }
        $html .= '</pre>';
        $html .= '</details>';

        return $html;
    }

    private static function getFunQuote() : string{
        $quotes = [
            "💡 Debugging: Removing bugs and adding new ones 😆",
            "🔥 Great debugging makes great software!",
            "👀 If you see this, you're probably fixing a bug!",
            "🚀 Code smarter, not harder!",
            "🐞 Every bug is a feature waiting to be understood!"
        ];
        return $quotes[array_rand($quotes)];
    }

    private function renderDebugInfo(){
        $backtrace = debug_backtrace();

        $file = end($backtrace)['file'];
        $line = end($backtrace)['line'];

        $executionTime = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 4);
        $memoryUsage = round(memory_get_usage() / 1024 / 1024, 2) . ' MB';

        if($this->isWeb()){
            $info = $this->debuggingAt($file, $line);
            $info .= $this->executionTime($executionTime);
            $info .= $this->memoryUsage($memoryUsage);
            $info .= $this->getFunQuoteString($this->getFunQuote());
            $info .= $this->getCodeSnippet($file, $line);
            return $info;
        }
    }
}