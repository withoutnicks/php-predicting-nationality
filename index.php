<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txtName'])) {
  $_name = htmlspecialchars($_POST['txtName']);

  $API_URL = "https://api.nationalize.io/?name=" . urlencode($_name);
  $result = file_get_contents($API_URL);

  if ($result !== false) {
    $data = json_decode($result, true);
  } else {
    $data = null;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./assets/icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@exampledev/new.css@1.1.2/new.min.css">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Predicting the nationality</title>
</head>

<body>
  <h3 class="title">🌎 Predicting the nationality of a single name</h3>
  <form action="index.php" method="post" class="frm">
    <input class="input" type="text" placeholder="Pablo, Juan, Luis..." name="txtName" required autocomplete="off" />
    <button class="">View Probability</button>
  </form>
  <hr />

  <section class="center">
    <?php if (isset($data) && isset($data["name"])) : ?>
      <p>Your search:</p>
      <h4 class="name"><?= htmlspecialchars($data["name"]) ?></h4>
      <table>
        <thead>
          <tr>
            <th>Country</th>
            <th>Probability</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data["country"] as $country) :
            $code_country = htmlspecialchars($country["country_id"]);
            $probability = round($country["probability"] * 100, 2);
          ?>
            <tr>
              <td><img src="https://flagsapi.com/<?= $code_country ?>/flat/32.png"></td>
              <td><?= $probability ?>%</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <small>Search your name for results</small>
    <?php endif; ?>
  </section>

</body>

</html>