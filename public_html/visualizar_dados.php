<?php
include('header.php');
include('actions/connection.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados de Saúde - Projeto Saúde</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

    <!-- Estilos Personalizados -->
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            height: 250px !important; 
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Consulta para contar os registros e pegar as datas mais recente e mais antiga
    $sqlCount = "SELECT COUNT(*) AS total, MIN(hora) AS primeira_data, MAX(hora) AS ultima_data FROM dados";
    $resultCount = $conn->query($sqlCount);

    // Variáveis para armazenar a quantidade de registros e as datas
    $totalRegistros = 0;
    $primeiraData = null;
    $ultimaData = null;

    if ($resultCount && $resultCount->num_rows > 0) {
        $rowCount = $resultCount->fetch_assoc();
        $totalRegistros = $rowCount['total'];
        $primeiraData = date_format(date_create($rowCount['primeira_data']), 'd/m/Y');
        $ultimaData = date_format(date_create($rowCount['ultima_data']), 'd/m/Y');
    }

    // Exibe o número de registros e o intervalo de datas
    if ($totalRegistros > 0) {
        echo "<div class='alert alert-info text-center'>
                {$totalRegistros} registros encontrados entre {$primeiraData} e {$ultimaData}
              </div>";
    } else {
        echo "<div class='alert alert-warning text-center'>Nenhum registro encontrado</div>";
    }
    ?>

    <!-- Gráficos -->
    <div class="row"> 
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="bpmChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="passosChart"></canvas>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="spo2Chart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <canvas id="stressChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabela de Dados -->
    <div class="table-responsive mb-5">
        <!-- <h2 style="font-size: 20px;" class="text-center">Lista de dados</h2> -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Batimentos por Minuto (BPM)</th>
                    <th>Email</th>
                    <th>Passos</th>
                    <th>Saturação de Oxigênio (SPO2)</th>
                    <th>Estresse</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Inicia os arrays para gráficos
                $horasFormatadas = [];
                $bpm_data = [];
                $passos_data = [];
                $spo2_data = [];
                $stress_data = [];

                // Consulta a tabela de dados, ordenando por hora mais recente
                $sql = "SELECT id, dados, hora FROM dados ORDER BY hora DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Itera sobre os resultados e exibe cada linha
                    while ($row = $result->fetch_assoc()) {
                        $dados = json_decode($row['dados'], true);

                        if (is_array($dados)) {
                            $bpm = $dados['bpm'] ?? 'N/A';
                            $email = $dados['email'] ?? 'N/A';
                            $passos = $dados['passos'] ?? 'N/A';
                            $spo2 = $dados['spo2'] ?? 'N/A';
                            $stress = $dados['stress'] ?? 'N/A';

                            // Popula os arrays para gráficos
                            $horasFormatadas[] = date_format(date_create($row['hora']), 'd/m H:i'); // Hora formatada
                            $bpm_data[] = is_numeric($bpm) ? (int)$bpm : null;
                            $passos_data[] = is_numeric($passos) ? (int)$passos : null;
                            $spo2_data[] = is_numeric($spo2) ? (int)$spo2 : null;
                            $stress_data[] = $stress;

                            // Converte a hora para um formato legível
                            $horaFormatada = date_format(date_create($row['hora']), 'd/m H:i');

                            // E, na exibição da tabela, use $horaFormatada
                            echo "<tr class='text-center'>
                                    <td>{$row['id']}</td>
                                    <td>{$bpm}</td>
                                    <td>{$email}</td>
                                    <td>{$passos}</td>
                                    <td>{$spo2}</td>
                                    <td>{$stress}</td>
                                    <td>{$horaFormatada}</td> 
                                </tr>";
                        } else {
                            echo "<tr class='text-center'>
                                    <td>{$row['id']}</td>
                                    <td colspan='6'>Dados inválidos: {$row['dados']}</td>
                                </tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Nenhum dado encontrado</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript -->
<script>
const horas = <?php echo json_encode($horasFormatadas); ?>.slice(-15); 
const bpmData = <?php echo json_encode($bpm_data); ?>.slice(-15);
const passosData = <?php echo json_encode($passos_data); ?>.slice(-15);
const spo2Data = <?php echo json_encode($spo2_data); ?>.slice(-15);
const stressData = <?php echo json_encode($stress_data); ?>.slice(-15);

// Chart.js Configurações de Gráficos
const config = (label, data, color) => ({
    type: 'line',
    data: {
        labels: horas, // Usando a nova variável de horas formatadas (com os últimos 15)
        datasets: [{
            label: label,
            data: data,
            borderColor: color,
            backgroundColor: color + '88',
            fill: false,
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Hora'
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: label
                }
            }
        }
    }
});

// BPM Chart
new Chart(document.getElementById('bpmChart').getContext('2d'), config('Batimentos por Minuto (BPM)', bpmData, 'blue'));

// Passos Chart
new Chart(document.getElementById('passosChart').getContext('2d'), config('Passos', passosData, 'green'));

// SPO2 Chart
new Chart(document.getElementById('spo2Chart').getContext('2d'), config('Saturação de Oxigênio (SPO2)', spo2Data, 'red'));

// Estresse Chart
const stressMap = {
    'relaxado': 1,
    'normal': 2,
    'tenso': 3
};
const stressNumericData = stressData.map(stress => stressMap[stress] ?? 0);
new Chart(document.getElementById('stressChart').getContext('2d'), config('Estresse', stressNumericData, 'orange'));
</script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
