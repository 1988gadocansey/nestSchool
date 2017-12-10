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
 
<h3 class="heading_b uk-margin-bottom">Books</h3>
<div style="" class="">
<!--    <div class="uk-margin-bottom" style="margin-left:910px" >-->
<div class="uk-margin-bottom" style="" >
        
        <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
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
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'csv', escape: 'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>

                    <li class="uk-nav-divider"></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'excel', escape: 'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'doc', escape: 'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'powerpoint', escape: 'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                    <li class="uk-nav-divider"></li>

                </ul>
            </div>
        </div>




        <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>


         <a href="{{url('/books')}}" ><i   title="reload this page" class="uk-icon-refresh uk-icon-medium "></i></a>
        

    </div>
</div>
<!-- filters here -->
 
@inject('sys', 'App\Http\Controllers\SystemController')
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">

            <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                {!!  csrf_field()  !!}
                <div class="uk-grid" data-uk-grid-margin="">

                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            <select placeholder='type courses' style="width: 210px"    name="library" required="required" class= 'md-input parent'v-model='course' v-form-ctrl='' v-select=''>
                                <option value="">--select library --</option>
                                <option value=""selected="">All library</option>
                                @foreach($library as $item)

                                <option value="{{$item->id}}">{{strtoupper($item->name)}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            
                            {!!  Form::select('status', array(''=>'All statuses',"NEW"=>"New","DAMAGE"=>"Damage","BORROWED"=>"Borrowed"), null, ['placeholder' => 'select status','id'=>'parent','class'=>'md-input parent'],old("status","")); !!}

                        </div>
                    </div>
                     
                    

                     <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            
                             {!!  Form::select('by', array('book_title'=>'Search by title','author'=>'Search by author','book_pub'=>'Search by publisher','type'=>'Search by type','category'=>'Search by category','required'=>''), null, ['placeholder' => 'select search type','class'=>'md-input'], old("","")); !!}
                     
                        </div>
                    </div>
                            
                     
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">                            
                            <input type="text" style=" " required=""  name="search"  class="md-input" placeholder="type search here">
                        </div>
                    </div>
                       <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top"> 
                                <button class="md-btn  md-btn-small md-btn-success uk-margin-small-top" type="submit"><i class="material-icons">search</i></button> 
                      
                        </div>
                       </div>
                      
                    </div>
                  

                </div>
  
            </form> 
        </div>
    </div>
 

<!-- end filters -->
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">


            <div class="uk-overflow-container" id='print'>
                <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
                <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
                    <thead>
                        <tr>
                            <th class="filter-false remove sorter-false" >NO</th>
 
                            <th data-priority="6">TITLE</th>
                            <th data-priority="6">AUTHOR</th>
                            <th>PUBLISHER</th>
                            <th>PLACE OF PUBLICATION</th>
                            <th data-priority="">DATE OF PUBLICATION</th>
                            <th data-priority="">EDITION</th>
                            <th data-priority="">COPY N<u>O</u></th>
                            <th data-priority="">CATEGORY</th>
                            <th data-priority="">N<u>O</u> OF COPIES</th>
                            <th data-priority="">ACCENTION N<u>O</u></th>
                            <th data-priority="">ISBN</th>
                            <th data-priority="">COPYRIGHT</th>
                            <th data-priority="">COLLATION</th>
                            <th data-priority="">DATE RECEIVED</th>
                            <th data-priority="">DATE ADDED</th>
                           <th data-priority="">CLASS MARK</th>
                            <th data-priority="">FORMAT</th>
                            <th data-priority="">SERIES</th>
                           <th data-priority="">TYPE</th>
                           <th data-priority="">LOCATION</th>
                           <th data-priority="">STATUS</th>
                            <th colspan="2" class="filter-false remove sorter-false uk-text-center" data-priority="1">ACTION</th>   
                           
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $index=> $row) 




                        <tr align="">
                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                            <td> {{ strtoupper(@$row->book_title) }}</td>
                           <td> {{ strtoupper(@$row->author)}}</td>
                           <td> {{ strtoupper(@$row->book_pub)}}</td>
                            <td> {{ strtoupper(@$row->place_of_publication) }}</td>           
                             
                            <td> {{ strtoupper(@$row->date_published) }}</td>
                           
                            
                            <td> {{ strtoupper(@$row->edition) }}</td>
                            <td> {{ strtoupper(@$row->copyno) }}</td>
                           
                             <td> {{ strtoupper(@$row->category) }}</td>
                           
                            <td> {{strtoupper( @$row->book_copies) }} </td>
                            
                            <td> {{ strtoupper(@$row->accention_no) }}</td>
                            <td> {{ strtoupper(@$row->isbn) }}</td>
                            <td> {{ strtoupper(@$row->copyright_year) }}</td>
                             <td> {{ strtoupper(@$row->collation) }}</td>
                            <td> {{strtoupper( @$row->date_receive) }}</td>
                            
                            <td> {{ strtoupper(@$row->date_added) }}</td>
                             <td> {{ strtoupper(@$row->class_mark) }}</td>
                             <td> {{ strtoupper(@$row->format) }}</td>
                              <td> {{ strtoupper(@$row->series) }}</td>
                             <td> {{ strtoupper(@$row->type) }}</td>
                             <td> {{ strtoupper(@$row->location) }}</td>
                             <td> {{ strtoupper(@$row->status) }}</td>
                           <td>  <a  href='{{url("edit_book/$row->book_id/id")}}' ><i title='edit book detials' class="md-icon material-icons">edit</i></a> 
                          
                             
                    
                      {!!Form::open(['action' => ['BookController@destroy', 'id'=>$row->book_id], 'method' => 'DELETE','name'=>'myform' ,'style' => 'display: inline;'])  !!}

                                                   <i onclick="UIkit.modal.confirm('Are you sure you want to delete this book?', function(){ document.forms[1].submit(); });" title="click to delete this" class="sidebar-menu-icon material-icons md-18 uk-text-danger">delete</i>
                                                        <input type='hidden' name='item' value='{{$row->book_id}}'/>  
                                                     {!! Form::close() !!}
                 
                             </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
                   {!! (new Landish\Pagination\UIKit($data->appends(old())))->render() !!}
            </div>
        </div>


    </div>
    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-small md-fab-accent md-fab-wave" title="add new library book" href="{{url('book/add')}}"  >
            <i class="material-icons md-18">&#xE145;</i>
        </a>
    </div>
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
         $('select').select2({width: "resolve"});


     });


</script>
<script>
                    $(document).ready(function(){
            $('.send').on('click', function(e){


                    
                    UIkit.modal.confirm("Are you sure every data is accurate?? "
                            , function(){
                            modal = UIkit.modal.blockUI("<div class='uk-text-center'>Send sms to members <br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>");
                                    //setTimeout(function(){ modal.hide() }, 500) })()            
                                    $.ajax({
                                     
                                            type: "POST",
                                            url:"{{url('/sms')}}",
                                            data: $('#form').serialize(), //your form data to post goes 
                                            dataType: "json",
                                    }).done(function(data){
                //  var objData = jQuery.parseJSON(data);
                modal.hide();
                        //                                    
                        //                                     UIkit.modal.alert("Action completed successfully");

                        //alert(data.status + data.data);
                        if (data.status == 'success'){
                $(".uk-alert-success").show();
                        $(".uk-alert-success").text(data.status + " " + data.message);
                        $(".uk-alert-success").fadeOut(4000);
                        // window.location.href="{{url('/members')}}";
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
<script src="assets/js/components_notifications.min.js"></script>
@endsection