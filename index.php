<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>00084-pet-php</title>
  <link rel="stylesheet" href="./style.css" />
</head>

<body>
  <?php
  $name = $age = $rank;
  $start = microtime(true);
  define("SERVER_NAME", "127.0.0.1");
  define("DB_LOGIN", "root");
  define("DB_PASS", "");
  define("DB_NAME", "00084-pet-php");
  $connect = new mysqli(SERVER_NAME, DB_LOGIN, DB_PASS, DB_NAME);
  $sql = "SELECT * FROM `heroes` ";
  $result = $connect->query($sql);
  for ($user = array(); $row = $result->fetch_assoc(); $user[] = $row);
  $connect->close();

  $last = count($user) - 1;
  $last_id = $user[$last]['id'] + 1;


  if (isset($_POST['add_hero'])) {
    $name = $_POST['name'] ?? '0';
    $age = $_POST['age'] ?? '0';
    $rank = $_POST['rank'] ?? '0';
    $connect = new mysqli(SERVER_NAME, DB_LOGIN, DB_PASS, DB_NAME);
    $sql = "INSERT INTO `heroes` (`id`, `name`, `age`, `rank`) VALUES ('$last_id', '$name', '$age', '$rank')";
    $connect->query($sql);
    $connect->close();
    header("Location: /");
  }

  if (isset($_GET['change'])) {
    $id = $_GET['change'] ?? '';
    $name = $user[$id]['name'] ?? '';
    $age = $user[$id]['age'] ?? '';
    $rank = $user[$id]['rank'] ?? '';
    $id_base = $user[$id]['id'] ?? '';
  }

  if (isset($_POST['edit_hero'])) {
    $name = $_POST['name'] ?? '0';
    $age = $_POST['age'] ?? '0';
    $rank = $_POST['rank'] ?? '0';
    $connect = new mysqli(SERVER_NAME, DB_LOGIN, DB_PASS, DB_NAME);
    $sql = "UPDATE `heroes` SET `name` = '$name', `age` = '$age', `rank` = '$rank' WHERE `id` = '$id_base'";
    $connect->query($sql);
    $connect->close();
    header("Location: /");
  }

  if (isset($_POST['delete_hero'])) {
    $connect = new mysqli(SERVER_NAME, DB_LOGIN, DB_PASS, DB_NAME);
    $sql = "DELETE FROM `heroes` WHERE `id` = '$id_base'";
    $connect->query($sql);
    $connect->close();
    header("Location: /");
  }

  ?>
  <form action="#" method="POST">
    <input type="text" name="name" placeholder="name" value="<?= $name; ?>">
    <input type="number" name="age" placeholder="age" value="<?= $age; ?>">
    <input type="number" name="rank" placeholder="rank" value="<?= $rank; ?>">
    <input type="submit" name="add_hero" value="add hero">

    <?php if (isset($_GET['change'])) : ?>
      <input type="submit" name="edit_hero" value="edit hero">
      <input type="submit" name="delete_hero" value="delete hero">
    <?php endif; ?>
  </form>
  <?php
  foreach ($user as $k => $v) {
    echo "<p style='margin-bottom:10px'>$v[id] | $v[name] | age: $v[age] | rank: $v[rank] 
    <a href='?change=$k'>Select</a>
    </p>";
  }





  ?>
  <script src="./script.js"></script>
</body>

</html>