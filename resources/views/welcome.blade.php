<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário 2025 - Férias de Felipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Inicializa a lista de dias selecionados
        let selectedDays = [];

        // Mapeamento dos meses para as suas iniciais
        const monthInitials = {
            1: 'jan', 2: 'fev', 3: 'mar', 4: 'abr',
            5: 'mai', 6: 'jun', 7: 'jul', 8: 'ago',
            9: 'set', 10: 'out', 11: 'nov', 12: 'dez'
        };

        function toggleDay(day, month) {
            // Verifica se o dia já foi selecionado
            const index = selectedDays.findIndex(d => d.day === day && d.month === month);
            if (index === -1) {
                // Adiciona o dia e mês
                selectedDays.push({ day: day, month: month });
            } else {
                // Remove o dia
                selectedDays.splice(index, 1);
            }

            // Atualiza a exibição das férias
            updateVacationDisplay();
        }

        // Função para atualizar a exibição das férias
        function updateVacationDisplay() {
    const vacationList = document.getElementById('vacationList');
    const confirmationButton = document.getElementById('confirmationButton');
    
    // Limpa a lista atual
    vacationList.innerHTML = '';

    // Formata os dias selecionados para exibir na mesma linha, separados por vírgula
    const formattedDays = selectedDays.map(dayObj => `${dayObj.day}/${monthInitials[dayObj.month]}`).join(', ');

    // Exibe os dias na tabela em uma única linha, separados por vírgula
    const listItem = document.createElement('tr');
    listItem.classList.add('border-b');
    listItem.innerHTML = `<td class="py-2 px-4 text-center">${formattedDays}</td>`;
    vacationList.appendChild(listItem);

    // Exibe a mensagem de seleção (sem incluir a string "Férias de Felipe: ...")
    if (selectedDays.length >= 10 && selectedDays.length <= 30) {
        // Não precisa mais dessa linha de exibição
        // vacationDisplay.innerHTML = `Férias de Felipe: ${formattedDays}`;
    } else {
        // Exibe mensagem para selecionar entre 10 e 30 dias
        vacationDisplay.innerHTML = 'Selecione entre 10 e 30 dias para as férias.';
    }

    // Exibe ou esconde o botão de confirmação dependendo do número de dias selecionados
    if (selectedDays.length >= 10) {
        confirmationButton.innerHTML = `Adicionar esses ${selectedDays.length} dias?`;
        confirmationButton.classList.remove('hidden');
    } else {
        confirmationButton.classList.add('hidden');
    }
}


        // Função de ação para adicionar os dias selecionados
        function confirmVacation() {
            alert('Férias de Felipe adicionadas!');
            // Aqui você pode adicionar qualquer lógica que quiser para salvar a seleção, por exemplo, enviar para o servidor
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto px-4 py-8">
    <!-- <h1 class="text-xl font-bold text-center mb-8">Calendário Férias 2025</h1> -->


        <!-- Calendário de 2 linhas com 6 meses por linha -->
        <div class="flex justify-center mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 w-[115%]">
                <?php
                // Gera os meses do ano
                $meses = [
                    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                ];
                
                // Para cada mês, gera o calendário
                foreach ($meses as $numeroMes => $nomeMes) {
                    // Descobrir o primeiro dia do mês
                    $primeiroDia = date('N', strtotime("2025-$numeroMes-01"));
                    // Descobrir o número de dias no mês
                    $diasNoMes = cal_days_in_month(CAL_GREGORIAN, $numeroMes, 2025);

                    echo '<div class="bg-white shadow-md rounded-lg p-4">';
                    echo "<h2 class='text-xl font-bold text-center mb-4'>$nomeMes</h2>";
                    echo '<div class="grid grid-cols-7 gap-1 text-center text-sm font-medium">';
                    
                    // Dias da semana
                    $diasSemana = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];
                    foreach ($diasSemana as $dia) {
                        echo "<div class='text-gray-500'>$dia</div>";
                    }

                    // Espaços vazios para alinhar o primeiro dia do mês
                    for ($i = 1; $i < $primeiroDia; $i++) {
                        echo '<div></div>';
                    }

                    // Dias do mês
                    for ($dia = 1; $dia <= $diasNoMes; $dia++) {
                        echo "<div onclick='toggleDay($dia, $numeroMes)' class='p-2 bg-gray-200 rounded hover:bg-blue-200 cursor-pointer' id='day-$dia'>$dia</div>";
                    }

                    echo '</div>'; // Fecha o grid de dias
                    echo '</div>'; // Fecha o mês
                }
                ?>
            </div>
        </div>

        <!-- Tabela de Férias -->
        <div class="mt-8">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 text-left font-semibold text-lg">Férias de Felipe</th>
                    </tr>
                </thead>
                <tbody id="vacationList">
                    <!-- A lista de dias selecionados será exibida aqui -->
                </tbody>
            </table>

            <!-- Botão de confirmação -->
            <div id="confirmationButton" class="mt-4 text-center hidden">
                <button onclick="confirmVacation()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Adicionar esses 10 dias?
                </button>
            </div>

            <!-- Mensagem de seleção -->
            <div id="vacationDisplay" class="mt-4 text-lg font-medium text-center text-green-600">
                Selecione entre 10 e 30 dias para as férias.
            </div>
        </div>
    </div>
</body>
</html>
