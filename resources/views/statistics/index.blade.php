@extends('dashboard')

@section('main-content')
    <div class="container p-5">
        <div class="row">
            <div class="col-4">
                <h1 class="mb-4">Statistiche Generali</h1>
                <p>Qui puoi visualizzare un riepilogo delle statistiche per tutti i tuoi immobili.</p>
            </div>
        </div>
        <div class="row">
            <!-- Grafico a barre delle visite mensili -->
            <div class="mt-5 col-12 col-lg-6 p-3">
                <div class="row">
                    <div class="col-12">
                        <h3>Visite Mensili</h3>
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="col-12">
                        <h3>Messaggi Mensili</h3>
                        <canvas id="messagesBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafico a torta per l'immobile con maggior successo -->
            <div class="mt-5 col-12 col-lg-6 p-3">
                <h3 class="mb-4">Messaggi Ricevuti per Immobile</h3>
                <canvas id="pieChart"></canvas>
            </div>

        </div>

        <!-- Tabella delle statistiche -->
        <div class="table-responsive mt-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titolo</th>
                        <th>Numero di Visite</th>
                        <th>Numero di Messaggi</th>
                        <th>Sponsorizzazioni Attive</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statistics as $stat)
                        <tr>
                            <td>{{ $stat['title'] }}</td>
                            <td>{{ $stat['views'] }}</td>
                            <td>{{ $stat['messages'] }}</td>
                            <td>{{ $stat['active_subscriptions'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inclusione di Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafico a barre delle visite mensili
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: @json($formattedMonths),
                datasets: [{
                    label: 'Numero di Visite',
                    data: @json($monthlyViews->values()),
                    backgroundColor: '#1166e6',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafico a barre dei messaggi mensili
        const messagesBarCtx = document.getElementById('messagesBarChart').getContext('2d');
        const messagesBarChart = new Chart(messagesBarCtx, {
            type: 'bar',
            data: {
                labels: @json($formattedMonths), // Etichette per mese
                datasets: [{
                    label: 'Numero di Messaggi',
                    data: @json($monthlyMessages->values()), // Dati dei messaggi mensili
                    backgroundColor: '#ff6347', // Colore per le barre
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafico a torta dei messaggi ricevuti per immobile
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: @json($pieChartLabels),
                datasets: [{
                    label: 'Messaggi Ricevuti',
                    data: @json($pieChartData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'start', // Posizione della legenda (top/bottom)
                        labels: {
                            padding: 20, // Distanza tra gli item della legenda
                            boxWidth: 20, // Larghezza della casella della legenda
                            boxHeight: 20, // Altezza della casella della legenda
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 20, // Dimensione del font della legenda
                                weight: '' // Peso del font della legenda
                            },
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' messaggi';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
