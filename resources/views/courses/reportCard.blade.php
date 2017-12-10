@extends('layouts.printlayout')

@section('content')
@inject('help', 'App\Http\Controllers\SystemController')
<div align="center"  >
    <style>
      
    #report{
       
        
         border-style: solid;
         display: table;
        border-collapse: separate !important;
        border: solid 1px #098ab9 !important;
        line-height: 1.4em;
        border-collapse:separate;
    }
    .write{
        color: #098ab9 !important;
    }
     .say{
        color:#ff0000 !important;
    }
     .gad{
       
        border: #ff9900;
         border-style: solid;
         display: table;
        border-collapse: separate;
        border: solid 1px #098ab9 !important;
        line-height: 1.4em;
        border-collapse:separate;
    }
    
</style>
<style>
    td{
        font-size: 16px
    }
    .biodata{
        border-collapse: collapse;
    border-spacing: 0;
    
    margin-bottom: 15px;
    }
    .biodata td{
        padding:4px;
    }
    .uk-table {
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 15px;
    width:926px;
}


/*.uk-table td{
    border:none;
}
.uk-table th{
    border-collapse: collapse
}*/
        </style>
                 
               

                    {{$student}}
                    
                    {{$grade}}
                    
                    
               

</div>
        @endsection

        @section('js')
        <script type="text/javascript">

        window.print();
 

        </script>

        @endsection