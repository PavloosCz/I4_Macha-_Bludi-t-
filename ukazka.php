<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style> //nastavení stylu aby vygennerované bludiště přehledné. 
            table {
                border-spacing: 0px;
            }
            tr {
                border: none;
                padding: 0;
            } 
            td {
                height: 50px;
                width: 50px;
                color: red;
                border: none;
                padding: 0;
            }
            .z {
                background-color: black;
            }
            .c {
                background-color: greenyellow;
            }
        </style>
    </head>
    <body>
        <?php
        require 'bludiste.php'; // načtení třídy
        $bl = new bludiste(11, 11); // nastavení velikosti blidiště
        echo $bl; // vyspání bludiště 
        ?>
    </body>
</html>
