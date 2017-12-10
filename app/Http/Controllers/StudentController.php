<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\StudentModel;
use App\Models\ProgrammeModel;
use App\Models;
use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;
class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        //$this->generateAccounts();
//        $query=  \App\Models\StudentModel::where("LEVEL","!=","")->get();
//        foreach($query as $index=>$row){
//        $que=Models\PortalPasswordModel::where("username",$row->STNO)->first();  
//                  if(empty($que)){
//                   
//                   $real=strtoupper(str_random(9));
//                   
//                    Models\PortalPasswordModel::create([
//                    'username' => $row->STNO,
//                     'real_password' =>$real,
//                          'level' =>$row->LEVEL,
//                         'programme' =>$row->PROGRAMMECODE,
//                    'password' => bcrypt($real),
//                  ]);}
//        }
    }
    public function generateAccounts() {
        ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
         $user=  Models\PortalPasswordModel::where('year','2016/2017')->where('level','100')->get();
         foreach($user as $users=>$row){
             
             $student=$row->username;
             $password=  strtoupper(str_random(9));
             $hashedPassword = bcrypt($password);
             
             Models\PortalPasswordModel::where('username',$student)->where('level','100')->update(array("password" => $hashedPassword,'real_password'=>$password));
             
         } 
         
    }
    public function index(Request $request, SystemController $sys) {
      $class= Models\CourseAllocationModel::where("teacherId",@\Auth::user()->fund)->select("classId")->groupBy('classId')->get()->toArray();
  //dd($class);
         if($request->user()->isSupperAdmin || @\Auth::user()->role=="Admin" ||     @\Auth::user()->department=="top"||    @\Auth::user()->department=="Finance"){
        $student = StudentModel::query();
         }
         
         else{
          
        $student = StudentModel::where('indexNo', '!=', "")->whereHas('classes', function($q)use($class) {
         
               $q->whereIn('currentClass',  $class);
           
        }) ;
         }
  
        
         
         
        if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $student->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('forms') && trim($request->input('forms'))) {
           $student->where("currentClass", "LIKE", "%".$request->input('forms')."%");
        }
        if ($request->has('class') && trim($request->input('class')) != "") {
            $student->where("currentClass", $request->input("class", ""));
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $student->where("programme", $request->input("program", ""));
        }
        if ($request->has('status') && trim($request->input('status')) != "") {
            $student->where("status", $request->input("status", ""));
        }
        if ($request->has('type') && trim($request->input('type')) != "") {
            $student->where("studentType", $request->input("type", ""));
        }
        if ($request->has('group') && trim($request->input('group')) != "") {
            $student->where("yearGroup", $request->input("yearGroup", ""));
        }
        if ($request->has('nationality') && trim($request->input('nationality')) != "") {
            $student->where("nationality", $request->input("country", ""));
        }
        if ($request->has('region') && trim($request->input('region')) != "") {
            $student->where("region", $request->input("region", ""));
        }
        if ($request->has('gender') && trim($request->input('gender')) != "") {
            $student->where("gender", $request->input("gender", ""));
        }
        if ($request->has('sms') && trim($request->input('sms')) != "") {
            $student->where("SMS_SENT", $request->input("sms", ""));
        }
        if ($request->has('house') && trim($request->input('house')) != "") {
            $student->where("house", $request->input("house", ""));
        }
        if ($request->has('fee_status') && trim($request->input('fee_status')) != "") {
            if($request->input('fee_status')=="owing"){
            $student->where("totalOwing",">","0.00");
            }
           else{
            $student->where("totalOwing","<=","0.00");
            }
        }
          
          
        
        if ($request->has('religion') && trim($request->input('religion')) != "") {
            $student->where("religion", $request->input("religion", ""));
        }
        if ($request->has('search') && trim($request->input('search')) != "" && trim($request->input('by')) != "") {
            // dd($request);
            $student->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%")
               ->orWhere("indexNo","LIKE", "%" . $request->input("search", "") . "%");
        }
        $data = $student->orderBy('currentClass')->orderBy('programme')->orderBy('indexNo')->paginate(300);

        $request->flashExcept("_token");

        \Session::put('students', $data);
        return view('students.index')->with("data", $data)
                        ->with('year', $sys->years())
                        ->with('nationality', $sys->getCountry())
                         
                        ->with('religion', $sys->getReligion())
                        ->with('region', $sys->getRegions())
                        ->with('department', $sys->getDepartmentList())
                        ->with('class', $sys->getClassList())
                        ->with('house', $sys->getHouseList())
                        ->with('programme', $sys->getProgramList())
                      ;
        
        
    }
     public function sms(Request $request, SystemController $sys){
         ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
         $message = $request->input("message", "");
        $query = \Session::get('students');
        


        foreach($query as $rtmt=> $member) {
            $NAME = $member->NAME;
            $FIRSTNAME = $member->FIRSTNAME;
            $SURNAME = $member->SURNAME;
            $PROGRAMME = $sys->getProgram($member->PROGRAMME);
            $INDEXNO = $member->INDEXNO;
            $CGPA = $member->CGPA;
            $BILLS = $member->BILLS;
            $BILL_OWING = $member->BILL_OWING;
            $PASSWORD=$sys->getStudentPassword($INDEXNO);
            $newstring = str_replace("]", "", "$message");
            $finalstring = str_replace("[", "$", "$newstring");
            eval("\$finalstring =\"$finalstring\" ;");
             if ($sys->firesms($finalstring,$member->TELEPHONENO,$member->INDEXNO)) {

                 StudentModel::where("INDEXNO",$INDEXNO)->update(array("SMS_SENT","1"));
               
            } else {
               // return redirect('/students')->withErrors("SMS could not be sent.. please verify if you have sms data and internet access.");
            }
        }
          return redirect('/students')->with('success','Message sent to students successfully');
         
         \Session::forget('students');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getIndex(Request $request)
    {
        
        return view('students.index');
    }
    public function anyData(Request $request)
    {
         
        $students = StudentModel::join('tpoly_programme', 'tpoly_students.PROGRAMMECODE', '=', 'tpoly_programme.PROGRAMMECODE')
           ->select(['tpoly_students.ID', 'tpoly_students.NAME','tpoly_students.INDEXNO', 'tpoly_programme.PROGRAMME','tpoly_students.LEVEL','tpoly_students.INDEXNO','tpoly_students.SEX','tpoly_students.AGE','tpoly_students.TELEPHONENO','tpoly_students.COUNTRY','tpoly_students.GRADUATING_GROUP','tpoly_students.STATUS']);
         


        return Datatables::of($students)
                         
            ->addColumn('action', function ($student) {
                 return "<a href=\"edit_student/$student->INDEXNO/id\" class=\"\"><i title='Click to view student details' class=\"md-icon material-icons\">&#xE88F;</i></a>";
                 // use <i class=\"md-icon material-icons\">&#xE254;</i> for showing editing icon
                //return' <td> <a href=" "><img class="" style="width:70px;height: auto" src="public/Albums/students/'.$student->INDEXNO.'.JPG" alt=" Picture of Employee Here"    /></a>df</td>';
                          
                                         
            })
               ->editColumn('id', '{!! $ID!!}')
            ->addColumn('Photo', function ($student) {
               // return '<a href="#edit-'.$student->ID.'" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>';
            
                return' <a href="show_student/'.$student->INDEXNO.'/id"><img class="md-user-image-large" style="width:60px;height: auto" src="Albums/students/'.$student->INDEXNO.'.JPG" alt=" Picture of Student Here"    /></a>';
                          
                                         
            })
              
            
            ->setRowId('id')
            ->setRowClass(function ($student) {
                return $student->ID % 2 == 0 ? 'uk-text-success' : 'uk-text-warning';
            })
            ->setRowData([
                'id' => 'test',
            ])
            ->setRowAttr([
                'color' => 'red',
            ])
                  
            ->make(true);
             
            //flash the request so it can still be available to the view or search form and the search parameters shown on the form 
      //$request->flash();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SystemController $sys)
    {
           $region=$sys->getRegions();
        
        
        // make sure only students who are currently in school can update their data
         $programme=$sys->getProgramList();
        $house=$sys->getHouseList();
        $religion=$sys->getReligion();
        return view('students.create')
            ->with('programme', $programme)
            ->with('country', $sys->getCountry())
            ->with('class', $sys->getClassList())
            ->with('region', $region)
            ->with('house',$house)
            ->with('combination',$sys->geSubjectCombinations())
            ->with('religion',$religion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SystemController $sys)
    {
      
          set_time_limit(36000);
        /*transaction is used here so that any errror rolls
         *  back the whole process and prevents any inserts or updates
  */


        $user = @\Auth::user()->fund;
        
         $sql2 = \DB::table('cardno')->get();
        $new_cardNo = $sql2[0]->no;
        $cardNo = date("Y") . $new_cardNo;

        $memberCode = $cardNo;
        //$indexno = $request->input('indexno');
        $program = $request->input('programme');
        $gender = $request->input('gender');
        $type = $request->input('type');
        $scholarship = $request->input('scholarship');
        $house = $request->input('house');
        $former = $request->input('former');
        $dateAdmitted= $request->input('doa');
        $dob = $request->input('dob');
        $gname = $request->input('gname');
        $gphone = $request->input('gphone');
        $goccupation = $request->input('goccupation');
        $gaddress = $request->input('gaddress');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $combination = $request->input('combination');
        $region = $request->input('region');
        $country = $request->input('nationality');
        $religion = $request->input('religion');
        
        $address = $request->input('address');
        $hometown = $request->input('hometown');
        $nhis = $request->input('nhis');
        $weac = $request->input('waec');
        $disability = $request->input('disable');
        $lives = $request->input('lives');
        $class = $request->input('class');
        $blood = $request->input('blood');
        $allergies = $request->input('allergy');
        $status = $request->input('status');
        $age = $sys->age($dob, 'eu');
          
        $group = @$sys->graduatingGroup('8989 s');
        $lname = $request->input('surname');
        $othername = $request->input('othernames');
        $name=$lname." ".$othername;
         $sqls = \DB::table('indexno')->get();
            $count = $sqls[0]->no;
         $indexno="TNSC".date("Y").$count;
        $sql=  StudentModel::where("indexNo",$indexno)->first();
        if(empty($sql)){
            /////////////////////////////////////////////////////
        $student = new StudentModel();
       $student->indexNo = $indexno;
                                $student->waecIndexNo = $weac;
                                $student->surname = $lname;
                                $student->othernames = $othername;
                                $student->name = $name;
                                $student->fullname = $name;
                                $student->nhisNo = $nhis;
                                $student->gender =$gender;
                                $student->dob =$dob;
                                $student->age =$age;
                                 $student->cardNo = $memberCode;
                                $student->studentLivesWith=$lives;
                                $student->studentType =$type;
                                $student->status =$status;
                                $student->disability =$disability;
                                $student->bloodGroup=$blood;
                                $student->allergies=$allergies ;
                                $student->currentClass =$class;
                                $student->hometown =$hometown;
                                $student->address =$address;
                                $student->phone =$phone;
                                $student->region =$region;
                                $student->email =$email;
                                $student->formerSchool =$former;
                                $student->programme =$sys->getProgramCode($program);
                                $student->house =$house;
                                $student->nationality =$country;
                                $student->dateAdmitted =$dateAdmitted;
                                $student->parentName =$gname;
                                $student->parentPhone =$gphone;
                                $student->parentAddress=$gaddress;
                                $student->parentOccupation = $goccupation;
                                
                                $student->schoolarship =$scholarship;
                                $student->yearGroup =$group;
                                $student->subjectCombination =$combination;
                                $student->religion =$religion;
                                $student->sysUpdate = "1";

        if($student->save()){

            $array = $sys->getSemYear();
             $year = $array[0]->year;
                $term = $array[0]->term;



            $sem = $array[0]->term;





            // $policy=$sys->getRegiistrationProtocol($student);
            $level= $class;


                  \DB::table('indexno')->increment('no');
             \DB::table('cardno')->increment('no');
             $member=new Models\ClassMembersModel();
             $member->student=$indexno;
             $member->class=$class;
             $member->term=$term;
             $member->year=$year;
             $member->save();
            $allocation=Models\CourseAllocationModel::where("year",$year)
                ->where("classId",$level)
                ->where("term",$sem)->where("teacherId","!=","")->get();






            foreach($allocation as $row){

                $data=  Models\StudentModel::where("indexno",$indexno)->first();





                    $class=$row->classId;
                    $indexno=$data->indexNo;
                    $studentId=$data->id;
                    $lecturer=$row->teacherId;
                    $courseCode=$row->subject;
                    $course=$row->id;
                    $check=  Models\AcademicRecordsModel::where("class",$level)->where("year",$year)->where("term",$sem)->where("indexNo",$indexno)->where("courseCode",$courseCode)->first();

                    if(empty($check)){
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


                    }




            }


            return redirect("/students")->with("success"," <span style='font-weight:bold;font-size:13px;'> $name  successfully added!</span> ");
             
          }else{
           
             return redirect("/add_students")->with("error"," <span style='font-weight:bold;font-size:13px;'> student could not be added try again!</span>");
           
              
          }
        }
        else{
             return  redirect("/add_students")->with("error"," <span style='font-weight:bold;font-size:13px;'>Please student exist in the system !</span>");
           
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,  SystemController $sys,Request $request)
    {
        
         $region=$sys->getRegions();
        
        
        // make sure only students who are currently in school can update their data
        $query = StudentModel::where('id', $id)->first();
        
        
        $trails=  Models\AcademicRecordsModel::where('stuId', $id)->where("grade","E")->orwhere("grade","F")->paginate(100);
        
        return view('students.show')->with('student', $query) ->with('trail',$trails);
             
            
            
           
             
    }
    public function uploadStaff(Request $request) {
       if($request->hasFile('file')){
            $file=$request->file('file');
            $user = \Auth::user()->id;
             
            $ext = strtolower($file->getClientOriginalExtension());
            $valid_exts = array('csv','xlx','xlsx'); // valid extensions
            
            $path = $request->file('file')->getRealPath();
         if (in_array($ext, $valid_exts)) {
            $data = Excel::load($path, function($reader) {
                        
                    })->get();

                    dd($data);
            if(!empty($data) && $data->count()){

				foreach ($data as $key => $value) {

		$insert[] = ['fullName' => $value->name, 'staffID' => $value->staffID,'department'=>$value->Department,'grade'=>$value->grade,'designation'=>$value->position,'phone'=>$value->phone];

				}

                               // dd($insert);
				if(!empty($insert)){

					\DB::table('tpoly_workers')->insert($insert);
 
					// return redirect('/dashboard')->with("success",  " <span style='font-weight:bold;font-size:13px;'>Staff  successfully uploaded!</span> " );
                              

				}

			}

	}
        else{
            //  return redirect('/getStaffCSV')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload file format must be xlx,csv,xslx!</span> ");
                             
        }
       }
		 
       }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,  SystemController $sys,Request $request)
    {
        //
        if($request->user()->isSupperAdmin || @\Auth::user()->department=="top"|| @\Auth::user()->role=="HOD" || @\Auth::user()->role=="Support" ||   @\Auth::user()->role=="Dean"){
              
               $query = StudentModel::where('id', $id)->first();
               
         }
         else{  
        
       
         }
         $region=$sys->getRegions();
        
        
        // make sure only students who are currently in school can update their data
         $programme=$sys->getProgramList();
        $house=$sys->getHouseList();
        $religion=$sys->getReligion();
        return view('students.edit')->with('data', $query)
            ->with('programme', $programme)
            ->with('country', $sys->getCountry())
            ->with('class', $sys->getClassList())
            ->with('region', $region)
            ->with('house',$house)
            ->with('combination',$sys->geSubjectCombinations())
            ->with('religion',$religion);
    }
public function gad()
    {
        //
        return view('autocomplete');
    }

     

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, SystemController $sys)
    {
        if($request->user()->isSupperAdmin || @\Auth::user()->role=="HOD" || @\Auth::user()->role=="Dean"||@\Auth::user()->department=="top" ){
        {
       set_time_limit(36000);
        /*transaction is used here so that any errror rolls
         *  back the whole process and prevents any inserts or updates
         */

  \DB::beginTransaction();
         
        $indexno = $request->input('indexno');
        $program = $request->input('programme');
        $gender = $request->input('gender');
        $type = $request->input('type');
        $scholarship = $request->input('scholarship');
        $house = $request->input('house');
        $former = $request->input('former');
        $dateAdmitted= $request->input('doa');
        $dob = $request->input('dob');
        $gname = $request->input('gname');
        $gphone = $request->input('gphone');
        $goccupation = $request->input('goccupation');
        $gaddress = $request->input('gaddress');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $combination = $request->input('combination');
        $region = $request->input('region');
        $country = $request->input('nationality');
        $religion = $request->input('religion');
        
        $address = $request->input('address');
        $hometown = $request->input('hometown');
        $nhis = $request->input('nhis');
        $weac = $request->input('waec');
        $disability = $request->input('disable');
        $lives = $request->input('lives');
        $class = $request->input('class');
        $blood = $request->input('blood');
        $allergies = $request->input('allergy');
        $status = $request->input('status');
        $age = $sys->age($dob, 'eu');
          
        $group = @$sys->graduatingGroup($indexno);
        $lname = $request->input('surname');
        $othername = $request->input('othernames');
        $name=$lname." ".$othername;
          
          
        $query= StudentModel::where("id",$id)->update(array(
                 "waecIndexNo"=>strtoupper($weac),
                 "indexNo"=>strtoupper($indexno),
                 "surname"=>strtoupper($lname),
                 "name"=>strtoupper($name),
                 "fullname"=>strtoupper($name),
                "othernames"=>strtoupper($othername),
                 
                 "gender"=>strtoupper($gender),
                 "dob"=>$dob,
                 "age"=>$age,
                 "yearGroup"=>$group,
                 "bloodGroup"=>$blood,
                 "studentLivesWith"=>strtoupper($lives),
                 "address"=>strtoupper($address),
                 "allergies"=>strtoupper($allergies),
                 "email"=>strtoupper($email),
                 "phone"=>$phone,
                 "nationality"=>strtoupper($country),
                 "region"=>strtoupper($region),
                 "religion"=>strtoupper($religion),
                 "hometown"=>strtoupper($hometown),
                 "parentName"=>strtoupper($gname),
                 "parentAddress"=>strtoupper($gaddress),
                 "ParentPhone"=>$gphone,  
                 "parentOccupation"=>strtoupper($goccupation),
                 "disability"=>strtoupper($disability),
                "programme"=>strtoupper($program),
                 "status"=>$status,
                 "nhisNo"=>$nhis,
                 "studentType"=>strtoupper($type),
                 "subjectCombination"=>$combination,
                 "house"=>$house,
                  "currentClass"=>strtoupper($class),
            "dateAdmitted"=> $dateAdmitted,
            "formerSchool"=>strtoupper($former),
            "schoolarship"=> $scholarship,
                 "sysUpdate"=>"1",
            
            
                ));
        
     \DB::commit();
         if(!$query){
            return redirect("/students")->withErrors("  N<u>o</u> :<span style='font-weight:bold;font-size:13px;'> data</span>could not be updated!");
          }else{
                    return redirect("/students")->with("success"," <span style='font-weight:bold;font-size:13px;'>data successfully updated!</span> ");
              
        }}}
           else{
            return redirect("/dashboard");
        }
    }
    public function showUploadForm() {
        return view("students.upload");
    }
    public function applicantUploadForm() {
         return view("students.applicantUpload");
    }
    /*
     * upload continuing students 
     */
    public function uploadData(Request $request, SystemController $sys) {

        set_time_limit(36000);

         
            $user = \Auth::user()->id;
            $valid_exts = array('csv', 'xls', 'xlsx'); // valid extensions
            $file = $request->file('file');
            $path = $request->file('file')->getRealPath();

            $ext = strtolower($file->getClientOriginalExtension());
            
            if (in_array($ext, $valid_exts)) {

                $data = Excel::load($path, function($reader) {
                            
                        })->get();

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        $sqls = \DB::table('indexno')->get();
            $count = $sqls[0]->no;
         $indexno="TNSC".date("Y").$count;
                        $num = count($data);
 
                        
                        $name= $value->name;
                        $fullname= $value->name;

                        $gender = $value->gender;

                        $dob =$value->dob;
                       // $waec = $value->waec_indexno;
                        
                        $class = $value->class;
                        $dob = $value->dob;

                        
                        $contact = $value->address;
                         
                        $gname = $value->parent;
                        $gphone = $value->phone;

                        $gaddress = $value->address;
                        $gocupation = $value->occupation;
                        $status ="In school";
                        

                        //dd($dob);
                       // $bill = $value->bill;
                       // $owing = $value->owing;
//                        $programme = $sys->programmeSearchByCode(); // check if the programmes in the file tally wat is in the db
//                        if (array_search($program, $programme)) {

                            $testQuery = StudentModel::where('indexNo', $indexno)->orWhere('name', $name)->first();
                            if (empty($testQuery)) {

                                if(substr($class, 0,1)==="P"){
                                  $programme='PRI';
                                }elseif(substr($class, 0,1)==="J"){
                                   $programme='JHS';
                                }
                                else{
                                   $programme='KG';
                                }
                                $student = new StudentModel();
                                $student->indexNo = $indexno;
                               // $student->waecIndexNo = $waec;

                                $student->name = $name;
                                $student->fullname = $fullname;

                                $student->gender =$gender;
                                $student->dob =$dob;
                               // $student->age = $sys->age($value->dob, 'eu');



                                $student->programme =$programme;
                                $student->currentClass =$class;

                                $student->address =$contact;
                                $student->dob=$dob;

                               
                               

                                $student->parentName =$gname;
                                $student->parentPhone =$gphone;

                                $student->parentOccupation =$gocupation;

                                $student->status =$status;

                                 
                                $student->sysUpdate = "1";
                                
                                $student->save();
                                \DB::commit();
                                   \DB::table('indexno')->increment('no');
                            } else {
                                       return redirect('/upload/students')->with("error", " <span style='font-weight:bold;font-size:13px;'>Some student(s) already exist(s) in the system!</span> ");
           

                            }
//                        } else {
//                            return redirect('/upload/students')->with("error", " <span style='font-weight:bold;font-size:13px;'>File contain unrecognize programme.please try again!</span> ");
//                        }
                    }
                     return redirect('/students')->with("success", " <span style='font-weight:bold;font-size:13px;'>$num student(s) uploaded  successfully!</span> ");
           
                } else {
                    return redirect('/upload/students')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload a excel file!</span> ");
                }


                } else {
                return redirect('/upload/students')->with("error", " <span style='font-weight:bold;font-size:13px;'>Only excel file is accepted!</span> ");
            }

        

        
    }
   
   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
