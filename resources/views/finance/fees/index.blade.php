@extends('layouts.app')


@section('style')

@endsection
@section('content')

<div class="md-card-content">
    @if(Session::has('success'))
    <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
        {!! Session::get('success') !!}
    </div>
    @endif

    @if(Session::has('error'))
    <div style="text-align: center" class="uk-alert uk-alert-danger" data-uk-alert="">
        {!! Session::get('error') !!}
    </div>
    @endif

</div>
<div style="">
    <div class="uk-margin-bottom" style="margin-left:700px" >

        <button class="md-btn md-btn-success md-btn-small" data-uk-modal="{target:'#modal_overflow'}">Click me for help</button>
        <div id="modal_overflow" class="uk-modal">
            <div class="uk-modal-dialog uk-alert uk-alert-info">
                <button type="button" class="uk-modal-close uk-close"></button>
                <h2 class="heading_a">Don't get stack... </h2>
                <p>How to approve or delete created fees?? </p>
                <div class="uk-overflow-container">
                    <h2 class="heading_b">Follow this</h2>
                    <p>1. you can use the filters bellow eg you want all first years fee. select the drop down containing the levels/years and select first years...it applies to all others</p>
                    <p>2. you can now click on approve or delete fee</p>
                    <h2 class="heading_b">Show or Hide columns</h2>
                    <p>1. you can use click on the columns button which is automatically select as auto meanings show all columns 
                        tick the columns you want to view or show visible here
                    </p>
                    <h2 class="heading_b">Print Table</h2>
                    <p>1.You probably like to print out the fee table for use. this can easily be done by clicking the print button or printer icon
                    </p>
                    <h2 class="heading_b">Export Data</h2>
                    <p>You might want to save the report into excel, word or powerpoint documents... this so easy as
                        click on the export button located at the top and select your desired option
                    </p>
                </div>

            </div>
        </div>
        <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
            </div>
        </div>

        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="md-btn md-btn-small md-btn-success uk-margin-small-top">Export <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown">
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'csv', escape: 'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>

                    <li class="uk-nav-divider"></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'excel', escape: 'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'doc', escape: 'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'powerpoint', escape: 'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                    <li class="uk-nav-divider"></li>

                </ul>
            </div>

            <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>

        </div>

    </div>

</div> <div class="uk-modal" id="new_task">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h4 class="uk-modal-title">Create Bills</h4>
        </div>
                 <form  action="{{url('bill/create')}}"  id="formn" accept-charset="utf-8" method="POST" name="applicationFormn"  v-form>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                  
              <table width="408" border="0" bgcolor="#DDE3FF">
    <tr>
      <td bgcolor="#DDE3FF">Type</td>
      <td bgcolor="#DDE3FF"><select   required=""  name="type" id="type">
        <option  >Academic</option>
        <option > PTA</option>
        <option >Others</option>
      </select></td>
    </tr>
    <tr>
      <td width="133" bgcolor="#DDE3FF">Description</td>
      <td width="265" bgcolor="#DDE3FF"><label>
              <input name="description"required="" type="text" id="descr" size="40" />
      </label></td>
    </tr>
    <tr>
      <td>Amount</td>
      <td><label>
              <input type="text" required="" name="amount" id="amount" />
      </label></td>
    </tr>
    <tr>
      <td>Students</td>
      <td><textarea name="stu" cols="6" rows="2" id="stu"><?php ?></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#DDE3FF">Class</td>
      <td bgcolor="#DDE3FF"><label>
        {!! Form::select('class', 
                            (['' => 'All class'] +$class ), 
                            old("class",""),
                            ['class' => 'md-input','id'=>"parent d",'placeholder'=>'select class'] )  !!}
                     
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#DDE3FF">Academic year</td>
      <td bgcolor="#DDE3FF"><label>
        {!! Form::select('year', 
                            (['' => 'All years'] +$year ), 
                            old("year",""),
                            ['class' => 'md-input','id'=>"parent d",'placeholder'=>'select year'] )  !!}
                     
      </label></td>
    </tr>
     <tr>
      <td>Term</td>
      <td><label>
              <select name="term" id="term" required="">
          <option value="">Select Term</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Form</td>
      <td><label>
        <select name="form" id="form">
          <option value="">Select Form</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
        </select>
      </label></td>
    </tr>
    
    <tr>
      <td>Boarding / Day</td>
      <td><label>
        <select name="stuType"  >
          <option value="">ALL</option>
          <option value="DAY">Day</option>
          <option value="BOARDING">Boarding</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Gender</td>
      <td><label>
        <select name="gender" id="gender">
          <option value="">ALL</option>
          <option value="MALE">Males</option>
          <option value="FEMALE">Females</option>
        </select>
      </label></td>
    </tr>
     
  </table>
                              
                                
                 

            <div class="uk-modal-footer uk-text-right">
               <input type="submit" value="Save" id='save'  class="md-btn   md-btn-success uk-margin-small-top">
       <button type="button" class="md-btn md-btn-flat uk-modal-close md-btn-wave">Close</button>
            </div>
        </form>
    </div>
</div>
<!-- filters here -->
@inject('fee', 'App\Http\Controllers\FeeController')
@inject('sys', 'App\Http\Controllers\SystemController')
   <h5>Proposed Fees</h5>  
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">

            <form action=""  method="get" accept-charset="utf-8" novalidate id="group">
                {!!  csrf_field()  !!}
                <div class="uk-grid" data-uk-grid-margin="">

                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('classes', 
                            (['' => 'All classes'] +$class ), 
                            old("classes",""),
                            ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select class'] )  !!}
                        </div>
                    </div>
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('type', 
                            (['' => 'All Bill types'] +$type ), 
                            old("type",""),
                            ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select bill type'] )  !!}
                        </div>
                    </div>
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">

                            {!!  Form::select('forms', array( '1'=>'Form 1s','2' => 'Form 2s', '3' => 'Form 3s','4'=>'Alumni' ), null, ['placeholder' => 'select forms','id'=>'parent','class'=>'md-input parent'],old("form","")); !!}

                        </div>
                    </div>

                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('year', 
                            (['' => 'Select Academic Year'] +$year ), 
                            old("year",""),
                            ['class' => 'md-input parent','id'=>"parent"] )  !!}
                        </div>

                    </div>
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">

                            {!!  Form::select('term', array( '1'=>'Ist term','2' => '2nd Term', '3' => '3rd Term'), null, ['placeholder' => 'select term','id'=>'parent','class'=>'md-input parent'],old("term","")); !!}

                        </div>
                    </div>

                </div>








            </form> 
        </div>
    </div>
</div>
<form action="{{url('/update/bills')}}" method="POST">
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">
         
    {!!  csrf_field()  !!}

            <div class="uk-overflow-container">
                <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>

                <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">                     <thead>
                    <thead>
                        <tr>
                          
                            <th>No</th>
                            <th>Bill Name</th> 
                            <th>Description</th> 
                            <th >Amount</th>
                            
                            <th>Forms</th>
                            <th>Gender</th>
                            <th >Student Type</th>
                            <th >Year</th>
                            <th >Term</th>
                            
                            <th>Total Student</th>
                            <th>Propose Amount</th>




                            <th>Applied</th>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $index=> $row) 
                    <input name="id[]" type="hidden" value="{{$row->id}}"/>
                        <tr align="">
                              <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>

                            <td><select     name="type[]" id="type" >
                  <option value="" >ALL</option>
                  <option <?php if($row->type=='Academic'){echo 'selected="selected"';}?> >Academic</option>
                  <option <?php if($row->type=='PTA'){echo 'selected="selected"';}?>> PTA</option>
                  <option <?php if($row->type=='Others'){echo 'selected="selected"';}?>>Others</option>
                </select></td> 
                <td><input name="description[]" type="text" value="{{ @$row->description }}"/></td>
                <td><span class="uk-text-primary uk-text-bold"><input type="text" name="amount[]" value="{{ @$row->amount}}"/></span></td>
                            
                             <td> <select name="forms[]"  >
                    <option value="">ALL</option>
                    <option <?php if($row->forms=="1"){echo 'selected="selected"';} ?>>1</option>
                    <option <?php if($row->forms=="2"){echo 'selected="selected"';} ?>>2</option>
                    <option <?php if($row->forms=="3"){echo 'selected="selected"';} ?>>3</option>
                    <option <?php if($row->forms=="4"){echo 'selected="selected"';} ?>>4</option>
                  </select></td>
                  <td>
                      <select  name="sex[]" id="sex">
                    <option value="" >ALL</option>
                    <option  value="Female" <?php if($row->sex=='Female'){echo 'selected="selected"';}?>>Female</option>
                    <option value="Male" <?php if($row->sex=='Male'){echo 'selected="selected"';}?>>Male</option>
                  </select>
                  </td>
                              <td> <select name="stuType[]" id="stuTYP">
                    <option value="">ALL</option>
                    <option <?php if($row->stuType=="Day"){echo 'selected="selected"';} ?>>Day</option>
                    <option <?php if($row->stuType=="Boarding"){echo 'selected="selected"';} ?>>Boarding</option>
                  </select></td>
                               <td> {{ @$row->year }}</td>
                                <td> {{ @$row->term }}</td>
                                
                            <td style="text-align: center"><span class="uk-text-success uk-text-bold"> {{ @$row->TOTALSTUDENTS }}</span></td>
                            <td style="text-align: center"><span class="uk-text-success uk-text-bold"> GHC {{ @$row->TOTALAMOUNT }}</span></td>

                            
                             
                            <td>     <select name="valid[]" >
                    <option value="0">Select Option</option>
                    <option value="1" <?php if($row->applied=="1"){echo 'selected="selected"';} ?>>Applied</option>
                    <option value="0"<?php if($row->applied=="0"){echo 'selected="selected"';} ?>>Not Applied</option>
                  </select>
                            
                            </td>
                                         
 

                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <div style="margin-left: 950px" class="uk-text-bold uk-text-success"><td colspan=" "> PROPOSED FEES GHC<u> {{$totalProposed}}</u></td></div>

                {!! (new Landish\Pagination\UIKit($data->appends(old())))->render() !!}
            </div>

        </div>
    </div></div>
  <table align="center">
       
        <tr><td><input type="submit" value="Update" id='save'v-show="applicationForm.$valid"  class="md-btn   md-btn-success uk-margin-small-top">
      </td></tr></table>
</form>
    
    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-small md-fab-accent md-fab-wave" href="#new_task" data-uk-modal="{ center:true }">
            <i class="material-icons md-18">&#xE145;</i>
        </a>
    </div>
@endsection
@section('js')


<script type="text/javascript">

    $(document).ready(function () {

        $(".parent").on('change', function (e) {

            $("#group").submit();

        });
    });

</script>
<script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
     $(document).ready(function () {
         $('.parent').select2({width: "resolve"});


     });


</script>
@endsection