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
            .td-detail{
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
            <!-- Copyright © <?php echo date("Y");?> - techsolutionstuff.com -->
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table  border=0 style="width:100%" >
                <tr>
                    <td colspan="2" style="text-align:center">
                    FORMULIR REKAPITULASI KETIDAKSESUAIAN DAN TINDAK LANJUT KETIDAKSESUAIAN AUDIT
                    </td>
                </tr>
                <tr>
                    <td colspan=2 style="text-align:center">
                    PENERAPAN {{strtoupper($category)}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" >&nbsp;</td>
                </tr>
                <tr>
                    <td width="25%">Nama Perusahaan</td>
                    <td>: {{$audit->company->company_name}}</td>
                </tr>
                <tr>
                    <td>Tanggal Audit</td>
                    <td>: {{date('d-m-Y',strtotime($audit->start_at))}}</td>
                </tr> 
                <tr>
                    <td >Nomor Ketidaksesuaian</td>
                    <td >: {{ $non_conformance->non_confirmance_number}}</td>
                </tr>

                <tr>
                    <td colspan="2" >&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" ><b>Uraian Ketidaksesuaian Audit</b> </td>
                </tr>
                <tr>
                    <td colspan="2" >&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" >
                    <table cellpadding=0 cellspacing=0  style="width:100%" >
                        <tr>
                            <td class="td-detail" width="200px">Uraian Masalah <br>(<i>Problem</i>)</td>
                            <td class="td-detail"> {{strip_tags($non_conformance->problem_description)}}</td>
                        </tr>
                        <tr>
                            <td class="td-detail" width="200px">Area/Lokasi & Departemen <br> (<i>Location</i>)</td>
                            <td class="td-detail"> {{strip_tags($non_conformance->area_location_department)}}</td>
                        </tr>
                        <tr>
                            <td class="td-detail" width="200px">Bukti <br>(<i>Objective Evidence</i>)</td>
                            <td class="td-detail"> {{strip_tags($non_conformance->proof)}}</td>
                        </tr>
                        <tr>
                            <td class="td-detail" width="200px">Referensi Elemen/Sub Elemen <br>(<i>reference</i>)</td>
                            <td class="td-detail"> 
                                @if($non_conformance->audit_sub_criteria->criteria)
                                    {{$non_conformance->audit_sub_criteria->criteria->title}}<br>
                                @endif
                                    @if($non_conformance->audit_sub_criteria->parent)
                                    @if($non_conformance->audit_sub_criteria->parent->parent)
                                        @if($non_conformance->audit_sub_criteria->parent->parent->parent)
                                            
                                            {{$non_conformance->audit_sub_criteria->parent->parent->parent->title}}<br>
                                        @endif
                                        
                                        {{$non_conformance->audit_sub_criteria->parent->parent->title}}<br>
                                    @endif
                                    
                                    {{$non_conformance->audit_sub_criteria->parent->title}}<br>
                                @endif
                                {{$non_conformance->audit_sub_criteria->title}}
                            </td>
                        </tr>
                        @if($category == 'smkp')
                        <tr>
                            <td class="td-detail">Kategori</td>
                            <td class="td-detail"> {{$non_conformance->category}}</td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td class="td-detail" colspan="2">Deskripsi :<br>
                                {{strip_tags($non_conformance->non_confirmance_description)}}</td>
                        </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:5px 5px 5px 0px"><b>Batas Waktu Perbaikan</b></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:1px solid black;padding:5px">
                        {{ date('d-m-Y',strtotime($non_conformance->due_date))}}
                    </td>
                </tr>
                <!-- <tr>
                    <td colspan="2">
                        <b>Tindak Lanjut Audit </b>
                    </td>
                </tr> -->
            </table>
        </main>
    </body>
</html>
 