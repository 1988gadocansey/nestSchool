@extends('layouts.app')


@section('style')
<style>
    .md-card{
        width: auto;

    }
    
</style>
 <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 @inject('sys', 'App\Http\Controllers\SystemController')
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
 <h3 class="heading_c uk-margin-bottom">Upload Legacy Grades (Excel file format only) <a href="{{url('public/uploads/marks/mark.xlsx')}}">Click to download sample upload template</a></h3>
        
<div class="uk-width-xLarge-1-10">
    
    <div class="md-card">
        <div class="md-card-content" style="">
 
             <form  action="" enctype="multipart/form-data" id="form" accept-charset="utf-8" method="POST" name="applicationForm"  v-form>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
               <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label class="">Semester</label>
                                        <p></p>
                   {{ Form::select('sem', array(''=>'select semester','1'=>'1', '2'=>'2','3'=>'3'), null, ["required"=>"required",'class' => 'md-input label-fixed','v-model'=>'semester','v-form-ctrl'=>'','v-select'=>'']) }}
                   

                                    </div>
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label>Acadamic year</label>
                                        <p></p>
                     {!! Form::select('year', 
                                ($year ), 
                                  old("year",""),
                                    ['class' => 'md-input parent','required'=>"required",'placeholder'=>'select year'] )  !!}
                                 </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Level</label>
                                <p></p>
                                 {!!  Form::select('level', array('1'=>'1st years','2' => '2nd years', '3' => '3rd years','400/1'=>'BTECH level 1','400/2'=>'BTECH level 2'), null, ['placeholder' => 'select level','required'=>'required','class'=>'md-input parent'],old("level","")); !!}
                            </div>
                                  <div class="uk-form-row">
                                <label>Credit Hours</label>
                                <p></p>
                                 {!!  Form::select('credit', array('1'=>'1','2' => '2', '3' => '3','4'=>'4','5'=>'5','6'=>'6'), null, ['placeholder' => 'select credit hour','required'=>'required','class'=>'md-input parent'],old("credit","")); !!}
                            </div>
                                
                            </div>
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Course</label>
                                <p></p>
                                  <select placeholder='type courses' class="form-control" style="width:490px" name="course" required="required" class= 'md-input'v-model='course' v-form-ctrl='' v-select=''>
                                           <option selected="">type course name here</option>
                                           @foreach($course as $item)
                                        
                                          <option value="{{$item->ID}}">{{$item->COURSE_NAME}} ( {{$sys->getProgramName($item->PROGRAMME)}} {{ $item->COURSE_LEVEL }}yrs/{{$item->COURSE_SEMESTER}}sem)</option>
                                        @endforeach
                                      </select>
                            </div>
                           <div class="uk-form-row">
                                <label>Program</label>
                                <p></p>
                                  {!! Form::select('program', 
                                (['' => 'Select program'] + $program), 
                                    null, 
                                    ["required"=>"required",'class' => 'md-input','v-model'=>'program','v-form-ctrl'=>'','v-select'=>''] )  !!}
                                 
                                 
                                 </div>
                            <div class="uk-form-row">
                                <label>CSV File(csv comma delimited)</label>
                                  
                                    
                            </div>
                             <div class="uk-form-row">
                                 
                               <input type="file"  class="md-input   md-input-success " required=""  name="file"/>
                            </div>
                            
                        </div>
                    </div>
                    <p></p>
                  <table align="center">
       
        <tr><td><input type="submit" value="Upload" id='save'   class="md-btn   md-btn-success uk-margin-small-top">
      <input type="reset" value="Clear" class="md-btn   md-btn-default uk-margin-small-top">
    </td></tr></table>
            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
        $(document).ready(function(){
            $("#form").on("submit",function(event){
                event.preventDefault();
       UIkit.modal.alert('uploading marks...');
         $(event.target).unbind("submit").submit();
    
                        
            });
            
    
                    
    
    });
</script>
<script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
  <script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>   
 
@endsection    