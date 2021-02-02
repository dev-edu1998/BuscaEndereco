<?php 

include_once "conexaoPDO.php";

$recebidoCep = $_GET['cep'];
$recebidoCep = preg_replace("/[^0-9]/", "", $recebidoCep);

$sql = "SELECT CEP FROM bancocep.endereco WHERE cep = :cep ";
$result = ConexaoBD::getInstance()->prepare($sql) or die("Erro ao selecionar");
$result->bindValue(':cep', $recebidoCep);
$result->execute();
$linhas = $result->rowCount();


if($linhas > 0){
  echo 'existente';
}else{
  function get_endereco($cep){
    $url = "http://viacep.com.br/ws/$cep/xml/";
    $xml = simplexml_load_file($url) or die('Error!');
    return $xml;     
  }
  
  
  $endereco = get_endereco($recebidoCep);
  
  $url = file_get_contents("http://viacep.com.br/ws/$recebidoCep/xml/");
  file_put_contents('recebe.xml',$url);
  
 $sql = "INSERT INTO bancocep.endereco
  (uf,
  cidade,
  bairro,
  rua,
  complemento,
  cep)
  VALUES
  (:uf,:cidade,:bairro,:logradouro,:complemento, :cep);";
  $result = ConexaoBD::getInstance()->prepare($sql) or die("Erro ao selecionar");
  $result->bindValue(':uf', $endereco->uf);
  $result->bindValue(':cidade', $endereco->localidade);
  $result->bindValue(':bairro', $endereco->bairro);
  $result->bindValue(':logradouro', $endereco->logradouro);
  $result->bindValue(':complemento', $endereco->complemento);
  $result->bindValue(':cep', $recebidoCep);
  $result->execute();
  $linhas = $result->rowCount();

 
}

?>