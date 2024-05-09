<?php
require_once "Token.class.php";
class Lexer {
    public $input;
    public $position;
    public $readPosition;
    public $char;
    private $size;

    public function __construct($input) {
        $this->input = $input;
        $this->position = 0;
        $this->readPosition = 0;
        $this->char = "";
        $this->size = strlen($input);
        $this->read_char();
    }

    private function read_char() {
        if ($this->readPosition >= $this->size) {
            $this->char = "\0";
        } else {
            $this->char = $this->input[$this->readPosition];
        }
        $this->position = $this->readPosition;
        $this->readPosition++;
    }

    public function next_token() {
        $token = null;
        $this->consume_whitespace();
        $c = $this->char;
        switch ($c) {
            case "=":
                $token = new Token(TokenType::ASSIGN, $c);
                break;
            case "+":
                $token = new Token(TokenType::PLUS, $c);
                break;
            case "-":
                $token = new Token(TokenType::SUBTRACT, $c);
                break;
            case "*":
                $token = new Token(TokenType::MULTIPLY, $c);
                break;
            case "/":
                $token = new Token(TokenType::DIVIDE, $c);
                break;
            case ",":
                $token = new Token(TokenType::COMMA, $c);
                break;
            case ";":
                $token = new Token(TokenType::SEMICOLON, $c);
                break;
            case "(":
                $token = new Token(TokenType::LPAREN, $c);
                break;
            case ")":
                $token = new Token(TokenType::RPAREN, $c);
                break;
            case '[':
                $token = new Token(TokenType::LBRACK, $c);
                break;
            case ']':
                $token = new Token(TokenType::RBRACK, $c);
                break;
            case '{':
                $token = new Token(TokenType::LBRACE, $c);
                break;
            case '}':
                $token = new Token(TokenType::RBRACE, $c);
                break;
            case "\0":
                $token = new Token(TokenType::EOF, "");
                break;
            default:
                $token = new Token("", "");
                if (Lexer::is_start_of_identifier($c)) {
                    $token->literal = $this->read_identifier();
                    $token->type = Lexer::get_identifier_type($token->literal);
                    return $token; // Already read chars in read_identifier
                } else if (Lexer::is_number($c)) {
                    $token->type = TokenType::INT;
                    $token->literal = $this->read_number();
                    return $token;
                } else {
                    $token = new Token(TokenType::ILLEGAL, $c);
                }
                break;
        }
        $this->read_char();
        return $token;
    }

    public static function codepoint($char) {
        return unpack('C*', $char)[1];
    }

    private static function is_number($c) {
        $codepoint = Lexer::codepoint($c);
        return  (48 <= $codepoint && $codepoint <= 57);
    }

    private function read_number() {
        $start = $this->position;
        while (Lexer::is_number($this->char)) {
            $this->read_char();
        }
        $end = $this->position;
        return substr($this->input, $start, $end - $start);
    }

    private static function is_start_of_identifier($c) {
        $codepoint = Lexer::codepoint($c);
        return (65 <= $codepoint && $codepoint <= 90) || // Uppercase
            (97 <= $codepoint && $codepoint <= 122) || // Lowercase
            (95 == $codepoint) || // Underscore
            (36 == $codepoint); // Dollar
    }

    private static function is_part_of_identifier($c) {
        $codepoint = Lexer::codepoint($c);
        return (65 <= $codepoint && $codepoint <= 90) || // Uppercase
            (97 <= $codepoint && $codepoint <= 122) || // Lowercase
            (48 <= $codepoint && $codepoint <= 57) || // Number
            (95 == $codepoint); // Underscore
    }

    private function read_identifier() {
        $start = $this->position;
        $this->read_char(); // Assume called after we start at beginning of ident
        while (Lexer::is_part_of_identifier($this->char)) {
            $this->read_char();
        }
        $end = $this->position;
        return substr($this->input, $start, $end-$start); // TODO off by 1?
    }

    private static function get_identifier_type($str) {
        if (array_key_exists($str, TokenType::KEYWORDS)) {
            return TokenType::KEYWORDS[$str];
        } else {
            return TokenType::IDENT;
        }
    }

    private static function is_whitespace($c) {
        return ($c === " " || $c === "\t" || $c === "\n" || $c === "\r");
    }

    private function consume_whitespace() {
        while (Lexer::is_whitespace($this->char)) {
            $this->read_char();
        }
    }

}