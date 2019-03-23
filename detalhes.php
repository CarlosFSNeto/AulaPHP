<!DOCTYPE html>
<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

use Db\Persiste;
use Models\Pessoa;
use Models\Atividade;
use Models\Funcionario;

  $title = "Detalhes da pessoa";

  $p = Persiste::Find("Pessoa", $_POST['hfId']);
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
<form action="pdo.php" method="post">
    <div class="form-group">
      <label for="id">ID</label>
      <input class="form-control" id="id" name="id" type="text" value="<?php echo $p['id'] ?>" readonly></input>
    </div>

    <div class="form-group">
      <label for="id">Nome</label>
      <input class="form-control" id="nome" name="nome" type="text" value="<?php echo $p['nome'] ?>" ></input>
    </div>

    <div class="form-group">
      <label for="id">Telefone</label>
      <input class="form-control" id="telefone" name="telefone" type="text" value="<?php echo $p['telefone'] ?>" ></input>
    </div>

    <button type="submit" name="Alterar" class="btn btn-success">Alterar</button>

</form>
  </div>
  </body>
</html>
