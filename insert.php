<?php
require_once 'crud.php';

$novaMusica = [
    'nome' => 'Nossa Praia',
    'Genero' => 'Sertanejo',
    'cantor' => 'Matheus e Kauan',
    'capa' => 'imagens/nossa-praia.jpg',
    'duracao' => '03:56',
    'link' => 'https://youtu.be/_v0-5QY6y-M?si=HIR0x73wBJjLPUcj',
];

$idMusicaNova = create($pdo, 'livros', $novaMusica);
echo 'Novo livro inserido com ID: '.$idMusicaNova;