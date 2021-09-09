<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
        Rooms
    </h2>
    <div class="flex my-2 space-x-2">
        <x-select class="text-xs w-full" wire:model="selectedRoom">
            <option value="" selected>All Rooms</option>
            @foreach ($allRooms as $_room)
                <option value="{{ $_room->id }}">{{ $_room->name }} ({{ strtolower($_room->roomType->name) }})</option>
            @endforeach
        </x-select>
        <div class="flex items-center">
            <label for="start" class="text-sm w-10" >Start:</label>
            <x-input type="time" class="text-xs" id="start" wire:model.lazy="start" />
        </div>

        <div class="flex items-center">
            <label for="end" class="text-sm w-10" >End:</label>
            <x-input type="time" class="text-xs" id="end" wire:model.lazy="end" />
        </div>
    </div>
    <div class="max-w-md mx-auto">

        <canvas id="myChart" width="50" height="50"></canvas>
    </div>

    <x-slot name="script">
        <script>
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: {!! $labels !!},
                    datasets: [{
                        data: {!! $datasets !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context)
                                {
                                    return context.dataset.data[context.dataIndex].toFixed(3) + "%";
                                }
                            }
                        }
                    }
                }
            });

            window.addEventListener('updateChart', event => {

                myChart.data.datasets[0].data = event.detail.d;
                myChart.update();
            });
        </script>
    </x-slot>
</div>
