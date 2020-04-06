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
elseif($conteudo->funcionalidade == 'finalizarcompra'){
    foreach ($conteudo->itens as $a) {
        while($a->qua > 0){
           $sql->query("INSERT INTO historico(item_id, data)
            VALUES ($a->id,CURDATE())");
            $sql->query("UPDATE item SET quantidade= quantidade - 1 WHERE id = $a->id");
            $a->qua--;
        }
    }
    $mensagem = 'finalizado';
}
elseif($conteudo->funcionalidade == 'finalizaralteracao'){
    $id = $conteudo->item->id;
    $nome = $conteudo->item->nome;
    $quantidade = $conteudo->item->quantidade;
    $minQuantidade = $conteudo->item->minQuantidade;
    $preco = $conteudo->item->preco;


    $sql->query("UPDATE item SET nome= '$nome', quantidade = $quantidade, minQuantidade = $minQuantidade, preco = $preco WHERE id = $id");
    $mensagem = 'Alterado';
}
else{
    $mensagem = 'Erro';
}

echo $mensagem;



?>