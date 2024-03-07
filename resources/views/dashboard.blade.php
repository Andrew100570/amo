<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<div>
    <canvas id="hourlyVisitsChart" width="50" height="50"></canvas>
</div>

<div>
    <canvas id="cityVisitsChart" width="50" height="150"></canvas>
</div>
<script>
    const token = document.head.querySelector('meta[name="csrf-token"]').content;
    function sendDataToServer(data) {
        // Отправляем данные на сервер с помощью AJAX-запроса
        // Замените URL на ваш реальный адрес сервера, куда нужно отправить данные
        fetch('/visit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Data sent successfully:', data);
            })
            .catch(error => {
                console.error('There was a problem with your fetch operation:', error);
            });
    }

    // Функция для получения данных о пользователе
    function getUserData() {
        // Получаем IP-адрес пользователя с помощью стороннего API (например, ipify.org)
        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                const ip = data.ip;

                // Определяем город пользователя с помощью стороннего API (например, ip-api.com)
                fetch(`https://ipapi.co/${ip}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        const city = data.city;

                        // Получаем информацию об устройстве пользователя
                        const device = {
                            userAgent: navigator.userAgent,

                        };

                        // Формируем объект собранных данных
                        const userData = {
                            ip,
                            city,
                            device
                        };

                        // Отправляем данные на сервер
                        sendDataToServer(userData);
                    })
                    .catch(error => {
                        console.error('Error fetching city data:', error);
                    });
            })
            .catch(error => {
                console.error('Error fetching IP address:', error);
            });
    }

    // Вызываем функцию для получения данных пользователя
    getUserData();
    var userTime = '<?php echo json_encode($time); ?>';
    console.log(userTime);

    // Данные для графика посещений по часам
    var hourlyData = {
        labels: userTime,
        datasets: [{
            label: 'Посещения за час',
            data: [10, 12, 15, 17, 18, 20, 22, 23, 25, 27, 20, 32, 33, 20, 5, 15, 15, 10, 10, 30, 20, 20, 20, 20],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    // Создаем график посещений по часам
    var hourlyCtx = document.getElementById('hourlyVisitsChart').getContext('2d');
    var hourlyVisitsChart = new Chart(hourlyCtx, {
        type: 'line',
        data: hourlyData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    var userData = <?php echo json_encode($param); ?>;
    // Данные для круговой диаграммы по городам
    var cityData = {
        //['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань']
        labels: userData,
       // labels: main(),
        datasets: [{
            label: 'Посещения по городам',
            data: [100, 80, 60, 40, 20],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
            ],
            hoverOffset: 4
        }]
    };

    // Создаем круговую диаграмму по городам
    var cityCtx = document.getElementById('cityVisitsChart').getContext('2d');
    var cityVisitsChart = new Chart(cityCtx, {
        type: 'doughnut',
        data: cityData,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Посещения по городам'
                }
            }
        }
    });

    console.log(userData);
</script>
