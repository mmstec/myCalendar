<!--
Neste arquivo index.php, o usuário pode inserir o ano desejado e, após enviar o formulário, 
o calendário para cada mês desse ano será exibido na página. O código PHP no arquivo index.php 
utiliza a função verificadiadoano do código anterior para determinar o dia da semana inicial de cada mês.
-->


<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta http-equiv="refresh" content="3;URL='app.php'" />
	
<meta charset="utf-8">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
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
    <form method="post">
        <label for="ano">Informe o ano:</label>
        <input type="text" id="ano" name="ano" required>
        <button type="submit">Gerar Calendário</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        function verificadiadoano($minhadata)
        {
            $dd = intval(substr($minhadata, 0, 2));
            $mm = intval(substr($minhadata, 3, 2));
            $aaaa = intval(substr($minhadata, 6, 4));
            $a = intval((12 - $mm) / 10);
            $b = intval($aaaa - $a);
            $c = intval($mm + (12 * $a));
            $d = intval($b / 100);
            $ee = intval($d / 4);
            $f = intval(2 - $d + $ee);

            $g = intval(365.25 * $b);
            $h = intval(30.6001 * ($c + 1));
            $i = intval(($f + $g) + ($h + $dd) + 5);
            $j = intval($i % 7);

            switch ($j) {
                case 0:
                    $resposta = "SAB";
                    break;
                case 1:
                    $resposta = "DOM";
                    break;
                case 2:
                    $resposta = "SEG";
                    break;
                case 3:
                    $resposta = "TER";
                    break;
                case 4:
                    $resposta = "QUA";
                    break;
                case 5:
                    $resposta = "QUI";
                    break;
                case 6:
                    $resposta = "SEX";
                    break;
                default:
                    $resposta = "Erro ao tentar retornar o dia da semana";
            }
            return $resposta;
        }

        $ano = $_POST["ano"];
    ?>

        <h2>Calendário para o ano de <?php echo $ano; ?></h2>

    <?php
        for ($nummes = 1; $nummes <= 12; $nummes++) {
            if ($nummes < 10) {
                $mes = "0" . $nummes;
            } else {
                $mes = strval($nummes);
            }
            echo "<h3>Mês " . $mes . "</h3>";

            $contador = 1;

            $data = "01/" . $mes . "/" . $ano;
            $dia = verificadiadoano($data);
            $mat = array('');

            // Preenchendo a matriz
            $contador = 1;
            for ($LIN = 0; $LIN < 7; $LIN++) {
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

                for ($COL = $x - 1; $COL < 7; $COL++) {
                    $mat[$LIN][$COL] = $contador;
                    $contador++;
                }
            }

            // Exibindo o calendário
            echo "<table border='1'>";
            echo "<tr><th>D</th><th>S</th><th>T</th><th>Q</th><th>Q</th><th>S</th><th>S</th></tr>";
            for ($LIN = 0; $LIN < 7; $LIN++) {
                echo "<tr>";
                for ($COL = 0; $COL < 7; $COL++) {
                    echo "<td>";
                    if ($mat[$LIN][$COL] <= cal_days_in_month(CAL_GREGORIAN, $nummes, $ano)) {
                        echo $mat[$LIN][$COL];
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>

</html>