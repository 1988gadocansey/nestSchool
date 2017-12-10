@extends('layouts.app')


@section('style')
<style>
    .md-card{
        width: auto;

    }
    
</style>
 <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 
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
  <h3 class="heading_c uk-margin-bottom">Upload Marks (Excel file format only)</h3>
        
<div class="uk-width-xLarge-1-10">
    
    <div class="md-card">
        <div class="md-card-content" style="">
 <h3 class="heading_c uk-margin-bottom">Sample Excel <a href="{{url('public/uploads/marks/mark.xlsx')}}">Click to download sample upload template</a></h3>
 
             <form  action="" enctype="multipart/form-data" id="form" accept-charset="utf-8" method="POST" name="applicationForm"  v-form>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
               <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label class="">Term</label>
                                        <p></p>
                     {!!  Form::select('term', array('1'=>'1st term','2'=>'2nd term','3' => '3rd term'), null, ['placeholder' => 'select semester','required'=>'required','class'=>'md-input parent'],old("semester","")); !!}
                               

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
                            <div class="uk-form-row">
                                <label>Class</label>
                                <p></p>
                                        {!! Form::select('class', 
                                ($class ), 
                                  old("classs",""),
                                    ['class' => 'md-input parent ','id'=>"parents",'placeholder'=>'select class'] )  !!}
                      
                            </div>
                            
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Course</label>
                                <p></p>
                                   {!! Form::select('course', 
                                ($courses ), 
                                  old("course",""),
                                    ['class' => 'md-input parent','required'=>"required",'placeholder'=>'select course'] )  !!}
                        
                            </div>
                            <div class="uk-form-row">
                                <label>Excel file only</label>
                                  
                                    
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