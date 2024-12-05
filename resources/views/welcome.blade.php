<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário 2025 - Férias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="output.css" rel="stylesheet">
</head>
<body class="bg-blue-200">
    <div class="container mx-auto px-4 py-8">
        <!-- Exibe o nome do usuário dinâmico -->
        <div class="text-center text-xl font-bold mb-6">
            <h1 id="userNameTitle">Calendário de Férias</h1>
        </div>

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
                        echo "<div onclick='toggleDay($dia, $numeroMes, this)' class='p-2 bg-gray-200 rounded hover:bg-blue-200 cursor-pointer' id='day-$dia'>$dia</div>";
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
                    <th id="userVacationHeader" class="py-2 px-4 text-left font-semibold text-lg">Férias de </th>
                </tr>
            </thead>
                <tbody id="vacationList">
                    <!-- A lista de dias selecionados será exibida aqui -->
                </tbody>
            </table>

            <!-- Botão de confirmação -->
            <div id="confirmationButton" class="mt-4 text-center hidden flex items-center justify-center">
                <span id="confirmationText" class="mr-4">Adicionar esses <span id="vacationCount"></span> dias?</span>
                <button onclick="confirmVacation()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                    Sim, adicionar
                </button>
            </div>

            <!-- Mensagem de seleção -->
            <div id="vacationDisplay" class="mt-4 text-lg font-medium text-center text-green-600">
                Selecione entre 10 e 30 dias para as férias.
            </div>
        </div>
    </div>

    <script>
        // Variável global para o nome do usuário
        let userName = '';

        // Função para pedir o nome do usuário via prompt
        function askUserName() {
            // Solicita o nome do usuário
            userName = prompt('Por favor, digite o seu nome:', 'Felipe');
            // Atualiza o título da página com o nome do usuário
            const userNameTitle = document.getElementById('userNameTitle');
            userNameTitle.textContent = `Calendário de Férias - ${userName}`;

            // Atualiza o cabeçalho da tabela com o nome do usuário
            const userVacationHeader = document.getElementById('userVacationHeader');
            userVacationHeader.textContent = `Férias de ${userName}`;
        }

        // Chama a função askUserName ao carregar a página
        window.onload = askUserName;

        // Inicializa a lista de dias selecionados
        let selectedDays = [];

        // Mapeamento dos meses para as suas iniciais
        const monthInitials = {
            1: 'jan', 2: 'fev', 3: 'mar', 4: 'abr',
            5: 'mai', 6: 'jun', 7: 'jul', 8: 'ago',
            9: 'set', 10: 'out', 11: 'nov', 12: 'dez'
        };

        function toggleDay(day, month, element) {
            // Verifica se o dia já foi selecionado
            const index = selectedDays.findIndex(d => d.day === day && d.month === month);
            if (index === -1) {
                // Adiciona o dia e mês
                selectedDays.push({ day: day, month: month });
                // Altera a cor de fundo para verde imediatamente após o clique
                element.classList.add('bg-green-300');
            } else {
                // Remove o dia
                selectedDays.splice(index, 1);
                // Remove a cor de fundo verde
                element.classList.remove('bg-green-300');
            }

            // Atualiza a exibição das férias
            updateVacationDisplay();
        }

        // Função para atualizar a exibição das férias
        function updateVacationDisplay() {
            const vacationList = document.getElementById('vacationList');
            const confirmationButton = document.getElementById('confirmationButton');
            const confirmationText = document.getElementById('confirmationText');
            const vacationCount = document.getElementById('vacationCount');
    
            // Limpa a lista atual
            vacationList.innerHTML = '';

            // Formata os dias selecionados para exibir na mesma linha, separados por vírgula
            const formattedDays = selectedDays.map(dayObj => `${dayObj.day}/${monthInitials[dayObj.month]}`).join(', ');

            // Exibe os dias na tabela em uma única linha, separados por vírgula
            const listItem = document.createElement('tr');
            listItem.classList.add('border-b');
            listItem.innerHTML = `<td class="py-2 px-4 text-center">${formattedDays}</td>`;
            vacationList.appendChild(listItem);

            // Exibe ou esconde o botão de confirmação dependendo do número de dias selecionados
            if (selectedDays.length >= 10) {
                vacationCount.textContent = selectedDays.length;
                confirmationButton.classList.remove('hidden');
            } else {
                confirmationButton.classList.add('hidden');
            }
        }

        // Função de ação para adicionar os dias selecionados
        function confirmVacation() {
            alert(`${userName}, suas férias foram adicionadas!`);
            // Aqui você pode adicionar qualquer lógica que quiser para salvar a seleção, por exemplo, enviar para o servidor
        }
    </script>
</body>
</html>
