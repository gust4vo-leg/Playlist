<?php

require_once 'crud.php';

 print '<table border=1>
 <tr>
 <th>ID</th>
 <th>Titulo</th>
 </tr>';
$musica = readAll($pdo, 'musica');

// print_r($livros);

foreach($musica as $musicas) {
    echo "<tr><td>".$musicas['id']."</td><td>".$musicas['titulo']."<br>";
}

print "</table>";

$musica = read($pdo, 'livros', 'id = 674');
if ($musica) {
    echo '<p>O livro em questão é: '. $musica['titulo'] .'</p>';
}