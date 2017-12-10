@extends('layouts.app')

 
   
@section('style')
 
        <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 
<style>
    .req{
        color:red;
    }
</style>
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
  @inject('sys', 'App\Http\Controllers\SystemController')
   
 <div align="center">
     <h4 class="heading_b uk-margin-bottom">Fee Payments Section</h4>
  
     <h4 class="uk-text-bold uk-text-danger">Allow pop ups on your browser please!!!!!</h4>
     <p class="uk-text-primary uk-text-bold uk-text-small">Hotlines 0505284060/0243348522(Gad)</p>
  <h5 > Fee Payment  for {!! $sem !!} Semester  | {!! $year !!} Academic Year</h5>
             <hr>
             
           
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-2">
                       <div class="md-card">
                        <div class="md-card-content">
                            <h3 class="heading_a uk-margin-bottom">Accept Payment Here</h3>
                            <form id='form' method="POST" action="{{ url('processPayment') }}" accept-charset="utf-8"   >
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
           
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <div class="parsley-row">
                                    <label for="fullname">Amount Paying<span class="req">*</span></label>
                                    {!! Form::select('bank', 
                                            (['' => 'Select bank account ']+$banks ), 
                                                null, 
                                                ['required'=>'', "id"=>"val_select","data-md-selectize"=>"", 'v-model'=>'bank','v-form-ctrl'=>'','v-select'=>''] )  !!}


                                       
                                </div>
                            </div>
                             <div class="uk-width-medium-1-2">
                                <div class="parsley-row">
                                    <label for="val_select" class="uk-form-label">Payment Type*</label>
                                    <select name="type" id="val_select" required data-md-selectize>
                                        <option value="">Choose..</option>
                                        <option value="Academic">Academic Facility User Fees</option>
                                        <option value="PTA">PTA Fees</option>
                                        <option value="Boarding">Boarding Fees</option>
                                        <option value="other">Other..</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <div class="parsley-row uk-margin-top">
                                    <label for="val_birth">Date of Payment<span class="req">*</span></label>
                                    <input type="text" name="date" id="val_birth" required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)" data-uk-datepicker="{format:'DD-MM-YYYY'}" />
                                </div>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <div class="uk-form-row parsley-row">
                                    <label for="fullname">Update current Class<span class="req">*</span></label>
                                    {!! Form::select('class', 
                                            (['' => 'Select New Class ']+$class ), 
                                                null, 
                                                ['required'=>'', "id"=>"val_select","data-md-selectize"=>"", 'v-model'=>'class','v-form-ctrl'=>'','v-select'=>''] )  !!}

 
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                          <div class="uk-width-medium-1-2">
                                <div class="parsley-row uk-margin-top">
                                    <label for="val_birth">Amount Paid<span class="req">*</span></label>
                                    <input type="text" onkeyup="recalculateSum();"  name="amount" id="pay" required class="md-input"  />
                                </div>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <div class="parsley-row">
                                   <div class="parsley-row uk-margin-top">
                                    <label for="val_birth">Balance</label>
                                    <input type="text" id="amount_left" onkeyup="recalculateSum();" readonly="readonly" name="balance" id="balance"   class="md-input"  />
                                </div>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <div class="parsley-row">
                                   <div class="parsley-row uk-margin-top">
                                    <label for="val_birth">Previous Owings </label>
                                    <input type="text"   name="previous"     class="md-input"  />
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                       <button  v-show="applicationForm.$valid" type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Submit</button>
                    
                  
                            </div>
                        </div>
                    
                        </div>
                    </div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <h3 class="heading_a uk-margin-bottom">Previous Payments</h3>
                            <div class="uk-accordion" data-uk-accordion>
                               <div class="uk-overflow-container" id='print'>
                 <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
               <thead>
                 <tr>
                     <th class="filter-false remove sorter-false"  >No</th>
                      <th>Student</th>
                     <th  style="text-align: ">Class</th>
                     <th>Academic Year</th>
                      
                     <th>Term</th>
                     <th>Amount</th>
                     <th>Payment Type</th>
                     <th>Received By</th>                 
                </tr>
             </thead>
      <tbody>
                                        
                                         @foreach($payment as $index=> $row) 
                                         
                                         
                                        <tr align="">
                                            <td> {{ $payment->perPage()*($payment->currentPage()-1)+($index+1) }} </td>
                                            <td> {{ strtoupper(@$row->student->name) }}</td>
                                            
                                            <td> {{ strtoupper(@$row->classes)	 }}</td>
                                             <td> {{ @$row->year	 }}</td>
                                            <td> {{ @$row->term	 }}</td>
                                            <td>GHS{{ @$row->paid	 }}</td>
                                            <td> {{ @$row->type	 }}</td>
                                             <td> {{ @$row->staff->name	 }}</td>
                                          
                                        </tr>
                                            @endforeach
                                    </tbody>
                                    
                             </table>
           
     </div>
                            </div>
                        </div>
                    </div>
                 
                </div>
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content uk-margin-bottom">
                            <h3 class="heading_a uk-margin-bottom">Student Profile</h3>
                            <div class="uk-accordion" data-uk-accordion="{ collapse: false }" data-accordion-section-open="3,4">
                                       <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                            <td  align=""> <div  align="right" >Receipt No:</div></td>
                                        <td class="uk-text-bold">
                                            {{ $receipt}}
                                            <input type="hidden" name="receipt"   value="{{ $receipt}}" />
                                            <input type="hidden" name="indexno"   value="{{ $data[0]->indexNo}}" />
                                            
                                        </td>
                                        </tr>
                                            
                                          <tr>
                                            <td  align=""> <div  align="right" >Index Number:</div></td>
                                            <td class="uk-text-bold">
                                            {{ $data[0]->indexNo}}
                                               <input type="hidden" name="currentClass"   value="{{ $data[0]->currentClass}}" />
                                            
                                        </td>
                                        </tr>
                                      
                                        <tr>
                                            <td  align=""> <div  align="right" >Full Name:</div></td>
                                        <td class="uk-text-bold">
                                            {{ $data[0]->name}}
                                            
                                        </td>
                                        </tr>
                                        <tr>
                                            <td  align=""> <div  align="right" >Class:</div></td>
                                        <td class="uk-text-bold">
                                            {{ $data[0]->currentClass}}
                                              
                                        </td>
                                        </tr>
                                         
                                       
                                        <tr>
                                            <td  align=""> <div  align="right" class="uk-text-danger">Term Bills:</div></td>
                                        <td class="uk-text-bold">
                                          GHS  {{ $data[0]->termBill}}
                                           
                                        </td>
                                        </tr>
                                          
                                        <tr>
                                            <td  align=""> <div  align="right" class="uk-text-danger">Total School Fees:</div></td>
                                        <td class="uk-text-bold">
                                          GHS  {{ $data[0]->totalOwing}}
                                            <input type="hidden" id="bill" onkeyup="recalculateSum();" name="total" value="{{$data[0]->totalOwing}}"/>
                                      
                                        </td>
                                        </tr>
                                          
                                         
                                         <tr>
                                            <td  align=""> <div  align="right" class="uk-text-primary">Academic Owings: </div></td>
                                        <td class="uk-text-bold">
                                          GHS  {{  $data[0]->academicBillOwing}}
                                           <input type="hidden" id="academic" onkeyup="recalculateSum();" name="academic" value="{{$data[0]->academicBillOwing}}"/>
                                      
                                            </td>
                                        </tr>
                                         <tr>
                                            <td  align=""> <div  align="right" class="uk-text-primary">PTA Owings: </div></td>
                                        <td class="uk-text-bold">
                                          GHS  {{  $data[0]->ptaOwing}}
                                           <input type="hidden" id="pta" onkeyup="recalculateSum();" name="pta" value="{{$data[0]->ptaOwing}}"/>
                                      
                                            </td>
                                        </tr>
                                        @if($data[0]->studentType=="BOARDING")
                                        <tr>
                                            <td  align=""> <div  align="right" class="uk-text-primary">Boarding Owings: </div></td>
                                        <td class="uk-text-bold">
                                          GHS  {{  $data[0]->boardingOwing}}
                                           <input type="hidden" id="boarding" onkeyup="recalculateSum();" name="boarding" value="{{$data[0]->boardingOwing}}"/>
                                      
                                            </td>
                                        </tr>
                                        @endif
                                         <tr>
                                            <td align="" class="uk-text-bold"> <div  align="right" class="uk-text-success">Guardian Phone N<u>o</u>:</div></td>
                                        <td>
                                          
                                            <input type="text" class="md-input" maxlength="10" min="10"  name="phone" value="{{$data[0]->parentPhone}}"/>
                                      
                                        </td>
                                        </tr>
                                        </table>
                                    </td>
                                    <td valign="top">
                                        <img   style="width:150px;height: auto;"  <?php
                                        $pic = $data[0]->indexNo;
                                        echo $sys->picture("{!! url(\"public/albums/students/$pic.jpg\") !!}", 90)
                                        ?>   src='{{url("public/albums/students/$pic.jpg")}}' alt=" student picture here"    />
                                    </td>
                                </tr>
                            </table>
                            
                            
                            
                            </div>
                        </div></form>
                        </div>
                    </div>
                </div>
            </div>
         
 @endsection
 
@section('js')
 
<script>
        $(document).ready(function(){
            $("#form").on("submit",function(event){
                event.preventDefault();
       UIkit.modal.alert('Processing Fee Payments.Please wait.....');
         $(event.target).unbind("submit").submit();
    
                        
            });
            
    
                    
    
    });
</script>
  
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
             
 </div>
  
 @endsection
 
@section('js')
 <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>
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