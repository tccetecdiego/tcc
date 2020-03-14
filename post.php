<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

//conexão com banco de dados

$sql = new mysqli('localhost', 'root', '', 'tcc');
$conteudo = json_decode(file_get_contents('php://input'));

if($conteudo->funcionalidade == 'cadastrar'){
    $convert = mysqli_query($sql,"CALL cadastrar('$conteudo->nome',$conteudo->quantidade,$conteudo->quantidadem,$conteudo->preco)");
    while($coluna = mysqli_fetch_array($convert)) {
        $mensagem = $coluna['mensagem'];
    }
}
else{
    $mensagem = 'Erro';
}

echo $mensagem;



?>