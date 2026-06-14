<div class="chart-card bg-green-op rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Top Five Unsafe Action</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        <div class="chart-items bg-green rounded-3 p-3">
            @livewire(
                'dashboard.components.horizontal-bar-chart', 
                [
                    'idChart'   =>  'unsafeActionBar',
                    'labels'    =>  [
                        'B1-Mengoperasikan alat tanpa izin', 
                        'B2-Mengoperasikan alat melebihi batas kecepatan', 
                        'B3-Menggunakan alat yang tidak lengkap', 
                        'B4-Menggunakan alat yang rusak',
                        'B5-Tidak memakai APD',
                        'B6-Merokok di tempat terlarang',
                        'B7-Membuat peralatan tidak berfungsi',
                        'B8-Tidak memasang alat pelindung',
                        'B9-Bekerja dengan posisi tidak benar',
                        'B10-Bekerja dibawah alkohol'
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
