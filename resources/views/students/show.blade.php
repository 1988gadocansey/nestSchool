@extends('layouts.printlayout')


@section('style')
<style>
     @media print {
	#page1	{page-break-before:always;}
	.condition	{page-break-before:always;}
	#page2	{page-break-before:always;}
        #page3	{page-break-before:always;}
       #page4	{page-break-before:always;}
        .school	{page-break-before:always;}
	.page9	{page-break-inside:avoid; page-break-after:auto}
	  }
    .biodata{
        padding: 1px;
    }
    .uk-table td{
        border:none;
    }
    .capitalize{
        font-size: 12px;
        
    }
    strong {
        font-size: 12px;
     
}
</style>
  
@endsection
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">
<div id="page1">
            <center><u><h6 class="heading_c uk-margin-bottom uk-text-bold" >PERSONAL RECORDS OF {{$student->name}}</h6></u></center>

@section('content')
 
     @inject('sys', 'App\Http\Controllers\SystemController')
     <center><h5>BIODATA</h5></center>
     <hr>
     <table ><tr>
         
             <td>
    <table   class="uk-table uk-table-nowrap " >
        
        <tr>
          <td width="210" class="uppercase" align="right"><strong>INDEXNO N<u>O</u>:</strong></td>
          <td width="408" class="capitalize">{{ $student->indexNo }}</td>								
        </tr>
        <tr>
            <td width="210" class="uppercase" align="right"><strong>CLASS:</strong></td>
          
          <td width="408" class="capitalize">{{ $student->currentClass }}</td>
        </tr>
        <tr>
          <td class="uppercase" align="right"><strong>OTHERNAMES:</strong></td>
          <td class="capitalize"><?php echo strtoupper($student->othernames)  ?></td>
        </tr>
         <tr>
          <td class="uppercase" align="right"><strong>SURNAME:</strong></td>
          <td class="capitalize"><?php echo strtoupper($student->surname) ?></td>
        </tr>
        <tr>
          <td class="uppercase" align="right"><strong>AGE</strong>:</td>
          <td class="capitalize"><?php   echo  $student->age ?>yrs</td>
        </tr>
        <tr>
          <td class="uppercase" align="right"><strong>GENDER</strong>:</td>
          <td class="capitalize"><?php   echo strtoupper($student->gender)?></td>
        </tr>
        
        <tr>
          <td class="uppercase" align="right"><strong>PARENT PHONE:</strong></td>
          <td class="capitalize"><?php echo "+233".\substr($student->parentPhone,-9); ?></td>
        </tr>
       
        <tr>
          <td class="uppercase" align="right"><strong>PROGRAMME:</strong></td>
          <td class="capitalize">{!! strtoupper($student->program->name) !!}</td>
          
        </tr>
         
       <tr>
          <td class="uppercase" align="right"><strong>FEES OWING:</strong></td>
          <td class="capitalize">GHC<?php echo  $student->BILL_OWING ?></td>
        </tr>
        <tr>
          <td class="uppercase" align="right"><strong>GRADUATING GROUP</strong></td>
          <td class="capitalize">{!! $student->GRADUATING_GROUP !!}</td>
          
        </tr>
         <tr>
          <td class="uppercase" align="right"><strong>HOUSE</strong></td>
          <td class="capitalize">{!!strtoupper($student->house) !!}</td>
          
        </tr>
        <tr>
          <td class="uppercase" align="right"><strong>SUBJECT COMBINATIONS</strong></td>
          <td class="capitalize">{!! strtoupper($student->subjectCombination) !!}</td>
          
        </tr>
          <tr>
          <td class="uppercase" align="right"><strong>STATUS</strong></td>
          <td class="capitalize">{!!strtoupper($student->status) !!}</td>
          
        </tr>
      </table>
	 		 
             </td>
             <td valign="top" >
                     <img   style="width:150px;height: auto;"  <?php
                                     $pic = $student->indexNo;
                                     echo $sys->picture("{!! url(\"public/albums/students/$pic.jpg\") !!}", 90)
                                     ?>   src='{{url("public/albums/students/$pic.jpg")}}' alt="  Affix student picture here"    />
             </td>
   
         </tr>
     </table>
     <fieldset class=""><legend class="uk-text-bold heading_c">LOCATION DATA</legend>
      <table>
          <tr>
              <td>
                  <table>
                      <tr>
                        <td class="uppercase" ><strong>HOMETOWN:</strong></td>
                        <td class="capitalize">{!! strtoupper($student->hometown) !!}</td>

                      </tr>
                      <tr>
                        <td class="uppercase"><strong>CONTACT ADDRESS</strong></td>
                        <td class="capitalize">{!! strtoupper($student->address) !!}</td>

                      </tr>
                      
                  </table>
              </td>
              <td>
                  <table>
                  <tr>
                        <td class="uppercase"><strong>NATIONALITY</strong></td>
                        <td class="capitalize">{!! strtoupper($student->nationality )!!}</td>

                      </tr>
                       <tr>
                        <td class="uppercase"><strong>RELIGION</strong></td>
                        <td class="capitalize">{!! strtoupper($student->religion) !!}</td>

                      </tr>
                  </table>
              </td>
              <td>
                <table>
                    <tr>
                        <td class="uppercase"  ><strong>RESIDENTAL STATUS:</strong></td>
                        <td class="capitalize">{!! strtoupper($student->studentType) !!}</td>

                      </tr>
                      <tr>
                        <td class="uppercase"  ><strong>HOMETOWN REGION</strong></td>
                        <td class="capitalize">{!! strtoupper($student->religion) !!}</td>

                      </tr>
                </table>
                  
                      
              </td>
              <td>
               
              </td>
          </tr>
      </table>
       
        </fieldset>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
     <fieldset class=""><legend class="uk-text-bold heading_c">GUARDIAN DATA</legend>
      <table>
          <tr>
              <td>
                  <table>
                      <tr>
                        <td class="uppercase" ><strong>GUARDIAN NAME:</strong></td>
                        <td class="capitalize">{!! strtoupper($student->parentName) !!}</td>

                      </tr>
                      <tr>
                        <td class="uppercase"><strong>GUARDIAN ADDRESS</strong></td>
                        <td class="capitalize">{!! strtoupper($student->parentAddress) !!}</td>

                      </tr>
                       
                  </table>
              </td>
              <td>
                <table>
                    <tr>
                        <td class="uppercase"  ><strong>GUARDIAN PHONE:</strong></td>
                        <td class="capitalize">{!! strtoupper($student->parentPhone) !!}</td>

                      </tr>
                      <tr>
                        <td class="uppercase"  ><strong>GUARDIAN OCCUPATION</strong></td>
                        <td class="capitalize">{!! strtoupper($student->parentOccupation) !!}</td>
                        <td class="uppercase"  ><strong>RELATIONSHIP WITH GUARDIAN</strong></td>
                        <td class="capitalize">{!! strtoupper($student->parentRelation) !!}</td>

                      </tr>
                       
                </table>
              </td>
          </tr>
          
          
      </table>
       </fieldset>
</div>  @if(!empty($trail))
            <div id="page2">
                 <center><h5>ACADEMIC ISSUES (FLAGS)</h5></center>
                    <hr>
                 
                    <div class="uk-overflow-container" >
                <center><span class="uk-text-success uk-text-bold">{!! $trail->total()!!} Records</span></center>
                <table class="uk-table " id="ts_pager_filter"> 
                    <thead>
                        <tr>
                            <th class="filter-false remove sorter-false" >NO</th>
                            <th data-priority="6">CLASS</th>
                            <th data-priority="6">TERM</th>
                            <th data-priority="6">COURSE</th>
                           
                            <th>GRADE</th>
                            <th>ACADEMIC YEAR</th>

                   
                </tr></thead>
                <tbody>
                    @foreach($trail as $index=> $row) 




                    <tr align="">
                        <td> {{ $trail->perPage()*($trail->currentPage()-1)+($index+1) }} </td>
                        <td> {{ @$row->class }}</td>
                         <td> {{ @$row->term }}</td>
                         <td> {{ strtoupper(@$row->courseMount->course->name) }}</td>
                          
                          <td> {{ @$row->grade }}</td>
                           <td> {{ @$row->year }}</td>

                    </tr>
                    @endforeach
                </tbody>
                </table>
                @else
                <span class="uk-text-success uk-text-bold">NO ACADEMIC ISSUES</span>
                @endif
                    </div>
                 
            </div>
            <P>&nbsp;</P>
                                <div class="visible-print text-center" align='center'>
                                    {!! QrCode::size(100)->generate(Request::url()); !!}

                                </div>
        </div>
    </div>
</div>
@endsection
 