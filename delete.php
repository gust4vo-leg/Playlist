<?php 
require_once 'crud.php';

$idMusica = 674;

$delete = delete($pdo, 'livros', 'id = '.$idMusica);

if ($delete) {
    echo 'Música deletada com sucesso!!';
} else {
    echo 'Erro ao deletar a música!!';
}