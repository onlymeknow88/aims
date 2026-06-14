<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            .page-break {
                page-break-after: auto;
            }
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
            .title-doc,
            .header-wrapper{
                margin-bottom: 30px;
                position: relative;
                width: 100%;
            }
            .title-doc div.content-inner,
            .title-doc div.content{
                border:1px solid #ffffff;
            }
            .content-wrapper{
                width: 100%;
                position: relative;
            }
            div.content{
                width: 100%;
                display: block;
                border-collapse: collapse;
                border: 1px solid #333333; 
                position: relative;
            }
            div.content > div{
                display: block;
                padding: 5px;              
            }
            div.content-pdf{
                width: 100%;
                display: block;
                border-collapse: collapse;
                border: 1px solid #333333; 
                position: relative;
            }
            div.content-pdf > div{
                display: block;
                padding: 5px;    
                border: 1px solid #333333;   
                position: relative;                
            }
            div.col-1{
                width:5%;
                float: left;
                page-break-before: auto;
            }
            div.col-2{
                width:20%;
                float: left;
                page-break-before: auto;
            }
            div.col-3{
                width:45%;
                page-break-before: auto;
            }
            div.col-4{
                width:15%;
                page-break-before: auto;
            }
            div.col-5{
                width:15%;
                page-break-before: auto;
            }
            div.label{
                width:300px;
                page-break-inside: auto;
                float: left;
            }
            div.content-inner{
                width:calc(100% - 300px);
                border-left: 1px solid #333333;
                page-break-inside: auto;
                margin-left: 300px;
                
            }
            .header-doc{
                text-align: center;
                font-weight: 700;
                page-break-inside: auto;
            }
            .sub-header-doc{
                font-weight: 600;
                text-align: center;
                page-break-inside: auto;
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
                    <td width="150px" class="foot"> Sarono</td>
                    <td width="100px" class="foot" >Tanda Tangan</td>
                    <td width="120px" class="foot"> </td>
                    <td width="80px" class="foot" >Tanggal</td>
                    <td width="100px" class="foot"> {{date('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td class="foot">Nama Auditi</td>
                    <td class="foot">Sarono </td>
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
            <div>
                <div class="header-wrapper">
                    <div class="header-doc">FORMULIR KESESUAIAN AUDIT</div>
                    <div class="sub-header-doc">PENERAPAN k3</div>
                </div>

                <div class="title-doc">
                    <div class="content">
                        <div class="label">Nama Perusahaan</div>
                        <div class="content-inner">: test nama perusahaan</div>
                    </div>
                    <div class="content">
                        <div class="label">Tanggal Audit</div>
                        <div class="content-inner">: 23 september 2023</div>
                    </div>
                </div>
                
                <div class="content-wrapper five">
                    <div class="content-pdf header">
                        <div class="col-1">No</div>
                        <div class="col-2">Nomor Ketidaksesuaian</div>
                        <div class="col-3">Descripsi Ketidaksesuaian</div>
                        <div class="col-4">Kategori</div>
                        <div class="col-5">Batas Waktu Perbaikan</div>
                    </div>
                    <div class="content-pdf">
                        <div class="col-1">1</div>
                        <div class="col-2">NCR-2023-SMKP-004</div>
                        <div class="col-3">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, maiores. Asperiores est voluptatibus fuga quasi facilis cum tempora iusto, optio enim animi autem, beatae mollitia cumque. Tempore veniam quia ducimus!
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore, maxime praesentium repellat, autem vel sapiente veniam nulla, eum saepe nisi totam itaque nam veritatis voluptatem ab beatae ipsum temporibus facere!
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias, accusamus. Voluptates quibusdam accusamus fuga. Unde dignissimos voluptatibus soluta adipisci, ab est autem, delectus pariatur quo assumenda odit corporis aliquid quia.
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsam aut perferendis, excepturi, sequi quasi velit commodi blanditiis quibusdam voluptatibus consequuntur corrupti ipsum laudantium debitis necessitatibus neque minima, asperiores accusamus eum!
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae debitis provident excepturi distinctio maiores libero assumenda quo porro atque, esse tempore commodi magnam dicta optio! Repudiandae temporibus exercitationem eum dolore!
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum quis harum id ut sint modi libero eius eos sit deserunt iusto, ipsa itaque officiis, dolor, quia amet optio adipisci cumque!
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veritatis ipsa magnam earum, doloremque doloribus autem dolore architecto aspernatur possimus sed quaerat dolor, repellat totam voluptas sapiente sunt alias, non iste?
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae, repellendus eaque earum commodi qui aliquam nulla odio repellat inventore maiores quia temporibus similique minima ipsum neque consectetur possimus quam. Recusandae.
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere perferendis, quasi soluta praesentium ducimus libero beatae mollitia vel quos quibusdam a tempora, sequi magnam voluptates sed enim blanditiis sit quas!
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur voluptas dolorem commodi id amet incidunt saepe, accusamus consectetur aliquid, perferendis est, placeat autem voluptatum nemo ullam unde eveniet deserunt nulla.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et quisquam itaque ipsam, ad ipsa pariatur. Laborum blanditiis perferendis nulla est magni hic alias ipsam. Ipsa, aliquam impedit. Illum, fugiat similique.
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla officiis fuga impedit adipisci cupiditate dicta sint delectus nam vitae debitis. Voluptatem magni cum quod dignissimos porro blanditiis ducimus iste odio?
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatibus cupiditate maiores fugit et dolorum architecto laudantium pariatur excepturi, provident optio recusandae quod. Minima iusto beatae dolorum doloremque sequi vero aut.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus nulla hic unde dolorem? Dolores consequatur itaque ratione rerum sint? Temporibus ut labore aliquid optio at eveniet sapiente cupiditate impedit rerum.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus animi quod voluptates error quia voluptate nostrum commodi atque quo nisi dicta accusantium iure eos magni mollitia, ea rem rerum placeat?
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste sunt illum, quibusdam neque, aperiam maiores accusantium est, qui officia eaque sequi possimus. Id odio odit autem ullam mollitia dignissimos nam.
                        </div>
                        <div class="col-4">Critical</div>
                        <div class="col-5">30-09-2023</div>
                    </div>

                </div>

            </div>    
        </main>
    </body>
</html>
 