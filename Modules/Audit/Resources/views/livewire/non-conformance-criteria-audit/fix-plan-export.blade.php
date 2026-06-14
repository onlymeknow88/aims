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
                vertical-align:top;
                border: 1px solid black;
                border-collapse: collapse;
                padding:5px;
            }

            /* td .footer { border: 1px solid black;padding:5px;margin:0px} */
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
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
                    <td width="150px" class="foot"> 
                        @if(count($audit->auditors) > 0)
                        {{$audit->auditors[0]->name}}
                        @endif
                    </td>
                    <td width="100px" class="foot" >Tanda Tangan</td>
                    <td width="120px" class="foot"> </td>
                    <td width="80px" class="foot" >Tanggal</td>
                    <td width="100px" class="foot"> {{date('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td width="100px" class="foot" >Nama Auditi</td>
                    <td width="150px" class="foot"> 
                        @if(count($non_confirmances) > 0)
                            {{$non_confirmances[0]->auditee}}
                        @endif
                    </td>
                    <td width="100px" class="foot" >Tanda Tangan</td>
                    <td width="120px" class="foot"> </td>
                    <td width="80px" class="foot" >Tanggal</td>
                    <td width="100px" class="foot"> {{date('d-m-Y')}}</td>
                </tr>
            </table>
            
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        <table  border=0 style="width:100%" >
                        <tr>
                            <td colspan="2" style="text-align:center">
                            FORMULIR RENCANA TINDAK LANJUT KETIDAKSESUAIAN AUDIT
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
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
                            <td colspan="2">
                            <table  class="table-bd" style="width:100%" >
                                <thead>
                                    <tr>
                                        <th class="td-bd">
                                            No
                                        </th >
                                        <th class="td-bd" style="width:100px">
                                            Nomor 
                                        </th>
                                        <th class="td-bd">
                                            Deskripsi Ketidaksesuaian
                                        </th>
                                        <th class="td-bd">
                                            Akar Permasalahan
                                        </th>
                                        <th class="td-bd">
                                            Tindakan Koreksi
                                        </th>
                                        <th class="td-bd" style="width:100px">
                                            PJ
                                        </th>

                                        <th class="td-bd" style="width:100px">
                                            Batas Waktu
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($non_confirmances as $confirmance)
                                    <tr>
                                        <td class="td-bd">{{++$startNumber}}</td>
                                        <td class="td-bd">{{$confirmance->non_confirmance_number}}</td>
                                        <td class="td-bd">{{strip_tags($confirmance->problem_description)}}</td>
                                        <td class="td-bd">{{strip_tags($confirmance->root_cause_investigation)}}</td>
                                        <td class="td-bd">{{strip_tags($confirmance->fix_action)}}</td>
                                        <td class="td-bd">{{$confirmance->auditee}}</td>
                                        <td class="td-bd">{{date('d-m-Y',strtotime($confirmance->due_date))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </td>
                        </tr>
                       
                    </table>
        </main>
    </body>
</html>
 