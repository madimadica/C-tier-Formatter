<?php
require_once "Token.class.php";
require_once "Lexer.class.php";

$input = "
let five = 5;
let ten = 10;

let add = fn(x, y) {
  x + y;
};

let result = add(five, ten);
";

$expected_types = [
        [TokenType::KW_LET, "let"],
        [TokenType::IDENT, "five"],
        [TokenType::ASSIGN, "="],
        [TokenType::INT, "5"],
        [TokenType::SEMICOLON, ";"],
        [TokenType::KW_LET, "let"],
        [TokenType::IDENT, "ten"],
        [TokenType::ASSIGN, "="],
        [TokenType::INT, "10"],
        [TokenType::SEMICOLON, ";"],
        [TokenType::KW_LET, "let"],
        [TokenType::IDENT, "add"],
        [TokenType::ASSIGN, "="],
        [TokenType::KW_FUNCTION, "fn"],
        [TokenType::LPAREN, "("],
        [TokenType::IDENT, "x"],
        [TokenType::COMMA, ","],
        [TokenType::IDENT, "y"],
        [TokenType::RPAREN, ")"],
        [TokenType::LBRACE, "{"],
        [TokenType::IDENT, "x"],
        [TokenType::PLUS, "+"],
        [TokenType::IDENT, "y"],
        [TokenType::SEMICOLON, ";"],
        [TokenType::RBRACE, "}"],
        [TokenType::SEMICOLON, ";"],
        [TokenType::KW_LET, "let"],
        [TokenType::IDENT, "result"],
        [TokenType::ASSIGN, "="],
        [TokenType::IDENT, "add"],
        [TokenType::LPAREN, "("],
        [TokenType::IDENT, "five"],
        [TokenType::COMMA, ","],
        [TokenType::IDENT, "ten"],
        [TokenType::RPAREN, ")"],
        [TokenType::SEMICOLON, ";"],
        [TokenType::EOF, ""],
];

$lexer = new Lexer($input);

forEach ($expected_types as $i => $expected_token) {
    $token = $lexer->next_token();
    $expected_type = $expected_token[0];
    $expected_literal = $expected_token[1];
    if ($token->type != $expected_type) {
        echo "UNEXPECTED TOKEN!!! Expected: $expected_type, found: $token->type at identifier $i";
        die();
    }
    if ($token->literal != $expected_literal) {
        echo "WRONG LITERAL! Expected \"$expected_literal\" FOUND \"$token->literal\"";
    }
}

