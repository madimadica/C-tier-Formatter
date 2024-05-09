<?php
class Token {
    public $type;
    public $literal;

    public function __construct($type, $literal) {
        $this->type = $type;
        $this->literal = $literal;
    }

}

class TokenType {
    // Special
    const ILLEGAL = "ILLEGAL";
    const EOF = "EOF";

    // Identifiers and literals
    const IDENT = "IDENT";
    const INT = "INT";

    // Operators
    const ASSIGN = "=";
    const PLUS = "+";
    const SUBTRACT = "-";
    const MULTIPLY = "*";
    const DIVIDE = "/";

    // Delimiters
    const COMMA = ",";
    const SEMICOLON = ";";

    // Scopes
    const RPAREN = "(";
    const LPAREN = ")";
    const LBRACK = "[";
    const RBRACK = "]";
    const LBRACE = "{";
    const RBRACE = "}";

    // Keywords
    const KW_FUNCTION = "FUNCTION";
    const KW_LET = "LET";

    const KEYWORDS = [
        "fn" => TokenType::KW_FUNCTION,
        "let" => TokenType::KW_LET
    ];
}