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
elseif($conteudo->funcionalidade == 'alterareexcluir'){
    foreach ($conteudo->itens as $item) {
        $minQuantidade =$item->minQuantidade;
        $quantidade =$item->quantidade;
        $id = $item->id;
        $sql->query("UPDATE item SET quantidade = $quantidade, minQuantidade = $minQuantidade  WHERE id = $id");
    }
    foreach ($conteudo->deletados as $itemD) {
        $val = mysqli_query($sql,"SELECT * FROM item WHERE id = $itemD;");
        $vali = mysqli_num_rows($val);
        if($vali == 1){
            $sql->query("INSERT INTO deletados(id,nome, quantidade, minQuantidade, preco) select p.id,p.nome,p.quantidade,p.minQuantidade,p.preco from item as p where id = $itemD;");
            $sql->query("DELETE FROM item WHERE id = $itemD;");
        }
    }
    $mensagem = 'atualização concluida com sucesso';

}

elseif($conteudo->funcionalidade == 'finalizaralteracao'){
    $id = $conteudo->item->id;
    $nome = $conteudo->item->nome;
    $quantidade = $conteudo->item->quantidade;
    $minQuantidade = $conteudo->item->minQuantidade;
    $preco = $conteudo->item->preco;
    $result = mysqli_query($sql,"CALL alterar($id,'$nome',$quantidade,$minQuantidade,$preco)");
    while($coluna = mysqli_fetch_array($result)) {
        $mensagem = $coluna['mensagem'];
    }
}
else{
    $mensagem = 'Erro';
}

echo $mensagem;



?>