<div class="container">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Pemenuhan IBPR CCOW
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Pemenuhan IBPR PJA/PJO
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Status IBPR
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt3"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Pemenuhan Bowtie ada/belum
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Pemenuhan IBPR CCOW
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt5"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Penilaian Risiko Awal (K3, LH, KP, KSL, KK, Frekuensi, Tingkat Risiko, Risiko Utama)
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt6"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
@endonce
@push('scripts')
<script>
    var ctx = document.getElementById('shrt').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [{!! implode(', ', $label1) !!}],
        datasets: [{
          label: 'Pemenuhan IBPR CCOW',
          data: [{{ implode(', ', $data1) }}],
          backgroundColor: 'rgb(76,221,192)',
          borderColor: 'rgb(76,221,192)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx2 = document.getElementById('shrt2').getContext('2d');
    var chart2 = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: [{!! implode(', ', $label2) !!}],
        datasets: [{
          label: 'Pemenuhan IBPR PJA/PJO',
          data: [{{ implode(', ', $data2) }}],
          backgroundColor: 'rgb(101,173,255)',
          borderColor: 'rgb(101,173,255)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx3 = document.getElementById('shrt3').getContext('2d');
    var chart3 = new Chart(ctx3, {
      type: 'bar',
      data: {
        labels: [{!! implode(', ', $label3) !!}],
        datasets: [{
          label: 'Status IBPR',
          data: [{{ implode(', ', $data3) }}],
          backgroundColor: 'rgb(255,196,111)',
          borderColor: 'rgb(255,196,111)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx4 = document.getElementById('shrt4').getContext('2d');
    var chart4 = new Chart(ctx4, {
      type: 'bar',
      data: {
        labels: [{!! implode(', ', $label4) !!}],
        datasets: [{
          label: 'Pemenuhan Bowtie ada/belum',
          data: [{{ implode(', ', $data4) }}],
          backgroundColor: 'rgb(255,116,139)',
          borderColor: 'rgb(255,116,139)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx5 = document.getElementById('shrt5').getContext('2d');
    var chart5 = new Chart(ctx5, {
      type: 'bar',
      data: {
        labels: [{!! implode(', ', $label5) !!}],
        datasets: [{
          label: ' Pemenuhan Bowtie PJA/PJO',
          data: [{{ implode(', ', $data5) }}],
          backgroundColor: '#91BA5F',
          borderColor: '#91BA5F',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    function generateRandomRGB() {
        const red = Math.floor(Math.random() * 256); // Random value from 0 to 255
        const green = Math.floor(Math.random() * 256);
        const blue = Math.floor(Math.random() * 256);

        return `rgb(${red}, ${green}, ${blue})`;
    }

    var ctx6 = document.getElementById('shrt6').getContext('2d');
    var chart6 = new Chart(ctx6, {
      type: 'radar',
      data: {
        labels: ['K3', 'LH', 'KP', 'KSL', 'KK', 'Frekuensi', 'Tingkat Risiko', 'Risiko Utama'],
        datasets: [
            @foreach($data6 as $index => $item)
            {
                label: '{{ $item["company_name"] }}',
                data: [{{$item['k3']}}, {{$item['lh']}}, {{ $item['kp'] }}, {{ $item['ksl'] }}, {{ $item['frequency'] }}, {{ $item['level_of_risk'] }}, {{ $item['main_risk'] }}],
                borderColor: generateRandomRGB(),
                borderWidth: 1
             },
            @endforeach
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
</script>
@endpush