@extends('layouts.printlayout')

@section('content')

 <div align="" style="margin-left: 12px">
      
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
                             </tbody>
                        <th class="uk-text-bold"><b>PTA DUES</b></th>
                             
                             
                            
                              @foreach($pta as $index=> $row) 

                                <tr align="">
                                    <td>{{$row->description}}</td>
                                   <td>{{$row->amount}} <?php    $ptaTotal[]=$row->amount;?></td>
                                </tr>
                                @endforeach
                                 <tr>
                                    <td colspan="3">Total PTA<div style="margin-left:645px" class="uk-text-bold uk-text-danger"> <?php echo array_sum($ptaTotal); ?></div></td>
                                </tr
                         </table>    

                     
                     
 <?php }
?>

                 
                </div>

         </div>
     </div>
 
 </div>
  
        
 @endsection
 
@section('js')
 <script type="text/javascript">
  
$(document).ready(function(){
//window.print();
//window.close();
});

</script>
  
@endsection