
<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);



### PDO CONNECTION
    //$host = "127.0.0.1";
    $host = "mysqlservice";
    $db = 'test';
    $user = "";
    $pass = "";
    $charset = "utf8mb4";


    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
    ];


    try {

        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (Exception $e) {

        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }


    var_dump($pdo);

### PDO RUNNING QUERIES
    $stmt = $pdo->query('SELECT name FROM users');


    while ($row=$stmt->fetch())
    {

        echo $row['name']."\n";

    }


    ### PDO prepared statements


    $email="fantomx1@gmail.com";
    $status="1";

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email =? AND status=?');
    $stmt->execute([$email, $status]);
    $user = $stmt->fetch();


    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND status=:status");
    $stmt->execute(['status'=>$status, 'email'=>$email]);
    $user = $stmt->fetch();

    var_dump($user);


    // bindParam, bindValue bindings

    ### PDO prepared statements multiple execution

    $data = [
      1 => 1000,
      5 => 300,
      9 => 200,
    ];

    $stmt = $pdo->prepare("UPDATE users SET bonus = bonus + ? WHERE id = ?");

    foreach ($data as $id => $bonus)
    {

        $stmt->execute([$bonus, $id]);

    }

### Getting data out of statement. foreach()

    $stmt = $pdo->query("SELECT name FROM users");

    foreach ($stmt as $row)
    {

        echo $row['name'] . "\n";

    }



### Getting data out of statement. fetch()

include "News.php";


$news = $pdo->query("SELECT * FROM news")->fetchAll(PDO::FETCH_CLASS, "News");

var_dump($news);
