<div class="chart-card bg-green-op rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Top Five Unsafe Condition</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        <div class="chart-items bg-green rounded-3 p-3">
            @livewire(
                'dashboard.components.horizontal-bar-chart', 
                [
                    'idChart'   =>  'unsafeConditionBar',
                    'labels'    =>  [
                        'A3-Peringatan atau rambu tidak lengkap', 
                        'A4-Housekeeping tidak baik', 
                        'A7-Temperatur rendah atau tinggi', 
                        'A8-Ventilasi tdak memadai',
                        'A22-Kondisi overhead',
                        'A23-Tidak adanya perlintasan orang yang aman',
                        'A24-Kondisi jalan licin',
                        'A25-Tumpukan barang yang tidak aman',
                        'A26-Hujan/cuaca',
                        'A17-Alat atau system pengaman yang tidak lengkap'
                    ],
                    'datasets'  =>  [
                        [
                            'label' => 'P 01',                                                
                            'backgroundColor'   => '#FFFAD7',
                            'data'  =>  [19, 15, 13, 11, 10, 7, 6, 5, 4, 3],
                        ]
                    ],
                ]
            )
        </div><!-- /.chart-items -->        
    </div><!-- /.chart-content -->

</div><!-- /.chart-card -->