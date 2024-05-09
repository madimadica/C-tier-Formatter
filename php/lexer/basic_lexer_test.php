<?php
require_once "Token.class.php";
require_once "Lexer.class.php";

$input = "=+(){},;";

$expected_types = [
    [TokenType::ASSIGN, "="],
    [TokenType::PLUS, "+"],
    [TokenType::RPAREN, "("],
    [TokenType::LPAREN, ")"],
    [TokenType::LBRACE, "{"],
    [TokenType::RBRACE, "}"],
    [TokenType::COMMA, ","],
    [TokenType::SEMICOLON, ";"]
];

$lexer = new Lexer($input);

forEach ($expected_types as $i => $expected_token) {
    $token = $lexer->next_token();
    $expected_type = $expected_token[0];
    $expected_literal = $expected_token[1];
    if ($token->type != $expected_type) {
        echo "UNEXPECTED TOKEN!!! Expected $expected_type FOUND $token->type";
        die();
    }
    if ($token->literal != $expected_literal) {
        echo "WRONG LITERAL! Expected \"$expected_literal\" FOUND \"$token->literal\"";
    }
}

