<?php
session_start();
require_once 'crud.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $dados = [
        'nome'    => trim($_POST['nome']),
        'cantor'  => trim($_POST['cantor']),
        'genero'  => trim($_POST['genero']),
        'duracao' => trim($_POST['duracao']),
        'link'    => trim($_POST['link']),
        'capa'    => trim($_POST['capa']),
    ];
    update($pdo, 'musicas', $dados, 'id = ' . $id);
    $_SESSION['mensagem'] = 'Música atualizada com sucesso!';
    header('Location: visualizar.php?id=' . $id);
    exit;
}

$musica = read($pdo, 'musicas', 'id = ' . $id);
if (!$musica) {
    header('Location: index.php');
    exit;
}

function youtubeEmbed($url)
{
    preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
    return isset($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=0' : '';
}
$embedUrl = youtubeEmbed($musica['link'] ?? '');

$capa = $musica['capa'] ?: 'https://placehold.co/400x400/212221/30f916?text=🎵';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($musica['nome']) ?> – VibeVault</title>
    <link rel="stylesheet" href="css/visualizar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <header>
        <a href="index.php"><i class="bi bi-box-arrow-left"></i></a>
    </header>

    <?php if (isset($_SESSION['mensagem'])): ?>
        <div style="text-align:center;padding:10px 20px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;margin:0 40px;border-radius:8px;">
            <i class="bi bi-check-circle-fill"></i>
            <?= htmlspecialchars($_SESSION['mensagem']) ?>
        </div>
        <?php unset($_SESSION['mensagem']); ?>
    <?php endif; ?>

    <div class="player">

        <div class="card" style="min-width:300px;max-width:340px;">
            <?php if ($embedUrl): ?>
                <div style="position:relative;width:100%;padding-bottom:56.25%;margin-bottom:20px;border-radius:var(--radius-s);overflow:hidden;">
                    <iframe
                        src="<?= $embedUrl ?>"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            <?php else: ?>
                <img src="<?= htmlspecialchars($capa) ?>" class="capa" alt="capa" onerror="this.src='https:...'">
            <?php endif; ?>

            <div class="info">
                <h2><?= htmlspecialchars($musica['nome']) ?></h2>
                <p><?= htmlspecialchars($musica['cantor']) ?></p>
            </div>

            <?php if (!$embedUrl): ?>
                <div class="progresso">
                    <span>00:00</span>
                    <div class="barra">
                        <div class="barra-fill" style="width:0%;background:var(--orange)"></div>
                    </div>
                    <span><?= htmlspecialchars($musica['duracao'] ?: '—') ?></span>
                </div>
                <div class="controles">
                    <button><i class="bi bi-skip-start-fill"></i></button>
                    <button class="play"><i class="bi bi-play-circle-fill"></i></button>
                    <button><i class="bi bi-skip-end-fill"></i></button>
                </div>
            <?php endif; ?>
        </div>

        <div class="box-details">

            <div class="detalhes">
                <h2>Detalhes</h2>

                <?php if ($musica['link']): ?>
                    <div class="link">
                        <h4>Link da Música</h4>
                        <a href="<?= htmlspecialchars($musica['link']) ?>" target="_blank">
                            Ouvir agora no YouTube <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="genero">
                    <h4>Gênero</h4>
                    <span><?= htmlspecialchars($musica['genero'] ?: '—') ?></span>
                </div>

                <div class="genero">
                    <h4>Duração</h4>
                    <span><?= htmlspecialchars($musica['duracao'] ?: '—') ?></span>
                </div>
            </div>

            <!-- Editar -->
            <div class="editar">
                <div class="top-header">
                    <h2>Editar</h2>
                    <i class="bi bi-pencil-square"></i>
                </div>

                <form method="POST" action="visualizar.php?id=<?= $id ?>">
                    <div class="row">
                        <div class="form-group">
                            <label>Cantor</label>
                            <input type="text" name="cantor" value="<?= htmlspecialchars($musica['cantor']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Música</label>
                            <input type="text" name="nome" value="<?= htmlspecialchars($musica['nome']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Duração</label>
                            <input type="text" name="duracao" placeholder="03:45" value="<?= htmlspecialchars($musica['duracao']) ?>">
                        </div>
                        <div class="form-group">
                            <label>Gênero</label>
                            <input type="text" name="genero" value="<?= htmlspecialchars($musica['genero']) ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Link da Música</label>
                            <input type="text" name="link" placeholder="https://youtu.be/…" value="<?= htmlspecialchars($musica['link']) ?>">
                        </div>
                        <div class="form-group">
                            <label>Capa da Música</label>
                            <input type="text" name="capa" placeholder="https://…" value="<?= htmlspecialchars($musica['capa']) ?>">
                        </div>
                    </div>
                    <button type="submit" name="salvar" class="btn">Salvar Alterações</button>
                </form>
            </div>

        </div>
    </div>

</body>

</html>