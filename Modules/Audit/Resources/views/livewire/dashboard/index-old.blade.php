<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-smkp',['id'=>$smkp->id])
</x-slot>

<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <div class="container text-center">
                <h4>PEMENUHAN TERHADAP POIN SMKP</h4>
            </div>
        </div><!-- /.section-title -->

        <div class="content-table">
            <div class="table-wrapper">
                <table class="table table-bordered align-items-center table-sm">
                    <thead class="thead-light text-center bg-warning">
                    <tr class="border-bottom-0">
                        <th rowspan="2">NO</th>
                        <th rowspan="2">ELEMEN</th>
                        <th class="pb-0">
                            POINT MAX
                        </th>
                        <th class="pb-0">
                            BOBOT ELEMEN
                        </th>
                        <th class="pb-0">
                            POINT PEMENUHAN
                        </th>
                        <th class="pb-0">
                            SKOR AUDIT
                        </th>
                        <th class="pb-0">
                            PERSENTASE PEMENUHAN ELEMEN
                        </th>
                    </tr>
                    <tr class="border-top-0">
                        <th class="pt-0">(a)</th>
                        <th class="pt-0">(b)</th>
                        <th class="pt-0">(c)</th>
                        <th class="pt-0">(c/a)xb</th>
                        <th class="pt-0">(c/a)x100</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr>
                        <td>1</td>
                        <td class="text-start">KEBIJAKAN</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="text-start">PERENCANAAN</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-start">ORGANISASI DAN PERSONEL</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="text-start">IMPLEMENTASI</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="text-start">PEMANTAUAN, EVALUASI DAN TINDAK LANJUT</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td class="text-start">DOKUMENTASI</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td class="text-start">TINJAUAN MANAJEMEN DAN PENINGKATAN KINERJA</td>
                        <td>19</td>
                        <td>10%</td>
                        <td>0</td>
                        <td>0%</td>
                        <td>0%</td>
                    </tr>
                    </tbody>
                    <tfoot class="text-center bg-success-subtle">
                    <tr>
                        <th></th>
                        <th class="text-start">TOTAL</th>
                        <th>315</th>
                        <th>10%</th>
                        <th>0</th>
                        <th>0%</th>
                        <th>0%</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div><!-- /.content-table -->

        <div class="content-grafik">

            <div class="container">

                <div class="row justify-content-center mb-4">

                    <div class="col-sm-10">

                        <div class="chart-content">
                            @livewire('chart.chart-radar', $radarChart)
                        </div><!-- /.chart-content -->

                    </div>

                </div><!-- /.row -->

            </div><!-- /.container -->

        </div><!-- /.content -->

    </div><!-- /.section-content -->

</div><!-- /.inner-content -->

