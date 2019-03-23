<!DOCTYPE html>
<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

use Db\Persiste;
use Models\Pessoa;
use Models\Atividade;
use Models\Funcionario;

if (isset($_POST['Add'])){
  $p = new Pessoa($_POST['id'],$_POST['nome'],$_POST['telefone']);
  Persiste::Add($p);
}
else if (isset($_POST['Excluir'])){
  $p = new Pessoa($_POST['hfId'], null, null);
  Persiste::Delete($p);
} else if (isset($_POST['Alterar'])){
  $p = new Pessoa($_POST['id'],$_POST['nome'],$_POST['telefone']);
  Persiste::Update($p);
}

$arrPessoas = Persiste::FindAll("Pessoa");

  $title = "CRUD utilizando PDO";
?>
<html>
  <?php include_once('head.php'); ?>

  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <h1><?php echo $title; ?></h1>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <h3>Pessoas cadastradas</h3>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <table style="text-align: center" class="table table-striped">
            <tr>
              <th style="width: 100px">Detalhes</th>
              <th style="width: 100px">Excluir</th>
              <th>#</th>
              <th>Pessoa</th>
              <th>Telefone</th>
            </tr>
            <?php
              foreach ($arrPessoas as $key => $value) {
                echo "<tr>";
                echo "<td>"."<form method=\"post\" action='detalhes.php'><input type=\"hidden\" name='hfId' value='".$value['id']."'/> <button class='btn btn-primary' name='Detalhes' value='Detalhes' type=\"submit\"><i class='fas fa-info-circle'></i></button></form> "."</td>";
                echo "<td>"."<form method=\"post\"><input type=\"hidden\" name='hfId' value='".$value['id']."'/> <button class='btn btn-danger' name='Excluir' value='Excluir' type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></form> "."</td>";
                echo "<td>".$value['id']."</td>";
                echo "<td>".$value['nome']."</td>";
                echo "<td>".$value['telefone']."</td>";
                echo "</tr>";
              }

              echo "<tr><form method=\"post\"><td colspan='2'>"." <button class='btn btn-success' name='Add' value='Add' type=\"submit\"><i class=\"fas fa-plus\"></i></button> "."</td><td><input type='number' name='id'/></td></td><td><input type='text' name='nome'/></td><td><input type='text' name='telefone'/></td></form></tr>"
            ?>
          </table>
        </div>
      </div>

    </div>
  </body>
</html>
