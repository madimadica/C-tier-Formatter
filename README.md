# C-tier Formatter
***A simple code formatter for C-style languages.***

The primary use case for this formatter is to be used alongside
a code generator. This would allow a code generator to greatly reduce
its care for whitespace, and instead focus on the tokens. Speaking of tokens,
the reason this is "C-tier" is that it lacks any sort of tokenization or AST parsing.
The implementations mostly focus on whitespace, semicolons, and curly braces.

As this is intended to be used with a code generator, it is written in multiple
languages to support direct usage in your code without invoking an executable.
