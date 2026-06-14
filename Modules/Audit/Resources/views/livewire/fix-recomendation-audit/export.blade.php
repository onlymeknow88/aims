<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            @page {
                margin: 60px 25px 100px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                /* background-color: #000; */
                color: black;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                /* left: 0px;  */
                /* right: 0px; */
                /* height: 50px;  */
                /* font-size: 12px !important; */
                /* font-style: tahoma,arial,verdana; */

                color: black;
                /* text-align: center; */
                /* line-height: 35px; */
                /* border:1px solid blue; */
                width:100%;
            }

            table {
                border-spacing:0; /* Removes the cell spacing via CSS */ 
                border-collapse: collapse;
            }
            table .foot { 
                /* border: 1px solid black  */
            }
            .foot { 
                border: 1px solid black;
                padding-left:10px;
                font-size: 12px;
                font-family: Roboto,Arial, Helvetica, sans-serif;  
                height: 30px;
                vertical-align: middle;
            }
            .table-bd, .th-bd, .td-bd {
                border: 1px solid black;
                border-collapse: collapse;
                padding:5px;
            }
        </style>
    </head>
    <body>
        <header>
            <table border=0 width="100%" >
                <tr>
                    <td style="text-align:right;padding-top:16px" ><img width="100" src="{{public_path('images/adaro-mineral.png')}}" alt="" /></td>
                </tr>
            </table>
        </header>

        <footer>
            <table border=0 width="100%" >
                <tr>
                    <td width="100px" class="foot" >Nama Auditor</td>
                    <td width="150px" class="foot"> {{$audit->auditors[0]->name}}</td>
                    <td width="100px" class="foot" >Tanda Tangan</td>
                    <td width="120px" class="foot"> </td>
                    <td width="80px" class="foot" >Tanggal</td>
                    <td width="100px" class="foot"> {{date('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td class="foot">Nama Auditi</td>
                    <td class="foot">{{-- $confirmances[0]->auditee --}} </td>
                    <td class="foot" >Tanda Tangan</td>
                    <td class="foot"> </td>
                    <td class="foot"  >Tanggal</td>
                    <td class="foot">{{date('d-m-Y')}} </td>
                </tr>
                
            </table>
            <!-- Copyright © <?php echo date("Y");?> - techsolutionstuff.com -->
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        <table  border=0 style="width:100%" >
                        <tr>
                            <td colspan="2" style="text-align:center">
                            FORMULIR REKOMENDASI DAN PELUANG UNTUK PERBAIKAN 
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2 style="text-align:center">
                            PENERAPAN {{strtoupper($audit_category)}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="20%">Nama Perusahaan</td>
                            <td>: {{$audit->company->company_name}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Audit</td>
                            <td>: {{date('d-m-Y',strtotime($audit->start_at))}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" ><b>Uraian Rekomendasi dan Peluang untuk Perbaikan </b></td>
                        </tr>
                        <tr>
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        @foreach($confirmances as $confirmance)
                        <tr>
                            <td colspan="2" >
                            <table border=0 style="width:100%" class="table-bd" >
                                <tr>
                                    <td width="150px" class="td-bd"  style="vertical-align:top">Elemen</td>
                                    <td class="td-bd"> {{$confirmance->audit_sub_criteria->criteria->title}}</td>
                                </tr>
                                <tr>
                                    <td class="td-bd" style="vertical-align:top">Sub Elemen</td>
                                    <td class="td-bd">  
                                    @if($confirmance->audit_sub_criteria->parent)
                                        @if($confirmance->audit_sub_criteria->parent->parent)
                                            @if($confirmance->audit_sub_criteria->parent->parent->parent)
                                            {{$confirmance->audit_sub_criteria->parent->parent->parent->title}}<br>
                                            @endif
                                            {{$confirmance->audit_sub_criteria->parent->parent->title}}<br>
                                        @endif
                                        {{$confirmance->audit_sub_criteria->parent->title}}<br>
                                    @endif
                                    {{$confirmance->audit_sub_criteria->title}}</td>
                                </tr>
                                <tr>
                                    <td class="td-bd" style="vertical-align:top">Rekomendasi dan Peluang untuk Perbaikan</td>
                                    <td class="td-bd">{{strip_tags($confirmance->fix_recommendation)}}</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        @endforeach
                    </table>
        </main>
    </body>
</html>
