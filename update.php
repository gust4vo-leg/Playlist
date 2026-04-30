<?php
require_once 'crud.php';

$idMusicas = 674;

$dadosAtualizados = [
    'nome' => 'Nossa Praia',
    'Genero' => 'Sertanejo',
    'cantor' => 'Matheus e Kauan',
    'capa' => 'imagens/nossa-praia.jpg',
    'duracao' => '03:56',
    'link' => 'https://youtu.be/_v0-5QY6y-M?si=HIR0x73wBJjLPUcj',
];

$musicasAfetadas = update($pdo, 'livros', $dadosAtualizados, 'id = '.$idMusicas);

if ($musicasAfetadas > 0) {
    echo 'Livro atualizado com sucesso!!';
} else {
    echo 'Não foi possível atualizar o livro!!!';
}
