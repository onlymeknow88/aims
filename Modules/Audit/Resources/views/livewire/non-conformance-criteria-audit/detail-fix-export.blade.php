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
           
                color: black;
                width:100%;
            }

            table {
                border-spacing:0; /* Removes the cell spacing via CSS */ 
                border-collapse: collapse;
                margin:5px 0px 5px 0px;
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
            .td-detail{
                border: 1px solid black;
                border-collapse: collapse;
                padding:5px;
                vertical-align:top;
            }
            
            .td-head-detail{
                border: 1px solid black;
                border-collapse: collapse;
                padding:5px;
                vertical-align:top;
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
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table  border=0 style="width:100%" >
                <tr>
                    <td  ><b>Tindak Lanjut Audit</b> </td>
                </tr>
                <tr>
                    <td>
                        <table border=0 width="100%" >
                            <tr>
                                <td class="td-head-detail">Investigasi Akar Permasalahan</td>
                            </tr>
                            <tr>
                                <td class="td-detail">
                                {{strip_tags($non_conformance->root_cause_investigation)}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border=0 width="100%" >
                            <tr>
                                <td class="td-head-detail">Tindakan Perbaikan</td>
                            </tr>
                            <tr>
                                <td class="td-detail">
                                {{strip_tags($non_conformance->fix_action)}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border=0 width="100%" >
                            <tr>
                                <td class="td-head-detail">Bukti</td>
                            </tr>
                            <tr>
                                <td class="td-detail">
                                &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border=0 width="100%" >
                            <tr>
                                <td class="td-detail" style="width:200px"><b>Tanggal Perbaikan</b></td><td class="td-detail"></td>
                            </tr>
                            
                        </table>
                    </td>
                    <td style="padding:5px 5px 5px 0px"></td>
                </tr>
                <tr>
                    <td  ><b>Ulasan Tim Auditor</b> </td>
                </tr>
                <tr>
                    <td>
                        <table border=0 width="100%" >
                            <tr>
                                <td class="td-detail" style="width:200px"><b>Nomor Tindak Lanjut</b></td><td class="td-detail"></td>
                            </tr>
                            
                        </table>
                    </td>
                    <td style="padding:5px 5px 5px 0px"></td>
                </tr>
                <tr>
                    <td>
                        <table border=0 width="100%" >
                            <tr>
                                <td class="td-head-detail">Verifikasi</td>
                            </tr>
                            <tr>
                                <td class="td-detail">
                                &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </main>
    </body>
</html>
 