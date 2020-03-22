<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

//conexão com banco de dados

$sql = new mysqli('localhost', 'root', '', 'tcc');
$funcionalidade = $_GET['funcionalidade'];
$mensagem = array();

if($funcionalidade == 'comprarcodigo'){
    $getinho = $_GET['codigo']; 
    $dados = mysqli_query($sql, "SELECT * FROM item WHERE id = '$getinho' ");
    $vali = mysqli_num_rows($dados);
    if($vali == 0){
        array_push($mensagem, array('mensagem' => 'codigo não encontrado'));  
    }
    else{
        while($row = mysqli_fetch_object($dados)){
            array_push($mensagem, array('id'=> $row->id, 'nome'=> $row->nome,
            'quantidade'=> $row->quantidade, 'minQuantidade'=> $row->minQuantidade, 'preco'=> $row->preco,
            'mensagem' => 'codigo encontrado' ));
        }
    }
    
}else if($funcionalidade == 'comprarnome'){
    $getinho = $_GET['nome'];
    //$dados = mysqli_query($sql, "SELECT * FROM item WHERE nome like '%$getinho%'");
    $dados = mysqli_query($sql, "SELECT * FROM item WHERE nome = '$getinho'");
    $vali = mysqli_num_rows($dados);
    if($vali == 0){
        $dados = mysqli_query($sql, "SELECT * FROM item WHERE nome like '%$getinho%'");
        $vali = mysqli_num_rows($dados);
        if($vali == 0){
            array_push($mensagem, array('mensagem' => 'nome nâo encontrado'));
        }else{
            while($row = mysqli_fetch_object($dados)){
                array_push($mensagem, array('id'=> $row->id, 'nome'=> $row->nome,
                'quantidade'=> $row->quantidade, 'minQuantidade'=> $row->minQuantidade, 'preco'=> $row->preco,
                'mensagem' => 'nome encontrado' ));
            }
        }
          
    }
    else{
        while($row = mysqli_fetch_object($dados)){
            array_push($mensagem, array('id'=> $row->id, 'nome'=> $row->nome,
            'quantidade'=> $row->quantidade, 'minQuantidade'=> $row->minQuantidade, 'preco'=> $row->preco,
            'mensagem' => 'nome encontrado' ));
        }
    }
       
}else{

    array_push($mensagem, array('mensagem' => 'Não ha nada aqui'));
 
}


echo json_encode($mensagem[0]);

?>
