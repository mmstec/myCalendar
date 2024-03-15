<!--
Neste arquivo index.php, o usuário pode inserir o ano desejado e, após enviar o formulário, 
o calendário para cada mês desse ano será exibido na página. O código PHP no arquivo index.php 
utiliza a função verificadiadoano do código anterior para determinar o dia da semana inicial de cada mês.
-->


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>MMSTEC | MyCalendar </title>
	<meta name="author" content="Marcos Morais">
	<!-- <link rel="stylesheet" href="https://pyscript.net/latest/pyscript.css" />
	<script defer src="https://pyscript.net/latest/pyscript.js"></script> /-->
	<link rel="icon" type="image/ico" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css">
	<link rel="stylesheet" type="text/css" href="css/arjuna.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.login.css">
    <style>
        .error {
			color: #FF0000;
		}
        table, th, td {
            border: 1px solid;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>


    <?php
    function verificadiadoano($minhadata)
    {
        $dd = intval(substr($minhadata, 0, 2));
        $mm = intval(substr($minhadata, 4, 2));
        $aaaa = intval(substr($minhadata, 7, 4));

        $a = intval((12 - $mm) / 10);
        $b = intval($aaaa - $a);
        $c = intval($mm + (12 * $a));
        $d = intval($b / 100);
        $ee = intval($d / 4);
        $f = intval(2 - $d + $ee);

        $g = intval(365.25 * $b);
        $h = intval(30.6001 * ($c + 1));
        $i = intval(($f + $g + $h + $dd) + 5);
        $j = intval($i % 7);

        switch ($j) {
            case 0:
                return "SAB";
            case 1:
                return "DOM";
            case 2:
                return "SEG";
            case 3:
                return "TER";
            case 4:
                return "QUA";
            case 5:
                return "QUI";
            case 6:
                return "SEX";
            default:
                return "Erro ao tentar retornar o dia da semana";
        }
    }

    function mostraCalendario($omes, $oano)
    {
        $mat = array_fill(1, 7, array_fill(1, 7, 0));
        $contador = 1;
        $dia = verificadiadoano("01/" . $omes . "/" . $oano);

        // Preenchendo a matriz
        for ($lin = 1; $lin <= 7; $lin++) {
            switch ($dia) {
                case "DOM":
                    $dia = "ok";
                    $x = 1;
                    break;
                case "SEG":
                    $dia = "ok";
                    $x = 2;
                    break;
                case "TER":
                    $dia = "ok";
                    $x = 3;
                    break;
                case "QUA":
                    $dia = "ok";
                    $x = 4;
                    break;
                case "QUI":
                    $dia = "ok";
                    $x = 5;
                    break;
                case "SEX":
                    $dia = "ok";
                    $x = 6;
                    break;
                case "SAB":
                    $dia = "ok";
                    $x = 7;
                    break;
                default:
                    $x = 1;
            }

            for ($col = $x; $col <= 7; $col++) {
                $mat[$lin][$col] = $contador;
                $contador++;
            }
        }
        
        
        // Escrevendo a matriz
        echo "<pre>";
        echo " -+--+--+--+--+--+--+\n";
        echo " D| S| T| Q| Q| S| S|\n";
        echo " -+--+--+--+--+--+--+\n";
        for ($lin = 1; $lin <= 7; $lin++) {
            for ($col = 1; $col <= 7; $col++) {
                $numdias = cal_days_in_month(CAL_GREGORIAN, intval($omes), intval($oano));
                if ($mat[$lin][$col] <= $numdias && $mat[$lin][$col] != 0) {
                    printf("%2d|", $mat[$lin][$col]);
                } else {
                    echo "   ";
                }
            }
           echo "\n";
        }
     
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        /*$oano = $_POST["ano"];
        $conta = 1;
        echo "<h1>Calendário para o ano $oano</h1>";
        for ($nummes = 1; $nummes <= 12; $nummes++) {
           $omes = sprintf("%02d", $nummes);
           echo "<h2>Mês: $omes/$oano</h2>";            
           mostraCalendario($omes, $oano);
        }*/

        // USANDO DIV para gerar 4 colunas e 3 linhas
        //-----------------------------------------
        $oano = $_POST["ano"];
        $conta = 1;
        echo "<h1>Calendário para o ano $oano</h1>";

        // Abre o container do grid
        echo "<div style=\"display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;\">";

        for ($nummes = 1; $nummes <= 12; $nummes++) {
            $omes = sprintf("%02d", $nummes);

            // Abre uma nova div a cada quarta coluna
            if ($conta % 3 == 1) {
                echo "<div>";
            }

            echo "<h2>Mês: $omes/$oano</h2>";
            mostraCalendario($omes, $oano);

            // Fecha a div a cada quarta coluna
            if ($conta % 3 == 0) {
                echo "</div>";
            }

            $conta++;
        }

        // Fecha o container do grid
        echo "</div>";




        //USANDO UMA TABLE COM 4 COLUNAS E 3 LINHAS
        //-----------------------------------------
        $oano = $_POST["ano"];
        $conta = 1;
        echo "<h1>Calendário para o ano $oano</h1>";

        // Abre a tabela
        echo "<table>";

        for ($nummes = 1; $nummes <= 12; $nummes++) {
            $omes = sprintf("%02d", $nummes);

            // Abre uma nova linha a cada quarta coluna
            if ($conta % 4 == 1) {
                echo "<tr>";
            }

            echo "<td>";
            echo "<h2>Mês: $omes/$oano</h2>";
            mostraCalendario($omes, $oano);
            echo "</td>";

            // Fecha a linha a cada quarta coluna
            if ($conta % 4 == 0) {
                echo "</tr>";
            }

            $conta++;
        }

        // Fecha a tabela
        echo "</table>";

    } else {
        ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="ano">Informe o ANO (ex: 2024): </label>
                <input type="text" id="ano" name="ano">
                <button type="submit">Gerar Calendário</button>
            </form>
        <?php
    }
    ?>


</body>

</html>