<?php
    $pagesize = 10;
    $page = 1;
    
    $pattern = "";
    if (isset($_REQUEST['pattern'])){
        $pattern = $_REQUEST['pattern'];
    }
    if (isset($_REQUEST['page'])){
        $page = $_REQUEST['page'];
    }
    if (isset($_REQUEST['pagesize'])){
        $pagesize = $_REQUEST['pagesize'];
    }
    
    $result = array();
    $words = array();
    if ($handle = opendir('.')) {
        while (false !== ($file = readdir($handle))) { 
            if ($file != "." && $file != ".." && stripos($file, ".html")) {
                $content = file_get_contents($file);
                if(preg_match_all($pattern, $content, $matches)){
                    $result[] = $file;
                    $words = array_merge($words, $matches[0]);
                }
            }
        }
        sort($result);
        closedir($handle);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Пример поиска строк в html файлах: /789/ - найдет 789, /[0-9]{1,9}/ - найдет числа. <br><br>
        <form action="index.php" method="get">
            <input name="page" value="<?= $page ?>" type="hidden">
            Поиск: <input name="pattern" value="<?= $pattern ?>">
            <button type="submit">Search</button>

        Файлы:<br><br>
        
        <?php 
            if (count($result)>0){
                $pages = round(count($result) / $pagesize + 1);
                echo "Pages: ";
                for($i=1; $i<=$pages; $i++){
                    echo "<a href='index.php?pattern=".urlencode($pattern)."&page=".$i."&pagesize=".$pagesize."'>".($i)."</a>&nbsp";
                }
                ?>
                &nbsp;&nbsp;&nbsp;Отображать на странице по:
                    <select name="pagesize" onchange="submit();">
                        <option value="10" <?php if ($pagesize == 10) { echo "selected"; } ?> >10</option>
                        <option value="20" <?php if ($pagesize == 20) { echo "selected"; } ?> >20</option>
                        <option value="50" <?php if ($pagesize == 50) { echo "selected"; } ?> >50</option>
                        <option value="100" <?php if ($pagesize == 100) { echo "selected"; } ?> >100</option>
                    </select>
                <?php
                echo "<br><br>";
                
                for($i=($page-1)*$pagesize; $i<$page*$pagesize && $i<count($result); $i++){
                    echo "<a href='$result[$i]'>".$result[$i]."</a><br>";
                }
            }
            else{
                echo("Не найдены файлы при таком запросе");
            }
        ?>

        <br><b>Совпадения:</b><br>
        
        <?php 
            if (count($words)>0){
                    echo "<br>";
                
                foreach($words as $word){
                    echo $word."<br>";
                }
            }
            else{
                echo("Не найдены строки при таком запросе");
            }
        ?>
        </form><br>
    </body>
</html>
