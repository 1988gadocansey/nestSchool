<?php

namespace App\Http\Controllers;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models;
use App\User;
use App\Models\AcademicRecordsModel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;

class CourseController extends Controller
{
     
    /**
     * Create a new controller instance.
     *
     
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       
        
    }
     public function bulkReport(SystemController $sys,Request $request){

         
           if ($request->isMethod("get")) {

            return view('courses.bulkReportCard');
                             
            } 
            else{

                $class=  explode(',',$request->input('q'));
                $class=$class[0];
                
              
                
             $sql= Models\ClassModel::where("name",$class)->first();
                     
               
               if(count($sql)==0){
           
                return redirect("/report/card/bulk")->with("error","<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
                }
              else{
                    
                  $array=$sys->getSemYear();
                   
                 
               $data=$this->cardHeaderBulk($sql, $sys)  ;
              //$record=$this->generateCardBulk($sql->id,$sys);
      return view("courses.bulkReport")->with("student",$data);
         
                  
                   
                  
              }
            }

        

    }
    public function cardHeaderBulk($sql, SystemController $sys) {
        $studentSArray=array();
          $array = $sys->getSemYear();
                $sem = $array[0]->term;
                $year = $array[0]->year;
                 $start = $array[0]->startDate;
                   $end= $array[0]->endDate;
                   
           
               $query=    Models\ClassMembersModel::
                join('student', 'student.indexNo', '=', 'classmembers.student')
                 -> join('classes', 'classes.name', '=', 'classmembers.class')
                ->where('classmembers.year',$year)
                ->where('classmembers.term',$sem)
              
                ->where('classmembers.class',$sql->name)
                       ->where('student.currentClass',$sql->name)
                ->orderBy("classmembers.class")->get()->toArray();
                   
                   foreach($query as $row){
                        array_push($studentSArray, $row['student']);
       
                   }
  //  dd($studentSArray);
         
    for($i=0;$i<  count($studentSArray);$i++){
        $indexNo=$studentSArray;
        $student= Models\ClassMembersModel::
                join('student', 'student.indexNo', '=', 'classmembers.student')
                 -> join('classes', 'classes.name', '=', 'classmembers.class')
                ->where('classmembers.year',$year)
                ->where('classmembers.term',$sem)
               
                       ->where('student.indexNo',$indexNo[$i])
                 ->where('student.status','In School')
                ->orderBy("student.indexNo")->first();
        
        ?>
<div class="md-card">
  
        <div   class="uk-grid" data-uk-grid-margin>
            <div class="table-responsive">
                <table  border="0" cellspacing="0" align="center" style=' '>
                        
                        <tr>
                            <th height="341" valign="top" class="bod" scope="row"><table width="100%" border="0">
                            <tr>
                                <th align="center" valign="middle" scope="row"><table  style="margin-left: -29px"width="930" height="113" border="0">
                                <tr>
                                    <th align="center" valign="middle" scope="row">
                               
                                <table style="" width="882" height="113" border="0" >
                                    <tr>
                                       <td align='right'> <img src="<?php echo url('public/assets/img/header.jpg')?>" style=''/></td>
                                              
                                    </tr>
                                     
                                        
                                </table>
                                
                                
                                </tr>


                            </table>
                            
                            <?php  $final= Models\ClassMembersModel::where("term",$sem)
                  ->where("year",$year)
                  ->where("student", $student->indexNo)
                  ->first();?>
                          
                                 <h5 class="heading_a uk-text-bold "><u><b>PUPIL'S TERMINAL REPORT</b></u></h5>
                                 <div style="text-align: left;margin-left: -102px ">
                                    <p style="text-decoration: none"> <span  >Year: &nbsp;&nbsp;&nbsp;<span class="write"> <?php echo $year?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                                        <span >Term: &nbsp;&nbsp;&nbsp;<span class="write"> <?php echo $sem?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                                        <span style="float: right;margin-left: -100px">N<u>o</u> On Roll:&nbsp;&nbsp;&nbsp;   <span class="write"> <?php echo $sys->getClassSize($student->currentClass);?></span></span>
                                        <span style="float: right">Pass Mark: &nbsp;&nbsp;&nbsp;<span class="write">50.0</span><span class="write">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                                    </p>
                                     <p style="text-decoration: none"> <span  >End of Term Exams</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span >Next Term Begins on: &nbsp;&nbsp;&nbsp;<span class="write"> <?PHP echo   $end; ?></span></span>
                                          </p>
                                    
                                </div>
                                 <div  style="margin-left: -73px ">

                                     <table border='0' class=" " align="center"  width='900px' style='text-decoration: none'>
                                         <table >
                                             <tr>
                                                 <td>
                                             <tr>
                                                 <td width="" style="width:69%">
                                                     <center>
                                                         <table border='0' class="biodata" width='800px' width=""  style="margin-left: -34px" >
                                                             <tbody>

                                                             <tr>
                                                                 <td class=" " style=""><b>Name:</b>   &nbsp;&nbsp;&nbsp;&nbsp <span class="write"><?php echo strtoupper(  $student->fullname)?></span></td>
                                                             </tr>


                                                             <tr>
                                                                 <td class=" " style=""><b>Conduct:</b>&nbsp;&nbsp;&nbsp;&nbsp <span class="say"> <?PHP echo   $final->conduct; ?></span></td>
                                                                 <td  class=""><b>Class:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo  strtoupper($student->currentClass) ; ?></span></td>
                                                             </tr>
                                                             <tr>
                                                                 <td  style=""><b>Attitude:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo  $final->attitude  ; ?></span></td>
                                                                 <td style=""><b>Attendance:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   $final->attendance  ; ?></span></td>
                                                             </tr>
                                                             <tr>
                                                                 <td class=" " style=""><b>Interest:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo  $final->interest  ; ?></span></td>
                                                                 <td style=""><b>Total:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   $final->total  ; ?></span></td>
                                                             </tr>



                                                             </tbody>

                                                         </table>
                                                 </td>
                                                 <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                                                 <td valign="top" >
                                                     <img   style="width:150px;height: auto;"  <?php
                                                     $pic = $student->indexNo;

                                                     ?>   src='<?php echo url("public/albums/students/$pic.jpg")?>' alt="  Affix student picture here"    />
                                                 </td>


                                             </tr>
                                         </table>

                                         </center>
                                         </td>


                                         </tr>
                                         </tr>
                                     </table> <!-- end basic infos -->

                                     <p style="margin-left: -417px"><span>No of Subjects:&nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalSubject($student->indexNo);?></span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                 <span>Passed: &nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalPassed($student->indexNo);?></span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Failed: &nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalFailded($student->indexNo);?></span></span>
                                 &nbsp;&nbsp;&nbsp;<span>Incomplete: &nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalUnComplete($student->indexNo);?></span></span>
                              <?php
                                 if($sem==3){?>
                                 &nbsp;&nbsp;&nbsp;<span>Promoted To: &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   strtoupper($final->promotedTo)  ; ?></span></span>
                             <?php  }?>
                                 &nbsp;&nbsp;&nbsp;
                                 <span>Position in Class: &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   $final->position  ; ?></span></span>
                             
                                </p>
                                
</div>
                            </tr>
                        </table></th>
                        </tr>
                        <tr></tr>
                    </table>

     
        
     
         
  
                <table id="report"  align="center" style="margin-left: 3px"  height="90" class="uk-table uk-table-hover uk-table-nowrap "  border="1"  >
         <thead>
          <tr>
            <td ><strong>Core Subjects</strong></td>
              <td><strong>Class Score 50%</strong></td>
              <td ><strong>Exam Score 50%</strong></td>
              <td><strong>Total Score 100%</strong></td>
              <td><div align="center"><strong>Grade</strong></div></td>
               <td><div align="center"><strong>Teacher's Remark</strong></div></td>
            
              <td><div align="center"><strong>Position</strong></div></td>
              
              
            </tr>
          </thead>
        <tbody>
          <tr>
            <?php 
	  $data=Models\AcademicRecordsModel::
                join('subjectallocations', 'assesmentsheet.courseId', '=', 'subjectallocations.id')
                 -> join('courses', 'courses.code', '=', 'subjectallocations.subject')
                ->where('assesmentsheet.indexNo',$indexNo[$i])
                ->where('courses.type',"Core")
                ->where('assesmentsheet.year',$year)
                ->where('assesmentsheet.term',$sem)
                ->orderBy("courses.type")->orderBy("courses.name")->get()->toArray();
		  
		  
	$ttotal=0.0;
        $aggregade=0;
        $cout=0.0;
                $t=count($data);
 
                foreach($data as $r){
               

                ?>
          <tr>
            <td height="43" nowrap='nowrap' ><div align="left"><?php echo $r['name']; ?></div></td>
              <td ><div align="center"><?php  echo ($r['cw1']+$r['cw2']+$r['cw3']+$r['hw1']+$r['hw2']+$r['ctest1']+$r['ctest2']+$r['project1']+$r['project2'])*0.5 ;?></div></td>
              <td ><div align="center"><?php echo $r['exam']*0.5;?></div></td>
              <td ><div align="center"><?php echo $r['total']; $ttotal+=$r['total']; if($r['total']>0){ $cout=$cout+100;}?></div></td>
              <td width="81" >
                <div align="center">
                    
                  <?php 
                   $programme=$sys->getCourseProgrammeMounted($r['courseCode']);
                            
                            $program=$sys->getProgramArray($programme);
                              $gradeSys=$sys->getProgramByGradeSystem("PRI");
                              
                            $gradeArray = $sys->getGrade($r['total'], $gradeSys);
                           
                              $grade = $gradeArray[0]->grade;
                              $gradePoint=@$gradeArray[0]->value;
                               $comment=@$gradeArray[0]->comment;
                    			  echo $gradePoint;
				  
				  $aggregade+=$gradePoint;
				  ?>
              </div></td>
                    <td ><div align="center"><?php  echo $r['grade'];?></div></td>
              <td width="80" ><div align="center"><?php echo $r['posInSubject'];?></div></td>
               
              
              <?php 
				  
             } 
             
               
             
             ?>
              
            
        </tbody>
      
        

      </table>
         
   
                <table class="write" style='margin-left: 15px'>
                    <tr>
              <td style="" ><div align="right" class="write">Total Score : </div></td>
            <td  style="" ><span class="say"><?php echo ($ttotal)."/".(+$cout); ?></span></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td  style="" ><div align="right" class="write">Average Score : </div></td>
            <td style="" > <span class="say"><?php echo number_format(@(($ttotal)/($t)), 2, '.', ',')."%"; ?></span> </td>
            <td style="" colspan="2" ><div align="right"></div></td>
            <td  style="" >&nbsp;</td>
             <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style=""><div class="write">Aggregate:</div></td><td> <span class="say"><?php echo $aggregade  ?></span></td>
            </tr>
                </table>
             
          
         <div>
             <p>&nbsp;</p>
                <table class="remark"  style="margin-left: 12px "  border="0"  >
    
       <?php 
		
          $queryInput= Models\ClassMembersModel::where("term",$sem)
                  ->where("year",$year)
                  ->where("student",$indexNo[$i])
                  ->get()->toArray();
		// dd($queryInput);
           foreach(  $queryInput as $r){

                ?> 
        
     
      <tr>
          <td>
        
                <span class="write">Class Teacher's Remarks:</span>  <span class="say"><?php echo  $r['form_mast_report'] ; ?> </span>
          
          </td>
          <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
          
        <tr><td>
               <span class="write">Head Master's Remarks </span>: <span class="say"><?php echo  $r['head_mast_report'] ; }?></span> 
                   
         </td>
      </tr>
      
      <div>
    </table>
  </div>
  <div style="float:right">
      <table >
      <tr>
          <td style="" colspan="4"align="center" class="write">Class Teacher's Signature: </td>          
         <td align="center"> ................................................ </td>
      </tr>
      <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
      <tr>
            <td style="" colspan="4"align="center" class="write">Head Master's Signature: </td>          
         <td align="center"> ..................................................... </td>
      </tr>

    </table>
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
            </div></div> 
    <p style="margin-left: 13px"><b>Grade Scheme - Performance Chart</b></p>
                <table class="gad uk-table-stripedm write" style="margin-left: 13px" border='0'>
                    <thead>
                        <th>Lower</th>
                        <th>Upper</th>
                        <th>Grade</th>
                        <th>Interpretation</th>
                </thead>
                    <tbody>
                        <?php
                        $scheme = Models\GradeSystemModel::where("type", "PRIMARY")->get();
                        foreach ($scheme as $key){
                        ?>
                        <tr>
                            <td><?php echo $key->lower ?></td>
                             <td><?php echo $key->upper ?></td>
                             <td><?php echo $key->value ?></td>
                             <td><?php echo $key->grade ?></td>
                        </tr>

                        <?php } ?>
                    </tbody>
                </table>
    
    <br clear="all" style="page-break-before: always"/>
  &nbsp;
 <center><p class="uk-text-small">Software Designed by gadeksystems.com | Phone: +233243348522, +233241999094,+233505284060</p></center>
 
 </div>
        
<?php }}
  
    
    
    
    
    
    
    
    
    
    
    
    
    
     public function reportCard(SystemController $sys,Request $request){

         
           if ($request->isMethod("get")) {

            return view('courses.showCard');
                             
            } 
            else{

                $student=  explode(',',$request->input('q'));
                $student=$student[0];
                
              
                
             $sql=Models\StudentModel::where("indexNo",$student)->first();
                     
               
               if(count($sql)==0){
           
                return redirect("/transcript")->with("error","<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
                }
              else{
                    
                  $array=$sys->getSemYear();
                   
                 
               $data=$this->cardHeader($sql, $sys)  ;
              $record=$this->generateCard($sql->id,$sys);
      return view("courses.reportCard")->with('grade',$record)->with("student",$data);
         
                  
                   
                  
              }
            }

        

    }
    public function cardHeader($student, SystemController $sys) {
          $array = $sys->getSemYear();
                $sem = $array[0]->term;
                $year = $array[0]->year;
                 $start = $array[0]->startDate;
                   $end= $array[0]->endDate;
                   
                    //dd($student);
                   //$indexno=$sys->getIndexNo($student);
                  
                   $position= @Models\ClassMembersModel::where("student",$student->indexNo)
                           ->where("year",$year)
                           ->where("term",$sem)
                           ->first();
                   $classPosition=@$position->position;
        ?>
<div class="md-card">
  
        <div   class="uk-grid" data-uk-grid-margin>
            <div class="table-responsive">
            <table  border="0" cellspacing="0" align="center" style=' '>
                        
                        <tr>
                            <th height="341" valign="top" class="bod" scope="row"><table width="100%" border="0">
                            <tr>
                                <th align="center" valign="middle" scope="row"><table  style="margin-left: -29px"width="930" height="113" border="0">
                                <tr>
                                    <th align="center" valign="middle" scope="row">
                               
                                <table style="" width="882" height="113" border="0" >
                                    <tr>
                                       <td align='right'> <img src="<?php echo url('public/assets/img/header.jpg')?>" style=''/></td>
                                              
                                    </tr>
                                     
                                        
                                </table>
                                
                                
                                </tr>


                            </table>
                          <?php  $final= Models\ClassMembersModel::where("term",$sem)
                  ->where("year",$year)
                  ->where("student", $student->indexNo)
                  ->first();?>
                          
                                    <h5 class="heading_a uk-text-bold "><u><b>PUPIL'S TERMINAL REPORT</b></u></h5>
                                <div style="text-align: left;margin-left: -102px ">
                                    <p style="text-decoration: none"> <span  >Year: &nbsp;&nbsp;&nbsp;<span class="write"> <?php echo $year?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                                        <span >Term: &nbsp;&nbsp;&nbsp;<span class="write"> <?php echo $sem?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                                        <span style="float: right;margin-left: 59px">N<u>o</u> On Roll:&nbsp;&nbsp;&nbsp;<span class="write"> <?php echo $sys->getClassSize($student->currentClass);?></span></span>
                                        <span style="float: right">Pass Mark: &nbsp;&nbsp;&nbsp;<span class="write">50.0</span><span class="write">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                                    </p>
                                     <p style="text-decoration: none"> <span  >End of Term Exams</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span >Next Term Begins on: &nbsp;&nbsp;&nbsp;<span class="write"> <?PHP echo   $end; ?></span></span>
                                          </p>
                                    
                                </div>
                                  <div  style="margin-left: -73px "
                                    <table border='0' class=" " align="center"  width='900px' style='text-decoration: none'>
                                          <table >
                                              <tr>
                                                  <td>
                                    <tr>
                                        <td width="" style="width:69%">
                                            <center>
                                                <table border='0' class="biodata" width='800px' width=""  style="margin-left: -34px" >
                                                    <tbody>
                                                         
                                                        <tr>
                                                            <td class=" " style=""><b>Name:</b>   &nbsp;&nbsp;&nbsp;&nbsp <span class="write"><?php echo strtoupper(  $student->fullname)?></span></td>
                                                        </tr>
                                                        
                                                         
                                                         <tr>
                                                             <td class=" " style=""><b>Conduct:</b>&nbsp;&nbsp;&nbsp;&nbsp <span class="say"> <?PHP echo   $final->conduct; ?></span></td> 
                                                             <td  class=""><b>Class:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo  strtoupper($student->currentClass) ; ?></span></td>
                                                         </tr>
                                                        <tr>
                                                            <td  style=""><b>Attitude:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo  $final->attitude  ; ?></span></td> 
                                                            <td style=""><b>Attendance:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   $final->attendance  ; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class=" " style=""><b>Interest:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo  $final->interest  ; ?></span></td> 
                                                            <td style=""><b>Total:</b> &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   $final->total  ; ?></span></td>
                                                        </tr>
                                                        


                                                    </tbody>

                                                </table>
                                            </td>
                                                  <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                                                  <td valign="top" >
                                                      <img   style="width:150px;height: auto;"  <?php
                                                      $pic = $student->indexNo;

                                                      ?>   src='<?php echo url("public/albums/students/$pic.jpg")?>' alt="  Affix student picture here"    />
                                                  </td>


                                              </tr>
                                          </table>

                                            </center>
                                        </td>
                             
                                        
                                    </tr>
                                    </tr>
                                </table> <!-- end basic infos -->

                                 <p style="margin-left: -350px"><span>No of Subjects:&nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalSubject($student->indexNo);?></span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                 <span>Passed: &nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalPassed($student->indexNo);?></span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Failed: &nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalFailded($student->indexNo);?></span></span>
                                 &nbsp;&nbsp;&nbsp;<span>Incomplete: &nbsp;&nbsp;&nbsp; <span class="say"> <?php echo $sys->getTotalUnComplete($student->indexNo);?></span></span>
                              <?php
                                 if($sem==3){?>
                                 &nbsp;&nbsp;&nbsp;<span>Promoted To: &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   strtoupper($final->promotedTo)  ; ?></span></span>
                             <?php  }?>
                                 &nbsp;&nbsp;&nbsp;
                                 <span>Position in Class: &nbsp;&nbsp;&nbsp;<span class="say"><?PHP echo   $final->position  ; ?></span></span>
                             
                                </p>
                                
                                
                               
                            </div>
                              
</div>
                            </tr>
                        </table></th>
                        </tr>
                        <tr></tr>
                    </table>

    <?php
        
    }
    public function generateCard($sql,  SystemController $sys){
          
                    $array = $sys->getSemYear();
                $sem = $array[0]->term;
                $year = $array[0]->year;
                 
                    $data=Models\AcademicRecordsModel::
                join('subjectallocations', 'assesmentsheet.courseCode', '=', 'subjectallocations.subject')
                 -> join('courses', 'courses.code', '=', 'subjectallocations.subject')
                ->where('assesmentsheet.stuId',$sql)
                ->where('courses.type',"Core")
                ->where('assesmentsheet.year',$year)
                ->where('assesmentsheet.term',$sem)
                ->orderBy("courses.type")->orderBy("courses.name")->groupBy("assesmentsheet.courseId")->get()->toArray();
	  ?>

      
       
         
                <table id="report"  align="center" style="margin-left: 3px"  height="90" class="uk-table uk-table-hover uk-table-nowrap "  border="1"  >
      <thead>
          <tr>
            <td ><strong>Core Subjects</strong></td>
              <td><strong>Class Score 50%</strong></td>
              <td ><strong>Exam Score 50%</strong></td>
              <td><strong>Total Score 100%</strong></td>
              <td><div align="center"><strong>Grade</strong></div></td>
              <td><div align="center"><strong>Teacher's Remark</strong></div></td>
              <td><div align="center"><strong>Position</strong></div></td>
              
              
            </tr>
          </thead>
        <tbody>
  
          
            <?php 
		  
		  
	$ttotal=0.0;
        $aggregade=0;
        $cout=0.0;
                $t=count($data);
 
                foreach($data as $r){
               

                ?>
          <tr>
            <td height="43" nowrap='nowrap' ><div align="left"><?php echo $r['name']; ?></div></td>
              <td ><div align="center"><?php  echo ($r['cw1']+$r['cw2']+$r['cw3']+$r['hw1']+$r['hw2']+$r['ctest1']+$r['ctest2']+$r['project1']+$r['project2'])*0.5 ;?></div></td>
              <td ><div align="center"><?php echo $r['exam']*0.5;?></div></td>
              <td ><div align="center"><?php echo $r['total']; $ttotal+=$r['total']; if($r['total']>0){ $cout=$cout+100;}?></div></td>
              <td width="81" >
                <div align="center">
                    
                  <?php 
                   $programme=$sys->getCourseProgrammeMounted($r['courseCode']);
                            
                            //$program=$sys->getProgramArray($programme);
                              $gradeSys=$sys->getProgramByGradeSystem("PRI");
                              
                            $gradeArray = $sys->getGrade($r['total'], $gradeSys);
                           
                              $grade = $gradeArray[0]->grade;
                              $gradePoint=@$gradeArray[0]->value;
                               $comment=@$gradeArray[0]->comment;
                    			  echo $gradePoint;
				  
				  $aggregade+=$gradePoint;
				  ?>
              </div></td>
               <td ><div align="center"><?php  echo $r['grade'];?></div></td>
              <td width="80" ><div align="center"><?php echo $r['posInSubject'];?></div></td></tr>
               
              
              <?php 
				  
             } 
             
               
             
             
             ?>
              
               
       </tbody>
      
        

      </table>
         
   
                <table class="write" style='margin-left: 15px'>
                    <tr>
              <td style="" ><div align="right" class="write">Total Score : </div></td>
            <td  style="" ><span class="say"><?php echo ($ttotal)."/".(+$cout); ?></span></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td  style="" ><div align="right" class="write">Average Score : </div></td>
            <td style="" > <span class="say"><?php echo number_format(@(($ttotal)/($t)), 2, '.', ',')."%"; ?></span> </td>
            <td style="" colspan="2" ><div align="right"></div></td>
            <td  style="" >&nbsp;</td>
             <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style=""><div class="write">Aggregate:</div></td><td> <span class="say"><?php echo $aggregade  ?></span></td>
            </tr>
                </table>
              <p>&nbsp;</p>
          
         <div>
                <table class="remark"    style="margin-left: 12px "  border="0"  >
      
       <?php 
		
          $queryInput= Models\ClassMembersModel::where("term",$sem)
                  ->where("year",$year)
                  ->where("student",$sys->getIndexNo($sql))
                  ->get()->toArray();
		// dd($queryInput);
           foreach(  $queryInput as $r){

                ?> 
        
     
      
      <tr>
          <td>
        
                <span class="write">Class Teacher's Remarks:</span>  <span class="say"><?php echo  $r['form_mast_report'] ; ?> </span>
          
          </td>
          <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
          
          
        <tr><td>
               <span class="write">Head Master's Remarks </span>: <span class="say"><?php echo  $r['head_mast_report'] ; }?></span> 
                   
         </td>
      </tr>
      
      <div>
    </table>
  </div>
  <div style="float:right">
    <table>
      <tr>
          <td style="" colspan="4"align="center" class="write">Class Teacher's Signature: </td>          
         <td align="center"> ................................................ </td>
      </tr>
       <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
        <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
      <tr>
            <td style="" colspan="4"align="center" class="write">Head Master's Signature: </td>          
         <td align="center"> ..................................................... </td>
      </tr>

    </table>
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



               <p style="margin-left: 13px" class="write"><b>Grade Scheme - Performance Chart</b></p>
                <table class="gad uk-table-stripedm write" style="margin-left: 13px" border='0'>
         <thead>
                        <th>Lower Limit</th>
                        <th>Upper Limit</th>
                        <th>Grade</th>
                        <th>Interpretation</th>
                </thead>
                    <tbody>
                        <?php
                        $scheme = Models\GradeSystemModel::where("type", "PRIMARY")->get();
                        foreach ($scheme as $key){
                        ?>
                        <tr>
                            <td><?php echo $key->lower ?></td>
                             <td><?php echo $key->upper ?></td>
                             <td><?php echo $key->value ?></td>
                             <td><?php echo $key->grade ?></td>
                        </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div></div>
 &nbsp;
 
 <center><p class="uk-text-small">Software Designed by gadeksystems.com | Phone: +233243348522, +233241999094,+233505284060</p></center>
            </div>
        
   <?php }

  
     public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }
     public function batchRegistration(Request $request,SystemController $sys){
         
        if (@\Auth::user()->department == 'top' || @\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support') {
            if ($request->isMethod("get")) {
 
                   return view('courses.batchRegister')->with('year', $sys->years())
                               // ->with("course",$sys->getMountedCourseList())
                                ->with("level",$sys->getClassList())
                                ->with('program', $sys->getProgramList());
                                
          
            }
            else{
                
            }
        }
        else{
            return redirect("/dashboard");
        }
    }
     public function processBatchRegistration(Request $request,SystemController $sys){
         $this->validate($request, [

            'program' => 'required',
        ]);
       $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        
        
        
          
           // $policy=$sys->getRegiistrationProtocol($student);
            $level=$request->input("level");
            $program=$request->input("program");
           
            if(!empty($level)){
                   //@Models\AcademicRecordsModel::query()->where('class', $level)
                     //  ->where('year', $year)
                      // ->where('term', $sem)
                      // ->delete() ;
               $allocation=Models\CourseAllocationModel::where("year",$year)
                       ->where("classId",$level)
                       ->where("term",$sem)->where("teacherId","!=","")->get();
                 
 

               


                foreach($allocation as $row){
                     
                     $student=  Models\StudentModel::where("currentClass",$row->classId)->where("programme",$program)->get();
               
                    
                    foreach($student as $data){
                         
                         
                        $class=$row->classId;
                        $indexno=$data->indexNo;
                        $studentId=$data->id;
                        $lecturer=$row->teacherId;
                        $courseCode=$row->subject;
                       $course=$row->id;
                           $check=  Models\AcademicRecordsModel::where("class",$level)->where("year",$year)->where("term",$sem)->where("indexNo",$indexno)
                               ->where("courseCode",$courseCode)
                               ->count();

                         if($check==0){

                           $queryModel=new Models\AcademicRecordsModel();
                           $queryModel->courseId=$course;
                           $queryModel->courseCode=$courseCode;
                           $queryModel->indexNo=$indexno;
                            
                           $queryModel->stuId=$studentId;
                           
                           $queryModel->year=$year;
                           $queryModel->term=$sem;
                           $queryModel->class=$class;
                           $queryModel->staff=$lecturer;
                           
                           $queryModel->save();
                           // \DB::commit();
                             
                        }
                         // Models\CourseAllocationModel::where("classId",$level)->where("year",$year)->where("term",$sem)->update(array("open"=>1));
                           
                           
                           
                  }
              }
            }
//            else{
//                $allocation=Models\CourseAllocationModel::where("year",$year)->where("term",$sem)->where("teacherId","!=","")->get();
//                 
//                foreach($allocation as $row){
//                     
//                     $student=  Models\StudentModel::where("programme",$program)->where("status","In School")->get();
//               
//                    
//                    foreach($student as $data){
//                         
//                         
//                        $class=$row->classId;
//                        $indexno=$data->indexNo;
//                        $studentId=$data->id;
//                        $lecturer=$row->teacherId;
//                        $courseCode=$row->subject;
//                       $course=$row->id;
//                         
//                         
//                        
//                           $queryModel=new Models\AcademicRecordsModel();
//                           $queryModel->courseId=$course;
//                           $queryModel->courseCode=$courseCode;
//                           $queryModel->indexNo=$indexno;
//                            
//                           $queryModel->stuId=$studentId;
//                           
//                           $queryModel->year=$year;
//                           $queryModel->term=$sem;
//                           $queryModel->class=$class;
//                           $queryModel->staff=$lecturer;
//                            $queryModel->save();
//                           // \DB::commit();
//                             
//                         
//                          Models\CourseAllocationModel::where("classId",$level)->where("year",$year)->where("term",$sem)->update(array("open"=>1));
//                           
//                           
//                           \DB::commit();
//                  }
//              }
//                        // overwrite registered courses for the sem and the year
//                     
//                        
//                           
//            }
//         
           return redirect()->back()->with("success",  " <span style='font-weight:bold;font-size:13px;'>Courses registered successfully</span> ");
                     
        
        
    }
   
     public function uploadMounted(SystemController $sys,Request $request){

         if (@\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support' || @\Auth::user()->role == 'Registrar' || @\Auth::user()->department == 'top') {

            if ($request->isMethod("get")) {

                return view('courses.uploadMounted');
            } else {

                set_time_limit(36000);

                $valid_exts = array('csv', 'xls', 'xlsx'); // valid extensions
                $file = $request->file('file');
                $name = time() . '-' . $file->getClientOriginalName();
                if (!empty($file)) {

                    $ext = strtolower($file->getClientOriginalExtension());

                    if (in_array($ext, $valid_exts)) {
                        // Moves file to folder on server
                        // $file->move($destination, $name);

                        $path = $request->file('file')->getRealPath();
                        $data = Excel::load($path, function($reader) {
                                    
                                })->get();
                        $total = count($data);

                        if (!empty($data) && $data->count()) {

                            $user = \Auth::user()->id;
                            $courseError=array();
                            $programError=array();
                            foreach ($data as $value => $row) {
                               
                                $code = $row->code;
                                $program = $row->program;
                                $courseID=$sys->getCourseByCode2($code,$program);                   
                                $credit = $row->credit;
                                $type = $row->type;
                                $level = $row->level;
                                $name = $row->course;
                                $year = $row->year;
                                $semester = $row->semester;
                                $searchCourse = $sys->courseSearchByCode();
                                $programme = $sys->programmeSearchByCode(); // check if the programmes in the file tally wat is in the db
                                if (in_array($program, $programme)) {
                                    if (in_array($code, $searchCourse)) {
                                        $testQuery = Models\MountedCourseModel::where('COURSE', $courseID)->where("COURSE_year",$year)
                                                ->where("COURSE_term",$semester)
                                                ->first();

                                        if (empty($testQuery)) {


                                            $course = new Models\MountedCourseModel();
                                            $course->COURSE = $courseID;
                                            $course->COURSE_CODE = $code;
                                            $course->COURSE_CREDIT = $credit;
                                            $course->PROGRAMME = $program;
                                            $course->COURSE_term = $semester;
                                            $course->COURSE_LEVEL = $level;
                                            $course->COURSE_TYPE = $type;
                                             $course->COURSE_year = $year;
                                            $course->MOUNTED_BY = $user;
                                            $course->save();
                                            \DB::commit();
                                        } else {

                                            Models\MountedCourseModel::where('COURSE', $courseID)->update(array("COURSE_CODE" =>$code,"COURSE_LEVEL" =>$level, "COURSE_term" => $semester, "PROGRAMME" => $program, "COURSE_CREDIT" => $credit, "COURSE_TYPE" => $type, "COURSE_year" => $year,"MOUNTED_BY" => $user));
                                            \DB::commit();
                                        }
                                    } else {
                                        array_push($courseError, $name." ".$code);
                                      //  redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognize courses.please try again!</span> ");
                                  //  dd($courseError);
                                    continue;
                                    }
                                } else {
                                      array_push($programError, $sys->getProgram($program));
                                      continue;
                                      // redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognize programme.please try again!</span> ");
                                }
                            }
                            if(!empty($programError) || !empty($courseError)){
              return     redirect('/upload/mounted')->with("errorP",$programError)
                   ->with("errorC",$courseError);
                           
            }
                        }
                    } else {
                        return redirect('/upload/mounted')->with("error", " <span style='font-weight:bold;font-size:13px;'>Only excel file is accepted!</span> ");
                    }
                } else {
                    return redirect('/upload/mounted')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload an excel file!</span> ");
                }
            }
            
            
            return redirect('/mounted_view')->with("success", " <span style='font-weight:bold;font-size:13px;'>$total Courses mounted successfully</span> ");
            
            
            } else {

            return redirect("/dashboard");
        }
    }
    public function updateMounted(SystemController $sys,Request $request, $id) {
         if (@\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support'|| @\Auth::user()->role == 'Registrar' || @\Auth::user()->department == 'top') {

          if ($request->isMethod("get")) {
              $lecturers=$sys->getLectureList_All();
              $yearList=$sys->years();
              $program=$sys->getProgramList();
              $course=$sys->getCourseList();
               $user=@\Auth::user()->staffID;
                $array = $sys->getSemYear();
                $sem = $array[0]->term;
                $year = $array[0]->year;
                $query=  @Models\MountedCourseModel::query()
                       ->where("COURSE_year",$year)
                        ->where("ID",$id)
                       ->where("COURSE_term",$sem)->paginate(20);
                
                
           return view('courses.editMounted')->with("data",@$query)
                   ->with("lecturer",$lecturers)
                   ->with("program",$program)
                    ->with("course",$course)
                    ->with("ID",$id)
                   ->with("years",$yearList);
                    
                    
                            
           } 
           else{
                \DB::beginTransaction();
                try {
                    
                    $upper = $request->input('upper');
                    
                    $sem = $request->input('semester');
                    $credit = $request->input('credit');
                    $level = $request->input('level');
                    $type = $request->input('type');
                    $course = $request->input('course');
                    
                    $lecturer = $request->input('lecturer');
                   
                    $key = $request->input('key');
                    for ($i = 0; $i < $upper; $i++) {
                        $courseArr = $course[$i];
                        
                        $levelArr = $level[$i];
                        $semArr = $sem[$i];
                        $creditArr = $credit[$i];
                        $typeArr = $type[$i];
                        $keyArr = $key[$i];
                        $lecturerArr = $lecturer[$i];
                       
                         Models\MountedCourseModel::where("ID", $key)
                                 ->update(array("COURSE_CREDIT" => $creditArr,   "COURSE_term" => $semArr, "COURSE_TYPE" => $typeArr, "COURSE_LEVEL" => $levelArr, "LECTURER" => $lecturerArr));

                         \DB::commit();
                         Models\AcademicRecordsModel::where("course", $key)->update(array("credits" => $creditArr,   "sem" => $semArr, "level" => $levelArr, "lecturer" => $lecturerArr));

                    }
                     return redirect("/mounted_view")->with("success","Mounted courses updated successfully");
                }
                catch (\Exception $e) {
                    \DB::rollback();
                }
         }
         }
        else{
            return redirect("/dashboard");
        }
         
    }
    public function uploadCourse(SystemController $sys,Request $request){

       if (@\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support'|| @\Auth::user()->role == 'Registrar' || @\Auth::user()->department == 'top') {

          if ($request->isMethod("get")) {

           return view('courses.uploadCourse');
                            
           } 
           else{

               set_time_limit(36000);
         
 
        
           
           $valid_exts = array('csv','xls','xlsx'); // valid extensions
           $file = $request->file('file');
           $name = time() . '-' . $file->getClientOriginalName();
           if (!empty($file)) {
              
               $ext = strtolower($file->getClientOriginalExtension());
               
               if (in_array($ext, $valid_exts)) {
                   // Moves file to folder on server
                   // $file->move($destination, $name);
                    
                         $path = $request->file('file')->getRealPath();
                      $data = Excel::load($path, function($reader) {

			})->get();
                        $total=count($data);
                        
                       if(!empty($data) && $data->count()){
 
                            $user = \Auth::user()->fund;
                               foreach($data as $value=>$row)
                               {
                                   $code=$row->code;
                                   $program=$row->pcode;
                                   
                                 
                                   $name=$row->name;
                                    $programme = $sys->programmeSearchByCode(); // check if the programmes in the file tally wat is in the db
                           if (in_array($program, $programme)) {
   
                       $testQuery=Models\CourseModel::where('code', $code)->first();
                      
                         if(empty($testQuery)){
                             
                         
                               $course = new Models\CourseModel();
                                           $course->code = $code;
                                           $course->name = $name;
                                          
                                           $course->pcode = $pcode;
                                           
                                           $course->createdBy = $user;
                                           $course->save();
                                           \DB::commit();
                                       }
                         else{
                               
      @Models\CourseModel::where('code', $code)->update(array("name" =>@$name, "code" => $code, "pcode" => $program ));
                                       \DB::commit();
                         }
                               }
                               else{
                                      redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognize programme.please try again!</span> ");
                   
                               }
                       
                               
                               
                               
                               
                      } 
                   }
               } else {
                    return redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>Only excel file is accepted!</span> ");
                                  
               }
           } else {
                return redirect('/upload/courses')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload an excel file!</span> ");
                   
           }
         }
    
       return redirect('/courses')->with("success", " <span style='font-weight:bold;font-size:13px;'>$total Courses uploaded successfully</span> ");
              

       }
     
       
     else{

           throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
     }
       

    }
    public function transcript(SystemController $sys,Request $request){

        if (@\Auth::user()->role == 'Class Teacher' || @\Auth::user()->role == 'Lecturer' || @\Auth::user()->role == 'House Mistress'|| @\Auth::user()->role == 'House Master' || @\Auth::user()->department == 'top') {

           if ($request->isMethod("get")) {

            return view('courses.showTranscript');
                             
            } 
            else{

                $student=  explode(',',$request->input('q'));
                $student=$student[0];
                
              
                
             $sql=Models\StudentModel::where("indexNo",$student)->first();
                     
               
               if(count($sql)==0){
           
                return redirect("/transcript")->with("error","<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
                }
              else{
                    
                  $array=$sys->getSemYear();
                   
                 
               $data=$this->transcriptHeader($sql, $sys)  ;
              $record=$this->generateTranscript($sql->id,$sys);
      return view("courses.transcript")->with('grade',$record)->with("student",$data);
         
                  
                   
                  
              }
            }

        }

    }
    public function transcriptHeader($student, SystemController $sys) {
        
        ?>
<div class="md-card">
  
        <div   class="uk-grid" data-uk-grid-margin>

            <table  border="0" cellspacing="0" align="center" style="margin-left:32px">
                        <tr></tr>
                        <tr>
                            <th height="341" valign="top" class="bod" scope="row"><table width="100%" border="0">
                            <tr>
                                <th align="center" valign="middle" scope="row"><table width="930" height="113" border="0">
                                <tr>
                                    <th align="center" valign="middle" scope="row">
                                <fieldset>
                                <table style="" width="882" height="113" border="0" >
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td class="heading_a uk-text-bold">Nest School Complex</td>


                                                </tr>
                                                <Tr>
                                                    <td class="heading_a">Directorate of Academics Affairs</td>
                                                </Tr>
                                                <tr>
                                                    <td class="heading_c">Transcript</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td align='right'> <img src="<?php echo url('public/assets/img/logo.PNG')?>" style='width: 111px;height: auto;margin-left: -71px'/></td>
                                    </tr>
                                     
                                        
                                </table>
                                </fieldset>
                                
                                </tr>


                            </table>
                            
                            <div align="center">

                                <table border='0' class=" " align="center"  width='900px'>
                                    <tr>
                                        <td width="" style="width:69%">
                                            <center>
                                                <table border='0' class="biodata" width='800px' width=""  style="margin-left:-19px" >
                                                    <tbody>
                                                         <tr>
                                                            <td class="uk-text-bold"style="padding-right: px;">INDEX NUMBER</td> <td style="padding-right: 93px;"><?php echo $student->indexNo;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="uk-text-bold" style="">NAME</td> <td style="padding-right: 36px;"><?php echo strtoupper($student->TITLE .' '.  $student->name)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="uk-text-bold"style="">GENDER</td> <td style="padding-right: 36px;"><?php echo strtoupper($student->gender)?></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="uk-text-bold">PROGRAMME</td> <td style="padding-right: 177px;"><?php echo strtoupper($student->program->name)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="uk-text-bold" style="">DATE OF ADMISSION</td> <td style="padding-right: 36px;"><?php echo strtoupper($student->dateAdmitted)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="uk-text-bold" style="">DATE OF BIRTH</td> <td style="padding-right: 36px;"><?PHP echo  $student->dob ; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="uk-text-bold" style="">CLASS</td> <td style="padding-right: 36px;" class="uk-text-success uk-text-bold"><?PHP echo  strtoupper($student->currentClass) ; ?></td>
                                                        </tr>
                                                        


                                                    </tbody></table> </center>
                                        </td>
                                        <td width="15">&nbsp;    
                                        <img   style="width:130px;height: auto;margin-left: 14px"  <?php
                                     $pic = $student->indexNo;
                                      
                                     ?>   src='<?php echo url("public/albums/students/$pic.jpg")?>' alt="  Affix student picture here"    />
           
                                        
                                        </td>
                                        
                                    </tr>
                                    </tr>
                                </table> <!-- end basic infos -->

  
                                
                                
                               
                            </div>
                              
</div>
                            </tr>
                        </table></th>
                        </tr>
                        <tr></tr>
                    </table>

    <?php
        
    }
    public function generateTranscript($sql,  SystemController $sys){
         
       $records=  Models\AcademicRecordsModel::where("stuId",$sql)->select("year","class")->groupBy("year")->get();
                                

	  ?>

      
        <table width='800px' style="text-align:left; ;font-size: 16px" height="90" class=""  border="0" style="margin-left:32px">
        <tr>
        
          <td  style=" " align="left"> 
            <?php  
               
            foreach ($records as $row){
            for($i=1;$i<4;$i++){
             $query=  Models\AcademicRecordsModel::where("stuId",$sql)->where("year",$row->year)->where("term",$i)->groupBy("class")->groupBy("courseId")->get()->toArray();
                
              
                if(count($query)>0){

                echo "<div class='uk-text-bold' align='left' style='margin-left:33px'>Year : ".$row->year."    ";
                echo ", Term : ".$i;
                 echo ", Class :  " .$row->class." <hr/></div>";
                 

                  
                 
              
                
         ?>
         
            <div class="uk-overflow-container">
           <table style="margin-left:32px"  border="0" style=""width='940px'  class="uk-table uk-table-striped ">
                <thead >
                    <tr class="uk-text-bold" style="background-color:#EAF2D3;color:white;">
                     <th>SUBJECT</th>

                    <th style=';' class='ui-corner-top'>MARKS SCORED</th>
                    <th style='' class='ui-corner-top'>POSITION</th>
                    <th style='text-align:  ' style='width:15%;' class='ui-corner-top'>GRADE</th>
                    
                    </tr>
                </thead>
                <tbody>
                  <?php 
		  $classSize=count($query);
                  $ttotal=0.00;
                   $aggregade=0.00;
                foreach ($query as $rs){

                 

                ?>
                  <tr>
                 
                    <td> <?php $object=@$sys->getCourseByCodeObject($rs['courseCode']); 
			 echo strtoupper($object->name);?> </td>	
                     
                    <td><?php echo $rs['total']?></td>
                    <td><?php echo $rs['posInSubject'];?></td>
                    <?php
                    
                        $programme=$sys->getCourseProgrammeMounted($rs['courseCode']);
                            
                            $program=$sys->getProgramArray($programme);
                              $gradeSys=$sys->getProgramByGradeSystem("PRI");
                              
                            $gradeArray = $sys->getGrade($rs['total'], $gradeSys);
                           
                              $grade = $gradeArray[0]->grade;
                              $gradePoint=@$gradeArray[0]->value;
                               $comment=@$gradeArray[0]->comment;
                    
                    ?>
                    <td style='text-align:  '><?php echo $grade;$ttotal+=$rs['total']; ?></td>
                    
                      <?php
                      
                     			  
				   
				 
				  $aggregade+=$gradePoint;
				  ?>
                   
                     
	  
                    <?php 
                     } ?>
                  </tr>
                  <tr>
                     
                       
                      <td colspan="1"><div align="right" class="uk-text-bold">Total Score: </div></td>
                    <td><span class="uk-text-bold"><?php echo $ttotal; ?></span></td>
                    <td colspan=""  ><div align="left" class="uk-text-bold">Average Score: <?php echo number_format(@($ttotal/$classSize), 2, '.', ',') ; ?></div>                      </td>
                        </tr>
                         
                </tbody>
                
                 
                    </table> 
        <?php }else{
            echo "<p class='uk-text-danger'>No results to display</p>";
        ?><?php }?>
                <p>&nbsp;</p>     
             </div><?php } $ttotal=0.0; }
    
    ?> 
        
        
        </tr>
  
      </table> 
         
</div></div>
        
   <?php }
    public function subjectAllocator(Request $request,SystemController $sys)
    {
          
          if($request->user()->isSupperAdmin  ||     @\Auth::user()->department=="top"){
            $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
          $courses= Models\CourseAllocationModel::query()->where("term",$sem)
            ->where("year",$year) ;
           
          }
          else{
            $courses= Models\CourseAllocationModel::query()->where("teacherId",@\Auth::user()->fund) ;
            
          }
          
        if ($request->has('classs') && trim($request->input('classs')) != "") {
            $courses->where("classId", $request->input("classs", ""));
        }
        if ($request->has('staff') && trim($request->input('staff')) != "") {
            $courses->where("teacherId", $request->input("staff", ""));
        }
        if ($request->has('term') && trim($request->input('term')) != "") {
            $courses->where("term", $request->input("term", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $courses->where("year", $request->input("year", ""));
        }
        
        $data = $courses->orderBy("classId")->paginate(100);
        
        $request->flashExcept("_token");
          
         
        return view('courses.allocation')->with("data", $data)->with("class",$sys->getClassList())
                        ->with('year', $sys->years())->with('subject', $sys->getCourseList())->with('teacher', $sys->getLectureListAllocation())
         ->with('staff', $sys->getLectureList());
         
       
    }
    
    public function classList(Request $request,SystemController $sys)
    {
       
          if($request->user()->isSupperAdmin  ||     @\Auth::user()->department=="top"){
       
          $courses= Models\CourseAllocationModel::query() ;
           
          }
          else{
            $courses= Models\CourseAllocationModel::query()->where("teacherId",@\Auth::user()->fund) ;
            
          }
          
        if ($request->has('classs') && trim($request->input('classs')) != "") {
            $courses->where("classId", $request->input("classs", ""));
        }
        if ($request->has('staff') && trim($request->input('staff')) != "") {
            $courses->where("teacherId", $request->input("staff", ""));
        }
        if ($request->has('term') && trim($request->input('term')) != "") {
            $courses->where("term", $request->input("term", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $courses->where("year", $request->input("year", ""));
        }
        
        $data = $courses->orderBy("classId")->paginate(100);
        
        $request->flashExcept("_token");
                           $array = $sys->getSemYear();
                $term1 = $array[0]->term;
               $year1= $array[0]->year;
                    
          
        return view('classes.classList')->with("data", $data)->with("class",$sys->getClassList())
                        ->with('year', $sys->years())->with('subject', $sys->getCourseList()) 
                ->with("year1", $year1)->with("term1", $term1);
         
       
    }
    
    
    
    
    public function allocationCreator(Request $request,SystemController $sys){
        if ($request->isMethod("get")) {
             return view('courses.createAllocation')->with("class",$sys->getClassList())
                        
         ->with('staff', $sys->getLectureList())->with('subject', $sys->getCourseList())->with('years', $sys->years());
        
        }
        else{
          
        $this->validate($request, [


                    'staff' => 'required',
                    'subject' => 'required',
                    'classs' => 'required',
              'term' => 'required',
              'year' => 'required',
                    
                ]);
                   
                    $staff=$request->input("staff");
                    $class=$request->input("classs");
                      $sem=$request->input("term");
                        $year=$request->input("year");
                    $subject=$request->input("subject");
                   // dd($program);
                      $user=@\Auth::user()->fund;
         
                \DB::beginTransaction();
                try {
                   
                        $allocator = new Models\CourseAllocationModel();
                $allocator->subject = $subject;
                $allocator->teacherId = $staff;
                $allocator->classId = $class;
                $allocator->year = $year;
                $allocator->term = $sem;
                $allocator->createdBy = $user;
                \DB::commit();
                  
                       if( $allocator->save()){
                            \DB::commit();
                        return response()->json(['status'=>'success','message'=>' Subject allocated to staff successfully ']);
      
                       }
                       else{
                           return response()->json(['status'=>'error','message'=> ' Error allocating subject. try again ']);
       
                       }
                    
                } catch (\Exception $e) {
                    \DB::rollback();
                }
        }
    }
    // updating course allocation
     public function updateAllocation(Request $request,SystemController $sys){
        // dd($request);
                    $upper = $request->input('upper');
                    
                    $teacher = $request->input('staff');
                    $year = $request->input('year');
                    $term = $request->input('term');
                   
                   // $term = $request->input('term');
                    $class = $request->input('class');
                    $key = $request->input('key');
                  $subject= $request->input('subject');
//                    $array = $sys->getSemYear();
//                $term = $array[0]->term;
//                $year = $array[0]->year;
//                    
                    for ($i = 0; $i < $upper; $i++) {
                        $teacherArr = $teacher[$i];
                        
                       
                        
                        $keyArr = $key[$i];
                        $classArr = $class[$i];
                        $yearArr = $year[$i];
                        $termArr = $term[$i];
                       $subjectArr=$subject[$i];
                        $sql=Models\CourseAllocationModel::where("classId", $classArr)
                            ->where("id",$keyArr)
                                ->where("year",$yearArr)
                                ->where("term",$termArr)

                                ->where("subject",$subjectArr)->get()->toArray();
                        
                        if(!empty($sql)){
                         Models\CourseAllocationModel::where("id", $keyArr)
                                 ->update(array("teacherId" => $teacherArr,   "classId" => $classArr, "year" => $yearArr, "term" => $termArr));
                        }
                        else{
                            $row=new Models\CourseAllocationModel();
                            $row->term=$termArr;
                            $row->year=$yearArr;
                            $row->teacherId=$teacherArr;
                            $row->subject=$subjectArr;
                            $row->classId=$classArr;
                            $row->save();
                        }
                       
                        
                    }
                         return response()->json(['status'=>'success','message'=>' Subject allocated to staff successfully ']);
      
     }
     public function smsResult(Request $request,SystemController $sys){
         $class= \Session::get('class');
       $term= \Session::get('term');
       $students= \Session::get('students');
       
       $year=  \Session::get('year');
       
  
       if(!empty($year)&& !empty($term)){
           $datascore=array();
         for($i=0;$i<count($students);$i++){
            
                  // dd($students);
            $query= Models\AcademicRecordsModel::where("year",$year)
                    ->where("term",$term)
                    ->where("year",$year)
                    ->where("total",">",0)
                    ->where("class",$class)
                    ->where("indexNo",$students[$i])
                    ->get()->toArray();
                   // dd($query);
         //  $total=$help->$row->TOTAL;
         foreach($query as $row){
            //$data[$students[$i]][$b[courseId]]=$b[total];	 
	    @$datascore[$students[$i]].=$sys->getCourseByID($row['courseCode'])."=".$row['grade'].", ";
         }
         }
      
         //dd($datascore);
   
        for($i=0;$i<count($students);$i++){
           set_time_limit(1100);
			 $phone=$sys->getPhone($students[$i]);
			
			 $message="Result for ".$sys->getName($students[$i])." Form:".$class." Term:".$term." Grades: ".rtrim($datascore[$students[$i]],',');
                    dd($message);
                         $name=$sys->getName($students[$i]);
                          $sys->firesms($message, $phone, $name) ;
		        
                          

		 
	 }
       }
     }
     public function broadsheet(Request $request,SystemController $sys) {
         $class = \DB::table('classes')->orderby("name")
             ->lists('name', 'name');
         if ($request->isMethod("get")) {
              return view('courses.broadsheet')->with('year', $sys->years())
                               ->with('class', $class);
         }
         else{
           
           \Session::put('term', $request->input("term", ""));
             \Session::put('year', $request->input("year", ""));
             \Session::put('class', $request->input("class", ""));
             
             
              if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
           $headerQuery= Models\AcademicRecordsModel::where("class",$request->input("class", ""))
                 ->where("term",$request->input("term", ""))
                 ->where("year",$request->input("year", ""))
                    ->where("indexNo",$request->input("search", ""))
                 ->orderBy("courseCode")
                ->groupBy("courseCode")
                 ->get()->toArray();
        }
        else{
            $headerQuery= Models\AcademicRecordsModel::where("class",$request->input("class", ""))
                 ->where("term",$request->input("term", ""))
                 ->where("year",$request->input("year", ""))
                 ->orderBy("courseCode")
                ->groupBy("courseCode")
                 ->get()->toArray();
        }
             
             
             $courseArray=array();
            foreach($headerQuery as $row){
                //$courseArray=array();$course=$row['courseId'];
                                             $course=$row['courseCode'];
                                            if($course!=""){
                                         
                                            $courseArray[]=$course;
                                           }
                                           else{
                                              $courseArray[]="N/A"; 
                                           }
            }
          if ($request->has('search') && trim($request->input('search')) != "") {
         $studentData= Models\AcademicRecordsModel::where("class",$request->input("class", ""))
                 ->where("term",$request->input("term", ""))
                 ->where("year",$request->input("year", ""))
                  ->where("indexNo",$request->input("search", ""))
                 ->orderBy("indexNo")
                ->groupBy("indexNo")
                 ->select("indexNo")
                 ->get();                      
          }
          else{
               $studentData= Models\AcademicRecordsModel::where("class",$request->input("class", ""))
                 ->where("term",$request->input("term", ""))
                 ->where("year",$request->input("year", ""))
                 ->orderBy("indexNo")
                ->groupBy("indexNo")
                 ->select("indexNo")
                 ->get();          
          }
         return view('courses.broadsheet')->with('year', $sys->years())
                               ->with('class', $sys->getClassList())->with("headers", $headerQuery) 
                               ->with("course",   $courseArray)
                               ->with("years", $request->input("year", ""))
                               ->with("term", $request->input("term", ""))
                                ->with("className", $request->input("class", ""))
                                ->with("student", $studentData);
                 
         
            
        
         }
        
     }
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request,SystemController $sys)
    {
          if($request->user()->isSupperAdmin  ||     @\Auth::user()->department=="top"){
       
          $courses= Models\CourseModel::query() ;
          }
          elseif(@\Auth::user()->role=="HOD" || @\Auth::user()->role=="Lecturer" || @\Auth::user()->role=="Registrar") {
            $courses = Models\CourseModel::where('pcode', '!=', '')->whereHas('programs', function($q) {
            $q->whereHas('departments', function($q) {
                $q->whereIn('deptCode', array(@\Auth::user()->department));
            });
        }) ;
        }
        
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $courses->where("pcode", $request->input("program", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("classId", $request->input("level", ""));
        }
        
        
        $data = $courses->orderBy("name")->paginate(100);
        
        $request->flashExcept("_token");
          
         
        return view('courses.index')->with("data", $data)->with("class",$sys->getClassList())
                        ->with('program', $sys->getProgramList());
                 
    }
    public function viewMounted(Request $request,SystemController $sys) {
      $hod=@\Auth::user()->staffID;
      
//      if(@\Auth::user()->department=="top"){
//           $courses= Models\MountedCourseModel::query() ;
//      }
//      elseif(@\Auth::user()->role=="Lecturer"){
//          $courses= Models\MountedCourseModel::query()->where('LECTURER',@\Auth::user()->staffID) ;
//      }
//
//      else{
//          $courses= Models\MountedCourseModel::query()->where('MOUNTED_BY',$hod) ;
//      }
      
         if($request->user()->isSupperAdmin  ||     @\Auth::user()->department=="top"){
       
           $courses= Models\MountedCourseModel::query() ;
          }
          elseif(@\Auth::user()->role=="HOD" || @\Auth::user()->role=="Support" || @\Auth::user()->role=="Registrar") {
             $courses =Models\MountedCourseModel::where('COURSE', '!=', '')->whereHas('courses', function($q) {
            $q->whereHas('programs', function($q) {
                $q->whereIn('DEPTCODE', array(@\Auth::user()->department));
            });
        }) ;
        }
      
      
      
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $courses->where("PROGRAMME", $request->input("program", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("COURSE_LEVEL", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("COURSE_term", "=", $request->input("semester", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $courses->where("COURSE_year", "=", $request->input("year", ""));
        }
         
        
        $data = $courses->paginate(100);
        
        $request->flashExcept("_token");
          
         
        return view('courses.view_mounted')->with("data", $data)
                        ->with('program', $sys->getProgramList())
                        ->with('year',$sys->years());
    }
    public function gradeModification(SystemController $sys,Request $request){

        if ( @\Auth::user()->role== 'Head Master' ||  @\Auth::user()->role== 'Admin') {

           if ($request->isMethod("get")) {

            return view('courses.deleteGrades')->with('year', $sys->years())
                                ->with('class', $sys->getClassList())
                                ->with("course",$sys->getCourseList())
                              
                                 
                                ->with('program', $sys->getProgramList());
                                
                             
            } 
            
        }
        elseif(@\Auth::user()->role=='Admin' && @\Auth::user()->department=='top'){
             return view('courses.deleteGrades')->with('year', $sys->years())
                                   ->with('class', $sys->getClassList())
                                ->with("course",$sys->getCourseList())
                              
                                 
                                ->with('program', $sys->getProgramList());
                            
        }
        else{
                 return redirect("/dashboard");
            }
     }
     
      public function ProcessGradeModification(SystemController $sys,Request $request){

                 $this->validate($request, [
             
            'class'=>'required',
           
            'semester'=>'required',
            'year'=>'required',
             
                ]);
        
               //dd($request);
               $course=$request->input("course");
                $class=$request->input("class");
                $year=$request->input("year");
                $semester=$request->input("semester");
                
                if(empty($course)){
                    $query= Models\AcademicRecordsModel::where("class",$class)->where("term",$semester)
                            ->where("year",$year) ;
                }
                else{
                       $query= Models\AcademicRecordsModel::where("class",$class)->where("term",$semester)
                            ->where("year",$year)->where("courseCode",$course) ;
                       
                }
                $data=$query->get();
                  
                 foreach($data as $row){
                        $result=new Models\DeletedGradesModel();
                        $result->courseId=$row->courseId;
                        $result->courseCode=$row->courseCode;
                        $result->stuId=$row->stuId;
                        $result->indexNo=$row->indexNo;
                         
                        $result->cw1=$row->cw1;
                        $result->cw2=$row->cw2;
                        $result->cw3=$row->cw3;
                        $result->hw1=$row->hw1;
                        $result->hw2=$row->hw2;
                        $result->ctest1=$row->ctest1;
                        $result->ctest2=$row->ctest2;
                        $result->project1=$row->project1;
                        $result->project2=$row->project2;
                        $result->exam=$row->exam;
                        $result->total=$row->total;
                        $result->gpoint=$row->gpoint;
                        $result->comments=$row->comments;
                        $result->year=$row->year;
                        $result->term=$row->term;
                        $result->posInSubject=$row->posInSubject;
                        $result->class=$row->class;
                         $result->staff=$row->staff;
                      $result->inputeddate=$row->inputeddate;
                        $result->save();
                       
                            
                        }
                       
                        $query->delete();
                        
                        
                        
                        
           }
          public function gradeRecovery(SystemController $sys,Request $request){

          if ( @\Auth::user()->role== 'Head Master' ||  @\Auth::user()->role== 'Admin') {

           if ($request->isMethod("get")) {

            return view('courses.recoverGrades')->with('year', $sys->years())
                              ->with('class', $sys->getClassList())
                                ->with("course",$sys->getCourseList())
                              
                                 
                                ->with('program', $sys->getProgramList());
                            
                             
            } 
            
        }
        elseif(@\Auth::user()->role=='Admin'&& @\Auth::user()->department=='top' ){
             return view('courses.recoverGrades')->with('year', $sys->years())
                               ->with('class', $sys->getClassList())
                                ->with("course",$sys->getCourseList())
                              
                                 
                                ->with('program', $sys->getProgramList());
                            
        }
        else{
                 return redirect("/dashboard");
            }
     }
       public function ProcessGradeRecovery(SystemController $sys,Request $request){

                 $this->validate($request, [
             
            'class'=>'required',
            
            'semester'=>'required',
            'year'=>'required',
             
                ]);
          
                  $course=$request->input("course");
                $class=$request->input("class");
                $year=$request->input("year");
                $semester=$request->input("semester");
                
                if(empty($course)){
                    $query= Models\DeletedGradesModel::where("class",$class)->where("term",$semester)
                            ->where("year",$year) ;
                }
                else{
                       $query= Models\DeletedGradesModel::where("class",$class)->where("term",$semester)
                            ->where("year",$year)->where("courseCode",$course) ;
                       
                }
                $data=$query->get();
                  
                 foreach($data as $row){
                        $result=new Models\AcademicRecordsModel();
                     $result->courseId=$row->courseId;
                        $result->courseCode=$row->courseCode;
                        $result->stuId=$row->stuId;
                        $result->indexNo=$row->indexNo;
                         
                        $result->cw1=$row->cw1;
                        $result->cw2=$row->cw2;
                        $result->cw3=$row->cw3;
                        $result->hw1=$row->hw1;
                        $result->hw2=$row->hw2;
                        $result->ctest1=$row->ctest1;
                        $result->ctest2=$row->ctest2;
                        $result->project1=$row->project1;
                        $result->project2=$row->project2;
                        $result->exam=$row->exam;
                        $result->total=$row->total;
                        $result->gpoint=$row->gpoint;
                        $result->comments=$row->comments;
                        $result->year=$row->year;
                        $result->term=$row->term;
                        $result->posInSubject=$row->posInSubject;
                        $result->class=$row->class;
                         $result->staff=$row->staff;
                      $result->inputeddate=$row->inputeddate;
                        $result->save();
                       
                            
                        }
                       
                        $query->delete();
                        
                        
                        
                        
           
           
      } 
       
      
    public function viewRegistered(Request $request,SystemController $sys , User $user, Models\AcademicRecordsModel $record) {
        
        //$this->authorize('update',$record); // in Controllers
        /*if(Gate::allows('updatesss',$record)){
            abort(403,"No authorization");
        }*/
        $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        $person=@\Auth::user()->fund;
        $lecturer=@\Auth::user()->fund;

       // dd($request->user()->isSupperAdmin);
        if(@\Auth::user()->role=='Lecturer' || @\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Dean'){
            
       
        /*
         * make sure that only courses mounted for a 
         * lecturer is available to him
         */
        
          $courses= Models\AcademicRecordsModel::query()->where('staff', $person) ;
           
          
        }
        elseif($request->user()->isSupperAdmin){
             
             $courses= Models\AcademicRecordsModel::query() ;
     
        }
        else{
            //abort(420, "Illegal access detected");
             return response('Unauthorized.', 401);
        }
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where('course',   $sys->getCourseByIDCode($request->input("search", "")));
            
        }
         
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("level", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("sem", "=", $request->input("semester", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $courses->where("year", "=", $request->input("year", ""));
        }
         $data = $courses->groupby('courseCode')->paginate(100);
         
         $request->flashExcept("_token");
         
         foreach ($data as $key => $row) {
                   
                    $arr=$sys->getCourseCodeByID($row->courseCode);
                   // dd($arr);
                     $data[$key]->CODE=$arr;

                     $total=$sys->totalRegistered($sem,$year,$row->courseCode,$row->level, $lecturer);
                     $data[$key]->REGISTERED=$total;
                }
        
                 
          
         
        return view('courses.registered_courses')->with("data", $data)
                        ->with('program', $sys->getProgramList())
                        ->with('year',$sys->years());
                        
           
    }
     public function mountCourse(SystemController $sys) {
          if(@\Auth::user()->role=='HOD' || @\Auth::user()->role=='Support' || @\Auth::user()->role=='Registrar'){
        $programme=$sys->getProgramList();
        
        $course=$sys->getCourseList();
        //$lecturer=$sys->getLectureList();
        $allLectureres=$sys->getLectureList_All();
       // $totalLecturers = array_merge( $lecturer, $allLectureres);
         return view('courses.mount')->with('program', $programme)
                 ->with('course', $course)
                 ->with('lecturer',$allLectureres);
          }
          else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    
    public function create(SystemController $sys) {
       if(@\Auth::user()->role=='Admin' || @\Auth::user()->department=='top'){
        $programme=$sys->getProgramList();
         return view('courses.create')->with('programme', $programme);
       }
       else{
            return redirect("/dashboard");
        }
    }
    public function show(Request $request) {
        
    }
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if(@\Auth::user()->department=='top' || @\Auth::user()->role=='Admin'){
        \DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required',
               
                'code' => 'required',
                 'type' => 'required',
                 
            ]);

            $user=@\Auth::user()->fund;

            $name = strtoupper($request->input('name'));
            $program = strtoupper($request->input('program'));
            $code = strtoupper($request->input('code'));
            $type =  $request->input('type') ;

            $course = new Models\CourseModel();
            $course->name = $name;
            
            $course->code = $code;
            $course->type = $type;
            $course->createdBy= $user;
             

            if ($course->save()) {
                 \DB::commit();
                return redirect("/courses")->with("success", "<span style='font-weight:bold;font-size:13px;'> $name added successfully</span> ");
            } else {

                return redirect("/courses")->with("<span style='font-weight:bold;font-size:13px;'> $name could not be added </span>!");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
        }
        else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function mountCourseStore(Request $request, SystemController $sys) {
      if(@\Auth::user()->role=='HOD' || @\Auth::user()->role=='Support' || @\Auth::user()->role=='Registrar'){
        \DB::beginTransaction();
        try {
            $this->validate($request, [
                'course' => 'required',
                'program' => 'required',
                'lecturer' => 'required',
                'level' => 'required',
                'credit' => 'required',
                'semester' => 'required',
                
                'year' => 'required'
            ]);


            $course = $request->input('course');
            $program = $request->input('program');
            $level = $request->input('level');
            $semester = $request->input('semester');
            $credit = $request->input('credit');
            $year = $request->input('year');
            $lecturer = $request->input('lecturer');
            $type = $request->input('type');
            if($request->input('type')==""){
               $type="Core"; 
            }
            else{
                 $type = $request->input('type');
            }
            $hod = $request->user()->id;
            $mountedCourse = new Models\MountedCourseModel();
            $mountedCourse->COURSE = $course;
            $mountedCourse->COURSE_CREDIT = $credit;
            $mountedCourse->COURSE_term = $semester;
            $mountedCourse->COURSE_LEVEL = $level;
            $mountedCourse->COURSE_TYPE = $type;
            $mountedCourse->PROGRAMME = $program;
            $mountedCourse->LECTURER = $lecturer;
            $mountedCourse->COURSE_year = $year;
            $mountedCourse->MOUNTED_BY = $hod;



            if ($mountedCourse->save()) {
                \DB::commit();
                $CourseArray=$sys->getCourseCodeByIDArray($course);
                $courseName=$CourseArray[0]->COURSE_NAME;
                $courseCode=$CourseArray[0]->COURSE_CODE;
                $staffArray=$sys->getLecturer($lecturer);
                $lecturerName=$staffArray[0]->name;
                $lecturePhone=$staffArray[0]->phone;
                $lectureStaffID=$staffArray[0]->staffID;
                $programCode=$sys->getProgram($program);
                $message="Hi, $lecturerName, you have been assigned $courseName, $courseCode, $programCode, year $level, $year, sem $semester";
                //dd($message);
               // $sys->firesms($message, $lecturePhone,$lectureStaffID );
                return redirect("/mounted_view")->with("success", "well done:<span style='font-weight:bold;font-size:13px;'> course mounted</span>successfully  ");
            } else {

                return redirect("/mounted_view")->withErrors("Whoops N<u>o</u> :<span style='font-weight:bold;font-size:13px;'> course could not be mounted </span>could not be added!");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
      }
        else{
           throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function enterMark($course,$code, SystemController $sys ,Models\AcademicRecordsModel $record ){
         //$this->authorize('update',$record); // in Controllers
        if(@\Auth::user()->role=='Class Teacher' ||@\Auth::user()->role=='House Mistress'||@\Auth::user()->role=='Class Teacher'  ||@\Auth::user()->role=='Lecturer' || @\Auth::user()->department=='top'  ){
        $array=$sys->getSemYear();
        $sem=$array[0]->term;
        $year=$array[0]->year;

        $lecturer=@\Auth::user()->fund;
         
        $resultOpen=$array[0]->enterResult;
        if($resultOpen==1){
        $mark = Models\AcademicRecordsModel::where('courseCode',$code)
                 ->where('class',$course)
                ->where('staff',$lecturer)
                ->where('year',$year)
                ->where('term',$sem)
                ->orderBy("indexno")
                ->paginate(20);
        $total=count($mark);
        $courseName=$sys->getCourseByID($code);
           
        return view('courses.markSheet')->with('mark', $mark)
            ->with('year', $year)
            ->with('sem', $sem)
            ->with('mycode', $code)
            ->with('course', $courseName)
            ->with('total', $total);
        }
        else{
              abort(434, "{!!<b>Entering of marks has ended contact the Dean of your School</b>!!}");
              redirect("/class/l sist");
              
        }
        }
        else{
              return redirect("/dashboard");
              
        }
    }
    public function marksDownloadExcel( $code, SystemController $sys )

	{
        $array=$sys->getSemYear();
        $sem=$array[0]->term;
        $year=$array[0]->year;

        $lecturer=@\Auth::user()->fund;

          $data=Models\AcademicRecordsModel::
                join('student', 'assesmentsheet.indexNo', '=', 'student.indexNo')
                ->where('assesmentsheet.courseCode',$code)
                ->where('assesmentsheet.staff',$lecturer)
                ->where('assesmentsheet.year',$year)
                ->where('assesmentsheet.term',$sem)
                ->select('student.indexNo','student.name','assesmentsheet.cw1','assesmentsheet.cw2','assesmentsheet.cw3','assesmentsheet.hw1','assesmentsheet.hw2','assesmentsheet.ctest1','assesmentsheet.ctest2','assesmentsheet.project1','assesmentsheet.project2','assesmentsheet.exam')->get();
          	 
		return Excel::create('continuous_assessment', function($excel) use ($data) {

			$excel->sheet('mySheet', function($sheet) use ($data)

	        {

				$sheet->fromArray($data);

	        });

		})->download('xls');


	}
    // public function printAttendance($course,$code, SystemController $sys){
    //    if(@\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Lecturer' || @\Auth::user()->department=='top'  ){
     
    //     $array=$sys->getSemYear();
    //     $sem=$array[0]->term;
    //     $year=$array[0]->year;
         
    //     $mark = Models\AcademicRecordsModel::where("course", $course)->where('year',$year)->where('sem',$sem)->paginate(100);
    //     $total=count($mark);
    //     $courseName=$sys->getCourseByID($code);
           
    //     return view('courses.attendanceSheet')->with('mark', $mark)
    //         ->with('year', $year)
    //         ->with('sem', $sem)
    //         ->with('course', $courseName)
    //         ->with('total', $total);
    //     }
         
       
    //    else{
    //         throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
    //    }
    // }
     public function storeMark($course,$code, SystemController $sys,Request $request){
         //dd($request);
        //$this->authorize('update',$record);
        /* if (Gate::denies('update', $record)) {
          abort(403);
          } */
        if (@\Auth::user()->role == 'Class Teacher' || @\Auth::user()->role == 'House Mistress' || @\Auth::user()->role == 'House Master' ||@\Auth::user()->role == 'Lecturer' || @\Auth::user()->department == 'top') {


            $array = $sys->getSemYear();
            $sem = $request->input('term');
            $year = $request->input('year');
            $resultOpen = $array[0]->enterResult;
            $course = $request->input('course');
                      $courseCode = $request->input('courseCode');
                    $courseArr= $sys->getCourseMountedInfo($course);
                          //  dd($course);
                    $lecturer= $courseArr[0]->teacherId;
            if ($resultOpen == 1) {
               
                    $host = $_SERVER['HTTP_HOST'];
                    $ipAddr = $_SERVER['REMOTE_ADDR'];
                    $userAgent = $_SERVER['HTTP_USER_AGENT'];
                   
                    $upper = $request->input('upper');
                    $key = $request->input('key');
                    $student = $request->input('student');
                     $class = $request->input('class');
                    $cw1 = $request->input('cw1');
                    $cw2 = $request->input('cw2');
                    $cw3 = $request->input('cw3');
                    
                    $hw1 = $request->input('hw1');
                    
                    $hw2 = $request->input('hw2');
                    
                    $ctest1 = $request->input('ctest1');
                    $ctest2 = $request->input('ctest2');
                    
                    $project1 = $request->input('project1');
                    $project2 = $request->input('project2');
                    
                    $exam = $request->input('exam');
                    
                     
                    
                    $cw1Old = $request->input('cw1Old');
                    $cw2Old = $request->input('cw2Old');
                    $cw3Old = $request->input('cw3Old');
                    $hw1Old = $request->input('hw1Old');
                    $hw2Old = $request->input('hw2Old');
                    $ctest1Old = $request->input('ctest1Old');
                    $ctest2Old = $request->input('ctest2Old');
                    $project1Old = $request->input('project1Old');
                    $project2Old = $request->input('project2Old');
                    
                    $examOld = $request->input('examOld');
                    
                    for ($i = 0; $i < $upper; $i++) {
                        $keyData = $key[$i];
                        $studentData = $student[$i];
                        $cw1Data = $cw1[$i];
                        $cw2Data = $cw2[$i];
                        $cw3Data = $cw3[$i];
                        
                         $hw1Data = $hw1[$i];
                         $hw2Data = $hw2[$i];
                        
                         $ctest1Data = $ctest1[$i];
                         $ctest2Data = $ctest2[$i];
                         
                         $project1Data = $project1[$i];
                         $project2Data = $project2[$i];
                          
                        $examData = $exam[$i];
                        // for logging
                        $cw1OldData = $cw1Old[$i];
                        $cw2OldData = $cw2Old[$i];
                        $cw3OldData = $cw3Old[$i];
                        
                        $hw1OldData = $hw1Old[$i];
                        $hw2OldData = $hw2Old[$i];
                        
                        $ctest1OldData = $ctest1Old[$i];
                         $ctest2OldData = $ctest2Old[$i];
                         
                          $project1OldData = $project1Old[$i];
                             $project2OldData = $project2Old[$i];
                        $examOldData = $examOld[$i];
                        $fortyPercent = $cw1Data + $cw2Data + $cw3Data + $hw1Data+ $hw2Data+ $ctest1Data+ $ctest2Data+ $project1Data+ $project2Data;
                     
                        $examTotal = $examData;
                        
                        $total =( 0.5*$fortyPercent) +(0.5 * $examTotal);
  
                        $OldfortyPercent = $cw1OldData + $cw2OldData + $cw3OldData + $hw1OldData+ $hw2OldData+ $ctest1OldData+ $ctest2OldData+ $project1OldData+ $project2OldData;
                        $oldExam = $examOldData;
                        $oldClassScore = $OldfortyPercent;

                        $examLog = new Models\GradeLogModel();
                        $examLog->actor = $lecturer;
                        $examLog->student = $studentData;
                        $examLog->course = $courseCode;
                        $examLog->oldClassScore = $oldClassScore;
                        $examLog->newClassScore = 0.5*$fortyPercent;
                        $examLog->oldExamScore = $oldExam;
                        $examLog->newExamScore = 0.5*$examTotal;
                           $examLog->term = $sem;
                            $examLog->year= $year;
                        $examLog->ip = $ipAddr;
                        $examLog->host = $host;
                        $examLog->userAgent = $userAgent;
                        if ($examLog->save()) {
                            
                            
                            //$programme=$sys->getCourseProgrammeMounted( $courseCode);
                            
                           // $program=$sys->getProgramArray("PRI");
                              $gradeSys=$sys->getProgramByGradeSystem("PRI");
                                 //  dd($gradeSys);
                            $gradeArray = $sys->getGrade($total, $gradeSys);
                        
                              @$grade = $gradeArray[0]->grade;
                              @$gradePoint=@$gradeArray[0]->value;
                               @$comment=@$gradeArray[0]->comment;
                                
                            @Models\AcademicRecordsModel::where("id", $keyData)->where('staff', $lecturer)->update(array("cw1" => $cw1Data, "cw2" => $cw2Data, "cw3" => $cw3Data, "hw1" => $hw1Data,"hw2" => $hw2Data, "ctest1" => $ctest1Data,"ctest2" => $ctest2Data,"project1" => $project1Data,"project2" => $project2Data,"exam" => $examTotal, "total" => $total, 'grade' => $grade, 'gpoint' => $gradePoint,'comments'=>$comment));
                            //Prepare("update tbl_class_members set total='$row[total]' where STUDENT='$indexno_' and  year='$school->YEAR' and term='$school->TERM'")  ;
                            
                            $totalScore= Models\AcademicRecordsModel::where("indexNo",$studentData)->where("year",$year)->where("term",$sem)->sum("total");
                             
                            
                            $totalMember=Models\ClassMembersModel::where("student",$studentData)->where("year",$year)->where("term",$sem)->count();
                            
                            if(empty($totalMember)){
                                 
                                $member=new Models\ClassMembersModel();
                                $member->student=$studentData;
                                $member->class=$class;
                                $member->total=$totalScore;
                                $member->term=$sem;
                                $member->year=$year;
                                $member->save();
                                    
                            }
                            else{
                               Models\ClassMembersModel::where("student",$studentData)->where("year",$year)->where("term",$sem)->update(array("total"=>$totalScore)); 
                            }
                            
                  ////////////////////////////////////////////////////////////
                    // Starting position in subject
                   ////////////////////////////////////////////////////////////
                            $rankQuery= Models\AcademicRecordsModel::where("courseCode",$courseCode)->where("class",$class)
                                                ->where("term",$sem)
                                                ->where("year",$year)->orderBy("total","Desc")->get();
                            
                            
                            
                              
                     $counter=0;
                     
                     $row=count($rankQuery);
                     $oldtotal=-1;
                     $repeat=0;
                    foreach($rankQuery as $query){
                
                    $counter++;
                    $currentotal=$query->total;
                     
                    if($oldtotal==$currentotal){}else{$in=$counter; }
                     $oldtotal=$currentotal;
                     $position=$counter."/".$row;
                    
                      
                      
                      Models\AcademicRecordsModel::where("id",$query->id)->update(array("posInSubject"=>$position));
                     
                     }
                            
                            
                            ////////////////////////////////////////////////////////////////////////
                     // starting overall position in class ie class average
                     /////////////////////////////////////////////////////////////////////////
                     $querySubjectPosition= Models\ClassMembersModel::where("class",$class)
                                                        ->where("year",$year)
                                                        ->where("term",$sem)
                                                        ->orderBy("total","Desc")
                                                        ->get();
                       
                     
                        $index=0;
                            $inx=0;
                        $row2=count($querySubjectPosition);
                        foreach($querySubjectPosition as $input){
                       

                        $index++;
                        $currentotal=$input->total;
                        if($oldtotal==$currentotal){}else{$inx=$index; }
                         $oldtotal=$currentotal;

                          $subjectPosition=$inx."/".$row2;
                         //echo "_";
                           //print_r($in_);
                          
                          Models\ClassMembersModel::where("id",$input->id)
                                        ->where("year",$year)
                                        ->where("term",$sem)
                                        ->update(array("position"=>$subjectPosition));

                      }
                            
                            
                            
                            
                            
                            
                           // \DB::commit();
                            
                        }
                        
                    }
               
                $mark = Models\AcademicRecordsModel::where("courseCode", $courseCode)->where('staff', $lecturer)
                    ->where('class', $class)
                    ->where('year', $year)->where('term', $sem)->paginate(25);
               //dd($mark);
                $total = count($mark);
                $courseName = $sys->getCourse($courseArr[0]->subject);

                  
                return view('courses.markSheet')->with('mark', $mark)
                                ->with('year', $year)
                                ->with('sem', $sem)
                                 ->with('mycode', $code)
                                ->with('course', $courseName)
                                ->with('total', $total);
            } else {
                throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Entering of marks has been closed.');
      
                }
        } else {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
      
        }
        
    }
     public function attendanceSheet(Request $request,SystemController $sys){
    if(@\Auth::user()->role=='HOD' || @\Auth::user()->department=='top'|| @\Auth::user()->role=='Admin' || @\Auth::user()->role=='Lecturer'){
           if ($request->isMethod("get")) {
             $course=$sys->getCourseList();
             $class=$sys->getClassList();

             return view('courses.attendanceSheet')
             ->with('courses',$course)->with('year',$sys->years())->with("class", $class);
            }
           else{

                $term= $request->input('term');
                $year = $request->input('year');
                $course =  $request->input('course') ;
                $class= $request->input('class');
             
                $mark = Models\AcademicRecordsModel::where("courseCode", $course)->where('year',$year)->where('term',$term)->where('class',$class)->paginate(100);
            
                  $courseArr= $sys->getCourseObject($course);
                          
                            $displayCourse=$courseArr[0]->name;
                            $displayCode=$courseArr[0]->code;
                            \Session::put('year', $year);
                            $url = url('printAttendance/'.$term.'/sem/'.$displayCourse.'/course/'.$displayCode.'/code/'.$class.'/level/'.$course.'/id');
                  
                          $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                $request->session()->flash("success",
                "    $print_window");
                 return redirect("/attendanceSheet");
                 
            // return view('courses.printAttendance')->with('mark', $mark)
            //     ->with('year', $year)
            //     ->with('sem', $semester)
            //     ->with('course', $displayCourse)
            //     ->with('code', $displayCode);

                
           }
       }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function printAttendance(Request $request,$semester,$course,$code,$level,$id) {
      $year=\Session::get('year');
  $mark = Models\AcademicRecordsModel::where("courseCode", $id)->where('year',$year)->where('term',$semester)->where('class',$level)->paginate(100);
            
      return view('courses.printAttendance')->with('mark', $mark)
                ->with('year', $year)
                ->with('sem', $semester)
                ->with('course', $course)
                ->with('code', $code);
          
        
    }
    public function showFileUpload(SystemController $sys){
       if(@\Auth::user()->department=='Academic' || @\Auth::user()->department=='top'|| @\Auth::user()->role=='Admin' || @\Auth::user()->role=='Lecturer'){
         $class=$sys->getClassList();
         $course=$sys->getMountedCourseListLecturer(@\Auth::user()->fund);

         return view('courses.markUpload')->with('class', $class)
         ->with('courses',$course)->with('year',$sys->years());
       }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }
    public function uploadMarks(Request $request, SystemController $sys){

      $this->validate($request, [
            
            'file' => 'required',
            'course' => 'required',
            'term' => 'required',
            'year' => 'required',
            'class' => 'required',
        ]);
         if(@\Auth::user()->department=='Academic' || @\Auth::user()->department=='top'|| @\Auth::user()->role=='Admin' || @\Auth::user()->role=='Lecturer'){
            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;
            $resultOpen = $array[0]->enterResult;
            $lecturer=\Auth::user()->fund;
            if ($resultOpen == 1) {
           

            $valid_exts = array('csv', 'xls', 'xlsx'); // valid extensions
            $file = $request->file('file');
            $path = $request->file('file')->getRealPath();

            $ext = strtolower($file->getClientOriginalExtension());
            
            $semester = $request->input('term');
            $sem= $request->input('term');
            $year = $request->input('year');
            $course =  $request->input('course') ;
            //$programme = $request->input('program');
            $class = $request->input('class');
           // $studentIndexNo =$request->input('student');
                   
             
           if (in_array($ext, $valid_exts)) {
               
                    $data = Excel::load($path, function($reader) {
                            
                        })->get();
                if (!empty($data) && $data->count()) {  
                

                       foreach ($data as $key => $value) {

                            $totalRecords = count($data);

                            
                          
                        //$studentDb= $sys->getStudentIDfromIndexno('0'.$value->index_no);
                        //print_r($value);
                            
                         $studentDb= $value->indexno  ;  
                         $studentData=$value->indexno  ;  
                          $courseName=$sys->getCourseObject($course);
                            $displayCourse=$courseName[0]->name;
                            $displayCode=$courseName[0]->code;
            //$studentSearch = $sys->studentSearchByCode($year,$semester,$course,$studentDb); // check if the students in the file tally with registered students
                       //dd($studentDb);
                         
                            $indexNo=$value->indexno;
                            $cw1=$value->cw1;
                            $cw2=$value->cw2;
                            $cw3=$value->cw3;
                            
                            $exam=$value->exam;
                            
                            $hw1=$value->hw1;
                            $hw2=$value->hw2;
                            
                            $ctest1=$value->ctest1;
                            $ctest2=$value->ctest2;
                            
                            $project1=$value->project1;
                            $project2=$value->project2;
                             
                        
                       
                            $fortyPercent= round(($cw1+$cw2+$cw3+$hw1+$hw2+$ctest1+$ctest2+$project1+$project2),2);
                            

                             $examTotal = $exam;
                        
                             $total =( 0.5*$fortyPercent) +(0.5 * $examTotal);
  
//dd($total);
                            $programmeDetail=$sys->getCourseProgrammeMounted($course);
                            
                           $programme=$sys->getCourseProgrammeMounted($course);
                            
                            $program=$sys->getProgramArray($programme);
                              $gradeSys=$sys->getProgramByGradeSystem("PRI");
                              
                            $gradeArray = $sys->getGrade($total, $gradeSys);
                          // $gradeArray = $sys->getGrade($total, $gradeSys);
                       // dd($gradeArray);
                              $grade = $gradeArray[0]->grade;
                              $gradePoint=@$gradeArray[0]->value;
                               $comment=@$gradeArray[0]->comment;
                                
                            Models\AcademicRecordsModel::where("indexNo",$indexNo)->where('staff', $lecturer)->update(array("cw1" => $cw1, "cw2" => $cw2, "cw3" => $cw3, "hw1" => $hw1,"hw2" => $hw2, "ctest1" => $ctest1,"ctest2" => $ctest2,"project1" => $project1,"project2" => $project2,"exam" => $examTotal, "total" => $total, 'grade' => $grade, 'gpoint' => $gradePoint,'comments'=>$comment));
                            //Prepare("update tbl_class_members set total='$row[total]' where STUDENT='$indexno_' and  year='$school->YEAR' and term='$school->TERM'")  ;
                            
                            $totalScore= Models\AcademicRecordsModel::where("indexNo",$studentData)->where("year",$year)->where("term",$sem)->sum("total");
                             
                            
                            $totalMember=Models\ClassMembersModel::where("student",$studentData)->where("year",$year)->where("term",$sem)->count();
                            
                            if(empty($totalMember)){
                                 
                                $member=new Models\ClassMembersModel();
                                $member->student=$studentData;
                                $member->class=$class;
                                $member->total=$totalScore;
                                $member->term=$sem;
                                $member->year=$year;
                                $member->save();
                                    
                            }
                            else{
                               Models\ClassMembersModel::where("student",$studentData)->where("year",$year)->where("term",$sem)->update(array("total"=>$totalScore)); 
                            }
                            
                  ////////////////////////////////////////////////////////////
                    // Starting position in subject
                   ////////////////////////////////////////////////////////////
                            $rankQuery= Models\AcademicRecordsModel::where("courseCode",$course)->where("class",$class)
                                                ->where("term",$sem)
                                                ->where("year",$year)->orderBy("total","Desc")->get();
                            
                            
                            
                              
                     $counter=0;
                     
                     $row=count($rankQuery);
                     $oldtotal=-1;
                     $repeat=0;
                    foreach($rankQuery as $query){
                
                    $counter++;
                    $currentotal=$query->total;
                     
                    if($oldtotal==$currentotal){}else{$in=$counter; }
                     $oldtotal=$currentotal;
                     $position=$counter."/".$row;
                    
                      
                      
                      Models\AcademicRecordsModel::where("id",$query->id)->update(array("posInSubject"=>$position));
                     
                     }
                            
                            
                            ////////////////////////////////////////////////////////////////////////
                     // starting overall position in class ie class average
                     /////////////////////////////////////////////////////////////////////////
                     $querySubjectPosition= Models\ClassMembersModel::where("class",$class)
                                                        ->where("year",$year)
                                                        ->where("term",$sem)
                                                        ->orderBy("total","Desc")
                                                        ->get();
                       
                     
                        $index=0;
 
                        $row2=count($querySubjectPosition);
                        foreach($querySubjectPosition as $input){
                       

                        $index++;
                        $currentotal=$input->total;
                        if($oldtotal==$currentotal){}else{$inx=$index; }
                         $oldtotal=$currentotal;

                          $subjectPosition=$inx."/".$row2;
                         //echo "_";
                           //print_r($in_);
                          
                          Models\ClassMembersModel::where("id",$input->id)
                                        ->where("year",$year)
                                        ->where("term",$sem)
                                        ->update(array("position"=>$subjectPosition));

                      }
                            
                            
                            
                            
                              
                                   
                                
                         
                        }
                          
                         
                        return redirect('/report/broadsheet')->with("success",  " <span style='font-weight:bold;font-size:13px;'> $totalRecords Marks  successfully uploaded for  $displayCourse - $displayCode!</span> ");
                             
                    
                } else {
                     return redirect('/upload/marks')->with("error", " <span style='font-weight:bold;font-size:13px;'>File is empty</span> ");
                                   
                }
            } else {
                 return redirect('/upload/marks')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload only Excel file!</span> ");
                    
            }


              

        }
       else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
      }
        else{
               
              redirect("/dashboard")->with('error','Entering of marks has ended contact the Dean of your School');
              
        }
    }
    // show form for edit resource
    public function edit(Request $request,$id,SystemController $sys){
        if (@\Auth::user()->department == 'top' || @\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support') {
           

                $course = Models\CourseModel::where("id", $id)->firstOrFail();
                $program = $sys->getProgramList2();
                return view('courses.edit')->with("key",$id)
                                ->with("program", $program)
                                ->with('data', $course)
                                  ;
        }
        else{
            // throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');

            return redirect("/dashboard");
        }
    }

    public function update(Request $request){
        
                $this->validate($request, [


                   
                    'name' => 'required',
                    'code' => 'required',
                       'type' => 'required',
                    
                ]);
                  $name=$request->input("name");
                    $code=$request->input("code");
                     $type=$request->input("type");
                    $program=$request->input("program");
                     $id=$request->input("id");
                   // dd($program);
                \DB::beginTransaction();
                try {
                   
                    $query = @Models\CourseModel::where("id", $id)->update(array("name" => $name, "type"=>$type,"code" => $code ));
                    \DB::commit();
                     
                        if( $query){
                        return response()->json(['status'=>'success','message'=>$name.' edited successfully ']);
      
                       }
                       else{
                           return response()->json(['status'=>'error','message'=>$name.' editing failed. try again ']);
       
                       }
                    
                } catch (\Exception $e) {
                    \DB::rollback();
                }
           
        
        
    }
      
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request,   SystemController $sys)
    {
        //dd($request->input("id"));
       if(@\Auth::user()->role=='Admin' ||  @\Auth::user()->department=='top'){
           $hod=@\Auth::user()->fund;
            $array=$sys->getSemYear();
            $sem=$array[0]->term;
            $year=$array[0]->year;

        
            $query1= Models\CourseModel::where('id',$request->input("id"))->delete();
             
          
            
             if($query1){
                
                 // \DB::commit();
               return redirect("/courses")->with("success","<span style='font-weight:bold;font-size:13px;'> Course  successfully deleted!</span> ");
         
             }
             else{
                 
                  
               return redirect("/courses")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you are not the owner of this course</span> ");
             }
            
          } 
//          else{
//                return redirect("/courses")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you cannot delete a mounted course</span> ");
//           
//          }
           
        
       else {
           // abort(434, "{!!<b>Unauthorize Access detected</b>!!}");
            redirect("/dashboard");
        }
         
    }
     public function destroyAllocatedCourse(Request $request,   SystemController $sys)
    {
        //dd($request->input("id"));
       if(@\Auth::user()->role=='Admin' ||  @\Auth::user()->department=='top'){
           $hod=@\Auth::user()->fund;
            
        
            $query1= Models\CourseAllocationModel::where('id',$request->input("id"))->delete();
             
          
            
             if($query1){
                
               //   \DB::commit();
               return redirect("teachers/subject/allocation")->with("success","<span style='font-weight:bold;font-size:13px;'> Course allocation successfully deleted!</span> ");
         
             }
             else{
                 
                  
               return redirect("teachers/subject/allocation")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you are not the allocator of this course sorry</span> ");
             }
            
          } 
//          else{
//                return redirect("/courses")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you cannot delete a mounted course</span> ");
//           
//          }
           
        
       else {
           // abort(434, "{!!<b>Unauthorize Access detected</b>!!}");
            redirect("/dashboard");
        }
         
    }
       public function courseDownloadExcel($type)

	{

         
		$data = Models\CourseModel::select('name','code','pcode')->take(5)->get()->toArray();

		return Excel::create('courses_example', function($excel) use ($data) {

			$excel->sheet('mySheet', function($sheet) use ($data)

	        {

				$sheet->fromArray($data);

	        });

		})->download($type);

	}
        
   // naptex broadsheet view
         public function naptexBroadsheet(Request $request, SystemController $sys){

//      $this->validate($request, [
//            
//            'file' => 'required',
//            'course' => 'required',
//            'sem' => 'required',
//            'year' => 'required',
//            'level' => 'required',
//        ]);
         if (@\Auth::user()->role == 'HOD' || @\Auth::user()->department == 'top' || @\Auth::user()->role == 'Dean' || @\Auth::user()->role == 'Lecturer') {
             if ($request->isMethod("get")) {

            return view('courses.broadsheet_naptex');
                             
            } 
            else{
                
            }
        }
    }
    
    // noticeboard broadsheet
     
         public function noticeBoardBroadsheet(Request $request, SystemController $sys){

//      $this->validate($request, [
//            
//            'file' => 'required',
//            'course' => 'required',
//            'sem' => 'required',
//            'year' => 'required',
//            'level' => 'required',
//        ]);
         if (@\Auth::user()->role == 'HOD' || @\Auth::user()->department == 'top' || @\Auth::user()->role == 'Dean' || @\Auth::user()->role == 'Lecturer') {
             if ($request->isMethod("get")) {

            return view('courses.noticeboard');
                             
            } 
            else{
                
            }
        }
    }

}

