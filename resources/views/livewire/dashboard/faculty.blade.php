<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
        Available Faculties
    </h2>

    <div class="flex my-2 space-x-2">
        <x-select class="text-xs w-full" wire:model="selectedDepartment">
            <option value="" selected>All Department</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </x-select>

    </div>

    <div class="max-w-md mx-auto">

        <canvas id="facultyChart" width="50" height="50"></canvas>
    </div>

    {{-- <x-slot name="script"> --}}
    @push('script')
        <script>
            var ctx = document.getElementById('facultyChart');
            var facultyChart = new Chart(ctx, {
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

            window.addEventListener('updateFaculty', event => {

                facultyChart.data.datasets[0].data = event.detail.d;
                facultyChart.update();
            });
        </script>
    @endpush
    {{-- </x-slot> --}}
</div>
