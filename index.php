<?php
session_start();
require_once 'crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar_id'])) {
    $del_id = (int) $_POST['deletar_id'];
    if ($del_id > 0) {
        delete($pdo, 'musicas', 'id = ' . $del_id);
        $_SESSION['mensagem'] = 'Música excluída com sucesso!';
    }
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nova = [
        'nome'    => trim($_POST['nome']),
        'cantor'  => trim($_POST['cantor']),
        'genero'  => trim($_POST['genero']),
        'duracao' => trim($_POST['duracao']),
        'link'    => trim($_POST['link']),
        'capa'    => trim($_POST['foto']),
    ];
    if ($nova['nome'] && $nova['cantor']) {
        create($pdo, 'musicas', $nova);
        $_SESSION['mensagem'] = 'Música cadastrada com sucesso!';
        header('Location: index.php');
        exit;
    }
}

$busca     = isset($_GET['q']) ? trim($_GET['q']) : '';
$pagina    = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$por_pagina = 10;
$offset    = ($pagina - 1) * $por_pagina;

if ($busca) {
    $b     = $pdo->quote('%' . $busca . '%');
    $where = "nome LIKE $b OR cantor LIKE $b OR genero LIKE $b";
} else {
    $where = null;
}

$sqlCount = "SELECT COUNT(*) FROM musicas" . ($where ? " WHERE $where" : '');
$total    = (int) $pdo->query($sqlCount)->fetchColumn();
$paginas  = max(1, (int) ceil($total / $por_pagina));

$sqlPage  = "SELECT * FROM musicas" . ($where ? " WHERE $where" : '') . " ORDER BY id DESC LIMIT $por_pagina OFFSET $offset";
$musicas  = $pdo->query($sqlPage)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist – VibeVault</title>
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
                    <p><?= $total ?> música<?= $total !== 1 ? 's' : '' ?> cadastrada<?= $total !== 1 ? 's' : '' ?></p>
                </div>

                <form class="pesquisar" method="GET" action="index.php">
                    <input type="text" name="q" placeholder="Buscar música…" value="<?= htmlspecialchars($busca) ?>">
                    <button type="submit" style="background:none;border:none;cursor:pointer;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <a href="#cadastro" class="btn-header">
                    <i class="bi bi-plus-lg"></i> Nova Música
                </a>
            </div>

            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="alerta alerta-ok">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= htmlspecialchars($_SESSION['mensagem']) ?>
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
                        <?php if (empty($musicas)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:40px;color:var(--text-m);">
                                    <?= $busca ? 'Nenhuma música encontrada para "' . htmlspecialchars($busca) . '".' : 'Nenhuma música cadastrada ainda.' ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($musicas as $m): ?>
                                <tr>
                                    <td class="td-nome">
                                        <a href="visualizar.php?id=<?= $m['id'] ?>">
                                            <?= htmlspecialchars($m['nome']) ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($m['genero']) ?></td>
                                    <td><?= htmlspecialchars($m['cantor']) ?></td>
                                    <td><?= htmlspecialchars($m['duracao']) ?></td>
                                    <td>
                                        <?php if ($m['link']): ?>
                                            <a href="<?= htmlspecialchars($m['link']) ?>" target="_blank" title="Ouvir">
                                                <i class="bi bi-youtube" style="font-size:18px;color:var(--orange)"></i>
                                            </a>
                                        <?php else: ?>
                                            <span style="color:var(--text-l)">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="td-acao">
                                        <a href="visualizar.php?id=<?= $m['id'] ?>" class="btn-acao btn-editar" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="visualizar.php?id=<?= $m['id'] ?>" class="btn-acao btn-ver" title="Ver detalhes">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <form method="POST" onsubmit="return confirm('Excluir esta música?')">
                                            <input type="hidden" name="deletar_id" value="<?= $m['id'] ?>">
                                            <button type="submit" class="btn-acao btn-del" title="Excluir">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="rodape-tabela">
                            <td colspan="6" class="td-num">
                                Página <?= $pagina ?> de <?= $paginas ?>
                                <small><?= $total ?> registro<?= $total !== 1 ? 's' : '' ?> no total</small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php if ($paginas > 1): ?>
                <div class="paginacao">
                    <?php $qs = $busca ? '&q=' . urlencode($busca) : ''; ?>
                    <div class="seta">
                        <a href="?pagina=<?= max(1, $pagina - 1) . $qs ?>"><i class="bi bi-arrow-left"></i></a>
                    </div>
                    <div class="box-num">
                        <?php for ($p = 1; $p <= $paginas; $p++): ?>
                            <a href="?pagina=<?= $p . $qs ?>" <?= $p === $pagina ? 'class="ativo"' : '' ?>><?= $p ?></a>
                        <?php endfor; ?>
                    </div>
                    <div class="seta">
                        <a href="?pagina=<?= min($paginas, $pagina + 1) . $qs ?>"><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- ── SEÇÃO CADASTRO -->
        <section id="cadastro">
            <div class="container">
                <div class="form-card">
                    <h2>Cadastrar Nova Música</h2>
                    <form action="index.php#cadastro" method="POST">
                        <div class="form-group">
                            <label>Nome da Música</label>
                            <input type="text" placeholder="Ex: Gostava Tanto De Você" name="nome" required>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label>Gênero</label>
                                <input type="text" placeholder="Ex: Sertanejo" name="genero" required>
                            </div>
                            <div class="form-group">
                                <label>Foto da Música <span>(Opcional)</span></label>
                                <input type="text" placeholder="https://…" name="foto">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label>Cantor</label>
                                <input type="text" placeholder="Ex: Tim Maia" name="cantor" required>
                            </div>
                            <div class="form-group">
                                <label>Duração</label>
                                <input type="text" placeholder="Ex: 03:45" name="duracao">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Link da música</label>
                            <input type="text" placeholder="https://youtu.be/…" name="link">
                        </div>
                        <button type="submit" class="btn">Cadastrar Música</button>
                    </form>
                </div>
            </div>
        </section>

    </main>
</body>

</html>