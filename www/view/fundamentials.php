<h2>Основы языка ПХП</h2>
<h2>Общая хар-ка</h2>
<p>
    Процедурный язык интерпритируемого типа.   
    Типизация - динамическая.
    Есть поддержка ООП.
    Однопоточный
</p>
<h2>
    Переменные
</h2>
<p>
    Переменные появляются в момент первого присваивания
    Имя переменной обязательно начинается с $
    Область переменной - шлобальная, функии свои
    области видимости. Видимость переменной НЕ 
    ограничивается файлом, все подключенные файлы видят
    переменные.
</p>
<p>
    В силу "глобальной" видиммости в подключаемых файлах (всех файлов)
    проверяем не влияем ли мы на переменную.
</p>
<h2>Массивы</h2>
<p>
    Массивы в PHP ассоциативны
</p>
<div style="border:1px solid green">
    <?php
        $x = 20;
        $x += 10;
        $x .= 10;
        if(isset($x)) echo "x already defind";
        else echo "x not defined";
        echo "<br/>";
        $arr = [];      //new style
        $arr = array(); //pold school
        $arr[] = 10;
        $arr[] = 20;
        $arr[] = 30;
        foreach( $arr as $val ) { // for-of (по значениям)
            echo "$val <br/>" ;
        }
        $arr[10] = 'ten'; 
        $arr['five'] = 5;
        $arr[] = 'next';
        $arr['2'] = 200;
        foreach( $arr as $key => $val ) { // for-of (по значениям)
            echo "$arr[$key] = $val <br/>" ;
        }
        $arr3 = [
            'host' => 'localhost',
            'ip'   => '127.0.0.1',
            'auth' => [
                'user' => 'admin',
                'pass' => '123'
            ]
        ];
        echo count($arr3);
        foreach($arr3 as $key => $val){
            if(is_array($val)){
                foreach($val as $k => $v){
                    echo "arr[$key][$k] = $v <br/>" ;
                }
            }
            else{
                echo "arr[$key] = $val <br/>" ;
            }
        }
        const CONST_VALUE = 100500;
        echo CONST_VALUE, '<br/>';
        echo makeHello(), ' ', makeHello("User"), '<br/>';
        function makeHello($user = "Admin"){
            global $x;
            return "Hello $user" . CONST_VALUE . $x;
        }
        //$arr3['auth']['pass']
    ?>
</div>