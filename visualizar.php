<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar - VibeVault</title>
    <link rel="stylesheet" href="css/visualizar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <a href="index.php"><i class="bi bi-box-arrow-left"></i></a>
    </header>
    <div class="player">

        <div class="card">

            <img src="imagens/nossa-praia.jpg" class="capa">

            <div class="info">
                <h2>Nossa Praia</h2>
                <p>Matheus e Kauan</p>
            </div>

            <div class="progresso">
                <span>00:00</span>
                <div class="barra">
                    <div class="barra-fill"></div>
                </div>
                <span>3:45</span>
            </div>

            <div class="controles">
                <button><i class="bi bi-skip-start-fill"></i></button>
                <button class="play"><i class="bi bi-play-circle-fill"></i></button>
                <button><i class="bi bi-skip-end-fill"></i></button>
            </div>
        </div>
        <div class="box-details">
            <div class="detalhes">
                <h2>Detalhes</h2>
                <div class="link">
                    <h4>Link da Música</h3>
                        <a href="https://youtu.be/_v0-5QY6y-M?si=HIR0x73wBJjLPUcj">
                            Ouvir agora no Youtube <i class="bi bi-youtube"></i>
                        </a>
                </div>
                <div class="genero">
                    <h4>Gênero</h4>
                    <span>Sertanejo</span>
                </div>
            </div>
            <div class="editar">
                <div class="top-header">
                    <h2>Editar</h2>
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>Cantor</label>
                        <input type="text" placeholder="Ex: Tim Maia" name="cantor">
                    </div>
                    <div class="form-group">
                        <label>Música</label>
                        <input type="text" placeholder="Ex: Nossa Praia" name="musica">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>Duração</label>
                         <input type="text" pattern="^[0-9](1,2):[0-5][0-9]$" placeholder="Ex: 01:56" name="duracao">
                    </div>
                    <div class="form-group">
                        <label>Gênero</label>
                        <input type="text" placeholder="Ex: Sertanejo" name="genero">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>Link da Música</label>
                        <input type="text" placeholder="Ex: https://youtu.be/_v0-5QY6y-M?si=HIR0x73wBJjLPUcj" name="link">
                    </div>
                    <div class="form-group">
                        <label>Capa da Música</label>
                        <input type="text" placeholder="Ex: https://br.freepik.com/fotos-vetores-gratis/capa-de-musica" name="imagem">
                    </div>
                </div>
                <div class="btn">
                    Salvar Alterações
                </div>
            </div>
        </div>
    </div>

</body>

</html>