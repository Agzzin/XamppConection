<?php

include_once('conexao.php');

$query = $pdo->query("SELECT * from (`users-irriga`) order by id desc ");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }
      $dados[] = array(
        'id' => $res[$i]['id'],
        'email' => $res[$i]['Email'],
        'Nome' => $res[$i]['NomeCompleto'],
        'telefone' => $res[$i]['Telefone'],
        'senha' => $res[$i]['Senha'],
    );
}

if (count($res) > 0 ){
  $result = json_encode(array('success'=> true, 'result'=>$dados));
} else {
  $result = json_encode(array('success' => false, 'result' => '0'));
}
echo $result;

?>