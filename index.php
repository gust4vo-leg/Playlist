<?php 

// require_once 'init.php';

// $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
// $por_pagina = 5;
// $inicio = ($pagina - 1) * $por_pagina;
// $produtos = array_slice($_SESSION['musicas'], $inicio, $por_pagina);

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar_id'])) {
//     $del_id = $_POST['deletar_id'];
//     $_SESSION['musicas'] = array_values(
//         array_filter($_SESSION['musicas'], fn($p) => $p['id'] != $del_id)
//     );

//     $_SESSION['mensagem'] = "Produto excluído com sucesso!!";
//     header('Location: tabela-tuch.php');
//     exit;
// }

?>

<!DOCTYPE html>
<html lang="Pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist - VibeVault</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cadastrar.css">
</head>

<body>
    <main>
        <div class="container-pagina">
            <div class="tabela-header">
                <div>
                    <h1>Playlist</h1>
                    <p>
                        músicas cadastradas
                    </p>
                </div>
                <div class="pesquisar">
                    <input type="text" placeholder="Buscar música"><i class="bi bi-search"></i>
                </div>
                <a href="#cadastro" class="btn-header">
                    <i class="bi bi-plus-lg"></i> Nova Música
                </a>
            </div>

            <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alerta alerta-ok">
                <i class="bi bi-check-circle-fill"></i>
            <?php echo $_SESSION['mensagem']; ?>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
            <?php endif; ?>

            <div class="tabela-wrapper">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Música</th>
                            <th>Gênero</th>
                            <th>Cantor</th>
                            <th>Duração</th>
                            <th>Link</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="nome">
                                 <a href="#cadastro"><i class="bi bi-plus-lg"></i></a>
                            </td>
                            <td class="genero"></td>
                            <td class="Cantor"></td>
                            <td class="Duração"></td>
                            <td class="link"></td>

                            <td class="td-acao">
                                <a href="visualizar.php" class="btn-acao btn-editar"><i class="bi bi-pencil-square"></i></a>
                                <a href="visualizar.php" class="btn-acao btn-ver" title="Ver detalhes">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- deletar -->
                                <form method="POST">
                                    <input type="hidden" name="deletar_id">
                                    <button type="submit" class="btn-acao btn-del" title="Excluir">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                                <!-- ------------ -->
                            </td>
                        </tr>
                    
                    </tbody>
                </table>
            </div>
            <div class="paginacao">
                <div class="seta">
                    <a class="seta" href="#"><i class="bi bi-arrow-left"></i></a>
                </div>
                <div class="box-num">
                    <a href="#">1</a>
                </div>
                <div class="seta">
                    <a class="seta" href="#">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- CADASTRAR MÚSICA -->

        <section id="cadastro">
            <div class="container">

                <div class="form-card">
                    <h2>Cadastrar Nova Música</h2>

                    <form action="#" method="POST" id="cadastro">
                        <div class="form-group">
                            <label>Nome da Música</label>
                            <input type="text" placeholder="Ex: Gostava Tanto De Você" name="nome" required>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Gênero</label>
                                <input type="text" placeholder="Ex: Sertanejo" required name="genero">
                            </div>

                            <div class="form-group">
                                <label>Foto da Música <span>(Opcional)</span></label>
                                <input type="text"
                                    placeholder="Ex: https://br.freepik.com/fotos-vetores-gratis/capa-de-musica" name="foto">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Cantor</label>
                                <input type="text" placeholder="Ex: Tim Maia" name="cantor" required>
                            </div>

                            <div class="form-group">
                                <label>Duração</label>
                                <input type="text" pattern="^[0-9](1,2):[0-5][0-9]$" placeholder="Ex: 01:56" name="duracao">
                            </div>
                        </div>

                        <div class="form-group"><label>Link da música</label>
                            <input type="text" placeholder="Ex: https://youtu.be/rWRT4i43Lgs?si=cXPTZD1Bt0wTQV8A"
                                name="link">

                        </div>

                        <button class="btn">Cadastrar Música</button>
                    </form>
                </div>

            </div>
        </section>
    </main>
</body>

</html>