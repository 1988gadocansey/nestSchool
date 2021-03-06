@extends('layouts.app')

 
@section('style')
 
@endsection
 @section('content')
<div class="md-card-content">
<div style="text-align: center;display: none" class="uk-alert uk-alert-success" data-uk-alert="">

    </div>



    <div style="text-align: center;display: none" class="uk-alert uk-alert-danger" data-uk-alert="">

    </div>

    @if (count($errors) > 0)


    <div class="uk-alert uk-alert-danger  uk-alert-close" style="background-color: red;color: white" data-uk-alert="">

        <ul>
            @foreach ($errors->all() as $error)
            <li>{!!$error  !!} </li>
            @endforeach
        </ul>
    </div>

    @endif


</div>
  
 <div style="">
     <div class="uk-margin-bottom" style="margin-left:900px" >
          
         
         <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
        <!--  <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="">Import from Excel</a>
         -->
         <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
             <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
             <div class="uk-dropdown">
                 <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
             </div>
         </div>
         

                       
                          
                           
         <div style="margin-top: -5px" class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                <button class="md-btn md-btn-small md-btn-success uk-margin-small-top">Export <i class="uk-icon-caret-down"></i></button>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown">
                                         <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'csv',escape:'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>
                                           
                                            <li class="uk-nav-divider"></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'excel',escape:'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'doc',escape:'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'powerpoint',escape:'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                                            <li class="uk-nav-divider"></li>
                                           
                                    </ul>
                                </div>
                            </div>
                       
                           
                            
                                                   
                                  <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>
                     <a href="{{url('/teachers/subject/allocation')}}" ><i   title="refresh this page" class="uk-icon-refresh uk-icon-medium "></i></a>
                          
                            
                            
                           
     </div>
 </div>
  
 <div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">
            
                <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('staff', 
                                (['' => 'All Teachers'] +$staff ), 
                                  old("staff",""),
                                    ['class' => 'md-input parent selects','id'=>"parent",'placeholder'=>'select staff'] )  !!}
                         </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                  
                                    {!! Form::select('classs', 
                                (['' => 'All classes'] +$class ), 
                                  old("classs",""),
                                    ['class' => 'md-input parent selects','id'=>"parent",'placeholder'=>'select class'] )  !!}
                      
                            </div>
                        </div>
                       
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                  
                                    {!! Form::select('year', 
                                (['' => 'All academic years'] +$year ), 
                                  old("year",""),
                                    ['class' => 'md-input parent selects','id'=>"parent",'placeholder'=>'select academic year'] )  !!}
                      
                            </div>
                        </div>  
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                
                                {!!  Form::select('term', array(''=>'All terms','1'=>'1st Term','2'=>'2nd Term','3'=>'3rd Term' ), null, ['placeholder' => 'select term','class'=>'md-input selects parent','id'=>"parent"],old("term","")); !!}
                          
                            </div>
                        </div>
                       
                        
                        
                    
                    </div> 
                         
                   
                </form> 
        </div>
    </div>
 </div>
 <h5>Courses</h5>
 <div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">
   <div class="uk-overflow-container" id='print'>
       <form  accept-charset="utf-8" method="POST" id="form" name="applicationForms"  v-form>
                      {!!  csrf_field()  !!}
         <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
                <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
               <thead>
                 <tr>
                     <th class="filter-false remove sorter-false"  >NO</th>
                      <th>COURSE</th>
                     <th  style="text-align:center">CODE</th>
                     <th>PROGRAMME</th> 
                     <th>CLASS</th> 
                     <th style="text-align:">TEACHER</th>
                     <th style="text-align:">PHONE N<u>O</u></th>
                      <th style="text-align:">  DESIGNATION</th>
                     <th style="text-align: ">ACADEMIC YEAR</th>
                      <th style="text-align:center">TERM</th>
<!--                      <th>ACTION</th>             -->
                </tr>
             </thead>
      <tbody>
                                         <?php $count=0;?>
                                         @foreach(@$data as $index=> $row) 
                                         
                                           <?php $count++;?>
                                        <tr align="">
                                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                            <td> {{ strtoupper(@$row->course->name) }}</td>
                                            <td> {{ strtoupper(@$row->course->code)	 }}</td>
                                            <td> {{strtoupper( @$row->course->programme->name)	 }}</td>
                                            <td> {{ @$row->classId	 }}</td>
                                            <input type="hidden" class="classs"name="class[]" value="{{@$row->classId}}"/>
                                            <input type="hidden" class="course"name="subject[]" value="{{@$row->subject}}"/>
                                            <td>
                                                   <select placeholder='select subject teacher' class="selects teacher" style="" name="staff[]"  class= 'md-input'>
                                                    
                                                    @foreach($teacher as $item=>$rows)

                                                   <option <?php
                                                                            if ($rows->emp_number==@$row->teacherId) {
                                                                                echo "selected='selected'";
                                                                            }
                                                                            ?> value="{{$rows->emp_number}}">{{$rows->name }}</option>
                                                 @endforeach
                                                    </select>
                                               
                                              </td>
                                            
                                             <td class=""> {{  @$row->teacher->phone  }}</td>
                                            <td class=""> {{ strtoupper(@$row->teacher->designation) }}</td>
                                           
                                            <td class="">
                                                
                                          
                                                     <select class='md-input selects'  name='year[]'   >
                                         <option value=''>Filter by academic year</option>
                                        
                                             <?php
                                                                            for($i=2000; $i<=2050; $i++){
                                                                                    $a=$i - 1 ."/". $i;?>
                                                                                             <option <?php if($row->year==$a){echo 'selected="selected"'; }?>value='<?php echo $a ?>'><?php echo $a ?></option>";
                                                                             
                                                                                 <?php    } ?>


                                                                     ?>

                                    </select>
                                            </td>
                                            
                                            <td class=" "> 
                                               
                                              <select name="term[]" class="md-input selects">
                                                  <option value="">Select Term</option>
                                                  <option value="1"
                                                          <?php
                                                                            if ($row->term==1) {
                                                                                echo "selected='selected'";
                                                                            }
                                                                            ?>
                                                          >Ist Term</option>
                                                  <option value="2" <?php
                                                                            if ($row->term==2) {
                                                                                echo "selected='selected'";
                                                                            }
                                                                            ?>>2nd Term</option>
                                                   <option value="3"
                                                           <?php
                                                                            if ($row->term==3) {
                                                                                echo "selected='selected'";
                                                                            }
                                                                            ?>
                                                           
                                                           >3rd Term</option>
                                              </select>
                                            </td>
<!--                                              <td>
                                                    
                                                
                                             {!!Form::open(['action' =>['CourseController@destroy', 'id'=>$row->id], 'method' => 'DELETE','name'=>'c' ,'style' => 'display: inline;'])  !!}

                                                      <button type="submit" onclick="return confirm('Are you sure you want to delete  this  course allocation ?')" class="md-btn  md-btn-danger md-btn-small   md-btn-wave-light waves-effect waves-button waves-light" ><i  class="sidebar-menu-icon material-icons md-18">delete</i></button>
                                                        
                                                     {!! Form::close() !!}
                                             
                                          
                                              </td>-->
                                          
                                        </tr>
                                         <input type="hidden" class="key" name="key[]"value="<?php  echo @$row->id ?>"/>
                                            @endforeach
                                    </tbody>
                                    
                             </table>
           {!! (new Landish\Pagination\UIKit($data->appends(old())))->render() !!}
             <center><div style="position: fixed;  bottom: 0px;left: 45%  ">
                        <p>
                            <input type="hidden" class="upper" name="upper" value="{{$count++}}" id="upper" />
                            
                            <button type="button"  class="md-btn md-btn-success md-btn-small updates"><i class="fa fa-save" ></i>Update records</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                                   
                        </p>
                    </div></center>    
       </form>
     </div>
     </div>
<div class="md-fab-wrapper">
        <a class="md-fab md-fab-small md-fab-accent md-fab-wave" href="{{url('/teachers/subject/create')}}"  >
            <i class="material-icons md-18">&#xE145;</i>
        </a>
    </div>
 </div>
</div>
  
@endsection
@section('js')
 
 <script type="text/javascript">
      
$(document).ready(function(){
 
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
  <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
                    $(document).ready(function () {
            $('.selects').select2({width: "resolve"});
            });</script>
<script>
                    $(document).ready(function(){
            $('.updates').on('click', function(e){
  
 
                      
                    UIkit.modal.confirm("Are you sure you want to update the  allocation for this academic year??  " 
                            , function(){
                            modal = UIkit.modal.blockUI("<div class='uk-text-center'>Ok updating teacher subject allocation for the academic year..... <br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>");
                                    //setTimeout(function(){ modal.hide() }, 500) })()            
                                    $.ajax({
                                     
                                            type: "POST",
                                            url:"{{ url('/courses/allocation/update')}}",
                                            data: $('#form').serialize(), //your form data to post goes 
                                            dataType: "json",
                                    }). done(function(data){
                //  var objData = jQuery.parseJSON(data);
                modal.hide();
                        //                                    
                        //                                     UIkit.modal.alert("Action completed successfully");

                        //alert(data.status + data.data);
                        if (data.status == 'success'){
                $(".uk-alert-success").show();
                        $(".uk-alert-success").text(data.status + " " + data.message);
                        $(".uk-alert-success").fadeOut(4000);
                        //window.location.href="{{url('/teachers/subject/allocation')}}";
                }
                else{
                $(".uk-alert-danger").show();
                        $(".uk-alert-danger").text(data.status + " " + data.message);
                        $(".uk-alert-danger").fadeOut(4000);
                }


                });
                            }
                    );
            });
            
             
            });</script>

<script>


//code for ensuring vuejs can work with select2 select boxes
Vue.directive('select', {
  twoWay: true,
  priority: 1000,
  params: [ 'options'],
  bind: function () {
    var self = this
    $(this.el)
      .select2({
        data: this.params.options,
         width: "resolve"
      })
      .on('change', function () {
        self.vm.$set(this.name,this.value)
        Vue.set(self.vm.$data,this.name,this.value)
      })
  },
  update: function (newValue,oldValue) {
    $(this.el).val(newValue).trigger('change')
  },
  unbind: function () {
    $(this.el).off().select2('destroy')
  }
})


var vm = new Vue({
  el: "body",
  ready : function() {
  },
 data : {
       
  
 options: [    ]  
    
  },
   
})

</script>
@endsection