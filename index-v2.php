<!--
Neste arquivo index.php, o usuário pode inserir o ano desejado e, após enviar o formulário, 
o calendário para cada mês desse ano será exibido na página. O código PHP no arquivo index.php 
utiliza a função verificadiadoano do código anterior para determinar o dia da semana inicial de cada mês.
-->


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário</title>
    <style>
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
function verificadiadoano($minhadata) {
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

function mostraCalendario($omes, $oano) {
    $mat = [];
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
    echo "</pre>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oano = $_POST["ano"];
    echo "<h1>Calendário para o ano $oano</h1>";
    for ($nummes = 1; $nummes <= 12; $nummes++) {
        $omes = sprintf("%02d", $nummes);
        echo "<h2>Mês: $omes/$oano</h2>";
        mostraCalendario($omes, $oano);
    }
} else {
?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="ano">Informe o ano (ex: 2024): </label>
        <input type="text" id="ano" name="ano">
        <button type="submit">Gerar Calendário</button>
    </form>
<?php
}
?>


</body>
</html>
