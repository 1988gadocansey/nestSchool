@extends('layouts.printlayout')

@section('content')
<style>
    @page {
  size: A4;
}
    body{
        background-image:url("{{url('public/assets/img/background.jpgs') }}");
        background-repeat: no-repeat;
    background-attachment: fixed;
    line-height:1.5;
    }
    .watermark {
 
  position:absolute;
overflow:hidden;
}

.watermark::after {
  content: "";
 background:url();
  opacity: 0.2;
  top: 0;
  left: 30;
  bottom: 0;
  right: 0;
  position: absolute;
  z-index: -1;   
   background-size: contain;
  content: " ";
  display: block;
  position: absolute;
  height: 100%;
  width: 100%;
  background-repeat: no-repeat;
}
 @media print {
    .watermark {
      display: block;
      table {float: none !important; }
  div { float: none !important; }
    }
    .uk-grid, to {display: inline !important} s
    #page1	{page-break-before:always;}
	.condition	{page-break-before:always;}
	#page2	{page-break-before:always;}
        .school	{page-break-before:always;}
	.page9	{page-break-inside:avoid; page-break-after:auto}
	 a,
  a:visited {
    text-decoration: underline;
  }
  body{font-size: 14px}
  size:A4;
  a[href]:after {
    content: " (" attr(href) ")";
  }

  abbr[title]:after {
    content: " (" attr(title) ")";
  }

   
  a[href^="javascript:"]:after,
  a[href^="#"]:after {
    content: "";
  }
.uk-grid, to {display: inline !important}

  }
</style>
 <div align="" style="margin-left:-44px">
      
         <div class="md-card" >
             <div   class="uk-grid" data-uk-grid-margin>
               <div class="uk-grid-1-1 uk-container-center">
                     @inject('sys', 'App\Http\Controllers\SystemController')
                  <?php for ($i = 1; $i <= 1; $i++) {?>

  
                  <table   border="0">
                    <tr>
                      <td width="10">&nbsp;</td>
                      <td width="722"><div align="center" >
                        <div  class=" uk-margin-bottom-remove" >
                            
                            <img src='{{url("public/assets/img/logo.PNG")}}' style="width:100px;height: auto"/>
                            <h3>NIMA MIDDLE SCHOOL - ACCOUNTS OFFICE</h3></div>
                        <span class="uk-text-bold uk-margin-top-remove uk-text-upper">Bill For {{$year}} Academic Year, Term {{$sem}} 
                          </span>
                          <br/>      
                          <br/>
                          @if($sem==3)
                      <span class="uk-text-bold uk-margin-top-remove uk-text-upper">
                                                Next Term Begins: 
                        {!!$sys->nextYear($year)!!}&nbsp;, Term {!!$sys->nextTerm($sem)!!} 
                      </span>
                          @endif
                              
                      </div>
                      <div align="center"></div></td>
                    </tr>
                    </table>
              
                     <table border="1" class="uk-table uk-table-striped">
                             <thead>
                             <th class="uk-text-bold"><b>ACADEMIC DUES</b></th>
                             <th>Amount GHS</th>
                             <th>Total GHS</th>
                             </thead>
                             <tbody>
                                  @foreach($academic as $index=> $row) 

                                <tr align="">
                                    <td>{{$row->description}}</td>
                                    <td>{{$row->amount}} <?php    $total[]=$row->amount;?></td>
                                   
                                </tr>
                                
                                @endforeach
                                <tr>
                                    <td colspan="3">Total Academic Dues<div style="margin-left:645px" class="uk-text-bold uk-text-danger"> <?php echo array_sum($total); ?></div></td>
                                </tr>
                             
                        <th class="uk-text-bold"><b>PTA DUES</b></th>
                             
                             
                            
                              @foreach($pta as $index=> $row) 

                                <tr align="">
                                    <td>{{$row->description}}</td>
                                   <td>{{$row->amount}} <?php    $ptaTotal[]=$row->amount;?></td>
                                </tr>
                                @endforeach
                                 <tr>
                                    <td colspan="3">Total PTA<div style="margin-left:645px" class="uk-text-bold uk-text-danger"> <?php echo array_sum($ptaTotal); ?></div></td>
                                 </tr>
                                
                                
                                 <th class="uk-text-bold"><b>Others</b></th>
                             
                             
                            
                              @foreach($others as $index=> $row) 

                                <tr align="">
                                    <td>{{@$row->description}}</td>
                                   <td>{{@$row->amount}} <?php    @$oTotal[]=$row->amount;?></td>
                                </tr>
                                @endforeach
                                 <tr>
                                    <td colspan="3">Others Total<div style="margin-left:645px" class="uk-text-bold uk-text-danger"> <?php echo @array_sum($oTotal); ?></div></td>
                                </tr
                                <tr> </tr>
                                <tr>
                                    <td colspan="3"><b>Total Bill Payable</b><div style="margin-left:645px" class="uk-text-bold uk-text-primary">GHS <?php echo  number_format((@array_sum($oTotal)+@array_sum($Total)+@array_sum($ptaTotal)), 2, '.', ','); ?></div></td>
                                </tr
                     </tbody>
                         </table>    

                     
                     
 <?php }
?>

                     <div align="center">Signed  Mr: Tettey Agbo Brofonyo (CA)</div>
                    <div class="visible-print text-center" align="center"  >
                            {!! QrCode::size(100)->generate(Request::url()); !!}

                        </div> 
                </div>

         </div>
     </div>
 
 </div>
  
        
 @endsection
 
@section('js')
 <script type="text/javascript">
  
$(document).ready(function(){
 window.print();
//window.close();
});

</script>
  
@endsection