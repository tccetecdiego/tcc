<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

//conexão com banco de dados

$sql = new mysqli('localhost', 'root', '', 'tcc');
$conteudo = json_decode(file_get_contents('php://input'));

if($conteudo->funcionalidade == 'cadastrar'){
    $dados = mysqli_query($sql,"SELECT * from item where nome = '$conteudo->nome'");
    $vali = mysqli_num_rows($dados);
    if($vali == 0){
        $sql->query("INSERT INTO 
                        item
                        (nome, quantidade, minQuantidade, preco) VALUES('$conteudo->nome','$conteudo->quantidade','$conteudo->quantidadem','$conteudo->preco')");
        $mensagem = 'Cadastrado com sucesso';
    }else{
        $mensagem = 'Produto ja cadastrado, insira um novo nome';
    }
}
else{
    $mensagem = 'Erro';
}

echo $mensagem;



?>