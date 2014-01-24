<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rovernetí akce</title>
    </head>
    <body><pre><h1>Budoucí akce</h1><?php
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            $urls = Array();
            $urls[] = "http://www.rovernet.cz/kalendar-akci/events?format=raw&ids=js-1&date-start=0&date-end=33333333333";
            $urls[] = "http://www.rovernet.cz/kalendar-akci/events?format=raw&ids=js-2&date-start=0&date-end=33333333333";
            $urls[] = "http://www.rovernet.cz/kalendar-akci/events?format=raw&ids=js-4&date-start=0&date-end=33333333333";
            $urls[] = "http://www.rovernet.cz/kalendar-akci/events?format=raw&ids=js-5&date-start=0&date-end=33333333333";
            $urls[] = "http://www.rovernet.cz/kalendar-akci/events?format=raw&ids=js-6&date-start=0&date-end=33333333333";
            $urls[] = "http://www.rovernet.cz/kalendar-akci/events?format=raw&ids=js-7&date-start=0&date-end=33333333333";
            
            $arrayAkci = Array();
            
            foreach($urls as $url) {
                //echo $url . "<br /><br />";
                $json = file_get_contents($url);
                $obj = json_decode($json);
                //var_dump($obj);
                foreach($obj as $o) {
                    //var_dump($o);
                    array_push($arrayAkci, Array("nazev" => $o->title, "start" => strtotime($o->start), "konec" => strtotime($o->end), "url" => $o->url));
                    //echo $o->title . "<br />";
                    //echo $o->start . "<br />";
                    //echo $o->end . "<br />";
                    //echo $o->end . "<br />";
                    //echo "<br />";
                }
            }
            
            function sortFunction( $a, $b ) {
                return ($a["start"] - $b["start"]) > 0 ? true : false;
            }
            
            usort($arrayAkci, "sortFunction");
            //var_dump($arrayAkci);
            
            foreach($arrayAkci as $akce) {
                if($akce['start'] > time()) {
                    echo '<a href="http://www.rovernet.cz/' . $akce['url'] . '">' . $akce['nazev'] . '</a> (' . date('j.n.Y H:i:s', $akce['start']) . ' - ' . date('j.n.Y H:i:s', $akce['konec']) . ')<br/>';
                }
            }
            
            echo "<h1>Proběhlé akce</h1>";
            
            function sortFunction2( $a, $b ) {
                return ($b["start"] - $a["start"]) > 0 ? true : false;
            }
            
            usort($arrayAkci, "sortFunction2");
            
            foreach($arrayAkci as $akce) {
                if($akce['start'] < time()) {
                    echo '<a href="http://www.rovernet.cz/' . $akce['url'] . '">' . $akce['nazev'] . '</a> (' . date('j.n.Y H:i:s', $akce['start']) . ' - ' . date('j.n.Y H:i:s', $akce['konec']) . ')<br/>';
                }
            }
        ?>
        </pre>
    </body>
</html>
