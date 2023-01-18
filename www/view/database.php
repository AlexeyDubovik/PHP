<h1>Работа с базами данных</h1>
<!-- 
<h2>Настройка СУБД</h2>
<pre>
    При работае с БД обычно на хостинге выдается логин\пароль и готовая БД.
    Поэтому для локальных сайтов желательно создать отдельного пользователя 
    и отдельную БД для каждого из сайтов.

    Подключаемя к СУБД: 
    а) через консоль 
    б) phpmyadmin 
    в) через сторонний софт 
    Создать бд в консоли: 
    Создать пользователя в консоли: 
    GRANT ALL PRIVILEGES ON pv011.* TO pv011_user@localhost 
    IDENTIFIED BY 'pv011_pass'; 
</pre>
<h3>Подключение к бд из PHP</h3> 
-->

<!-- 
    Для работы с бд в PHP есть несколько вариантов:
    набор команд для конкретной БД (mysql..., ib_...)
    или более современный инструмент - PDO (аналог ADO .NET) 
-->
<!-- 
<pre>
    Выполнение запросов DDL.
    Data Definition Language - язык "разметки" данных: создание
    баз, таблиц и т.д.
    Особенности MySQL:
    нет отдельного типа UUID, он есть функции генераторы
    используем CHAR(36)
    нет N-типов (юникод), кодировка текстовых полей задается
    СHARSET-ом таблицы в целом (либо для каждого поля)
    есть несколько "движков" в рамках MySQL (MyISAM, InnoDB,...) 
    наличие условий IF EXISTS / IF NOT EXISTS позволяющих выполнять
    команду условно 
</pre>
-->
<?php
// $sql = <<<SQL
//     CREATE TABLE IF NOT EXISTS demo(
//         id CHAR(36) NOT NULL PRIMARY KEY,
//         val_int INT,
//         val_str VARCHAR(128)
//     ) Engine = InnoDB, DEFAULT CHARSET = utf8
// SQL;
// try{
//     $connection->query($sql);
//     echo "Table 'demo' OK";
// }
// catch(PDOException $ex){
//     echo $ex->getMessage();
// }
?>

<!-- 
<pre>
    DML - Data Manipulation Language 
</pre> 
-->
<?php
    // $x = random_int(1000, 10000);
    // $s = bin2hex((random_bytes(8)));
    // $sql = "INSERT INTO demo VALUES(UUID(), $x, '$s' )";
    // try{
    //     $connection->query($sql);
    //     echo "INSERT 'demo' OK";
    // }
    // catch(PDOException $ex){
    //     echo $ex->getMessage();
    // }
?>

<!-- 
<p>
    DML. SELECT
</p> 
-->

<?php
$offset = 0;
$sql = "SELECT count(*) FROM `demo`";
$res = $_CONTEXT['connection']->query($sql);
$row = $res->fetch();
if($row[0] > 0){
    $sql = "SELECT * FROM `demo` ";// `` (MySQL) - аналог [] (MS SQL)
    //$res = $connection->query($sql); //~table (таблица рез-ов)
    $res = $_CONTEXT['connection']->prepare($sql); 
    // try{
    //     $res->execute();
    //     while($row = $res->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT, $offset)){//строка таблицы
    //         print_r($row); //данные дублируются - по индексу и по имени
    //         //echo "{$row[0]} {$row['val_int']} {$row['val_str']} <br>";
    //         //PDO::FETCH_ASSOC - только с именаи,
    //         //PDO::FETCH_NUM - только с индексами,
    //         //PDO::FETCH_BOTH - дублирование (default)
    //     }; 
    //     $res->closeCursor();
    // }
    // catch(PDOException $ex){
    //     echo $ex->getMessage();
    // } 
    //
    //HOME WORK---------------------------------------------------------------------------------------------
    //
    try{
        $table = "<table class='table table-striped table-dark'><thead><tr><th scope='col'>#</th>";
        //Header of teable
        $res->execute();
        $row = $res->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST, $offset);
        $arr_key = [];
        $arr_index = [];
        foreach($row as $key => $value){
            if(preg_match('/^\+?\d+$/', $key)){
                $arr_index[] = $key;
            }else{
                $arr_key[] = $key;
            }
        }
        if(count($arr_key) > 0){
            foreach($arr_key as $value){
                $table .= "<th scope='col'>$value</th>";
            }
        }else{
            foreach($arr_index as $value){
                $table .= "<th scope='col'>$value</th>";
            }
        }
        $res->closeCursor();
        $table .= "</tr></thead><tbody>";
        //BODY of teable
        $res->execute();
        $count = 1;
        while($row = $res->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT, $offset)){
            $td = "";
            foreach($row as $key => $value)
                $td .= "<td>$value</td>";
            $table .= "<tr><th scope='row'>$count</th>$td</tr>";
            $count += 1;
        }; 
        $res->closeCursor();
        $table .= "</tbody></table>";
        echo $table;
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }
}else{
    echo "Empty tables";
}
?>
        
  


