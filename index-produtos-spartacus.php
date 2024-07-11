<!--
====================================
Lista registros da Tabela: Spartacus
====================================
-->

<!-- Início da Paginação (Parte 1) -->

<?php
include('config.php');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

$sql_produto_count_query = "SELECT COUNT(*) as count FROM spartacus";

try {

    $stmt_count = $pdo->prepare($sql_produto_count_query);
	$stmt_count->execute();
	$result_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
	$produto_count = $result_count['count'];

} catch (PDOException $erro) {
	die('Erro na consulta de contagem: ' . $erro->getMessage());
}

$page_number = ceil($produto_count / $limit);

$sql_produtos_query = "SELECT * FROM spartacus ORDER BY id ASC LIMIT :limit OFFSET :offset";

try {
    $stmt_produtos = $pdo->prepare($sql_produtos_query);
    $stmt_produtos->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt_produtos->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt_produtos->execute();
    $produtos = $stmt_produtos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    die('Erro na consulta de produtos: ' . $erro->getMessage());
}
?>

<!-- Final da Paginação (Parte 1) -->

<!DOCTYPE html>
<html lang="pt-BR">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Produtos Cadastrados - Spartacus</title>
        <meta name="description" content="Produtos Cadastrados - Spartacus">
        <meta name="author" content="Marcelo de Meneses Guedes">
        <meta name="contact" content="marceloguedes@terra.com.br">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
        <link rel="shortcut icon" href="../imagens/favicon.png">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

<!-- Início do Include do Header -->

<?php include("../includes/header-adm.php"); ?>

<!-- Final do Include do Header -->

<!-- Início do Cabeçalho -->

            <div role="main" class="main">
                <section class="page-header page-header-classic page-header-sm">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                                <h1 data-title-border>Produtos Cadastrados - Spartacus</h1>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

<!-- Final do Cabeçalho -->

<!-- Início da Tabela dos Produtos Cadastrados -->

            <div class="container py-2">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col pb-3">
                                <table class="table table-striped text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Produto</th>
                                        <th>Lojista</th>
                                        <th>Corpo</th>
                                        <th>Local da Compra</th>
                                        <th>Data da Compra</th>
                                        <th>Ações</th>
                                    </tr>

                                    <tbody>
                                    <?php
                                        if ($stmt_produtos->rowCount() > 0) {
                                            foreach ($produtos as $produto) {
                                                echo '<tr>';
                                                echo '<td><strong>' . $produto['id'] . '</strong></td>';
                                                echo '<td>' . $produto['produto'] . '</td>';
                                                echo '<td>' . $produto['lojista'] . '</td>';
                                                echo '<td>' . $produto['corpo'] . '</td>';
                                                echo '<td>' . $produto['localdacompra'] . '</td>';
                                                echo '<td>' . date("d/m/Y", strtotime($produto['datadacompra'])) . '</td>';
                                                echo '<td>
                                                        <a href="#.php?id=' . $produto['id'] . '"><button type="button" class="btn btn-outline btn-success btn-sm"><strong>Editar</strong></button></a>
                                                        <a href="#.php?id=' . $produto['id'] . '"><button type="button" class="btn btn-outline btn-danger btn-sm"><strong>Excluir</strong></button></a>
                                                        <a href="#.php?id=' . $produto['id'] . '"><button type="button" class="btn btn-outline btn-primary btn-sm"><strong>  Info  </strong></button></a>
                                                    </td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>

<!-- Final da Tabela dos Produtos Cadastrados -->
 
<!-- Final da Paginação Simples - Não usar

                                <p>
                                    <?php echo "<strong>Página {$page}</strong>"; ?><?php echo "<strong> de {$page_number}</strong>"; ?>
                                </p>

Início da Paginação Simples - Não usar -->

<!-- Início da Paginação (Parte 2) -->

                                <nav aria-label="Navegação de página">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item"><a class="page-link" href="?page=1">Primeira</a></li>
                                        <?php endif; ?>

                                        <?php
                                        $page_interval = 10;

                                        $start_page = max(1, $page - floor($page_interval / 2));
                                        $end_page = min($page_number, $start_page + $page_interval - 1);

                                        if ($end_page - $start_page + 1 < $page_interval) {
                                            $start_page = max(1, $end_page - $page_interval + 1);
                                        }

                                        for ($p = $start_page; $p <= $end_page; $p++): ?>
                                            <li class="page-item <?php echo $p == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $page_number): ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page_number; ?>">Última</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>

<!-- Final da Paginação (Parte 2) -->

                                <br><br>

                                <div class="row">
                                    <div class="col text-center">
                                        <a href="#.php"><button type="button" class="btn btn-outline btn-primary btn-lg"><strong>Adicionar Novo Produto</strong></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- Início do Include do Footer -->

<?php include("../includes/footer-adm.php"); ?>

<!-- Final do Include do Footer -->
