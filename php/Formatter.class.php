<?php

class Formatter {
    private $input;
    private $output;
    private $indent_level = 0;

    public function __construct($input) {
        $this->input = $input;
    }

    private function indent_line($s) {
        if (strlen($s) === 0) {
            return "";
        }
        return "\n" . str_repeat("    ", $this->indent_level) . $s;
    }

    public function format() {
        $start = 0;
        for ($i = 0, $LUB = strlen($this->input); $i < $LUB; $i++) {
            $char = $this->input[$i];
            if ($char === "{") {
                // Need to get everything before this
                $section = substr($this->input, $start, $i - $start);
                $s = trim($section) . " {";
                echo $this->indent_line($s);
                $this->indent_level++;
                $start = $i + 1;
            }
            if ($char === "}") {
                $section = substr($this->input, $start, $i - $start);
                echo $this->indent_line(trim($section));
                $this->indent_level--;
                echo $this->indent_line("}");
                $start = $i + 1;
            }
            if ($char === "\n" || $char === ";") {
                $section = substr($this->input, $start, $i - $start + 1);
                echo $this->indent_line(trim($section));
                $start = $i + 1;
            }
        }

        return $this->output;
    }
}
