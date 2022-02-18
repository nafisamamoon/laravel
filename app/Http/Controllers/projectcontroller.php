<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Alluser;
use App\Models\Person;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth; 
class projectcontroller extends Controller
{
   /* public function login(Request $request){ 
        if(Auth::guard('alluser')->attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            $user=Auth::guard('alluser')->user();
            $res=[];
$res['token']=$user->createToken('alluser-api')->accessToken;
$res['name']=$user->name;
$res['role_id']=$user->role_id;
$res['id']=$user->id;
return response()->json($res,200);
        }else{
         return response()->json(['error'=>'fail unauthorized'],203); 
        }
     }*/
    public function login(Request $request){ 
        if(Auth::guard('person')->attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            $user=Auth::guard('person')->user();
            $res=[];
$res['token']=$user->createToken('person-api')->accessToken;
$res['name']=$user->name;
$res['role_id']=$user->role_id;
$res['id']=$user->id;
return response()->json($res,200);
        }else{
         return response()->json(['error'=>'fail unauthorized'],203); 
        }
     }

    /* public function register(Request $request) 
     { 
 $validator = Validator::make($request->all(), [ 
     'name' => 'required', 
     'email' => 'required|email', 
     'role_id' => 'required',
     'password' => 'required', 
     'age' => 'required',
     'address' => 'required',
     'qualifications' => 'required',
     'phone_number' => 'required',
 ]);
 if ($validator->fails()) { 
     return response()->json(['error'=>$validator->errors()], 202);            
 }
$alldata=$request->all();
$alldata['password']=bcrypt($alldata['password']);
$user=Alluser::create($alldata);
$res=[];
$res['token']=$user->createToken('alluser-api')->accessToken;
$res['name']=$user->name;
$res['role_id']=$user->role_id;
return response()->json($res,200);

     }*/
     public function register(Request $request) 
     { 
 $validator = Validator::make($request->all(), [ 
     'name' => 'required', 
     'email' => 'required|email', 
     'role_id' => 'required',
     'password' => 'required', 
     'age' => 'required',
     'address' => 'required',
     'qualifications' => 'required',
     'phone_number' => 'required',
     
 ]);
 if ($validator->fails()) { 
     return response()->json(['error'=>$validator->errors()], 202);            
 }
$alldata=$request->all();
$alldata['password']=bcrypt($alldata['password']);

$file=$request->file('path');
        $extension=$file->getClientOriginalExtension();
        $filename=time() .'.'. $extension;
        $file->move('uploads/',$filename);
        $alldata['path']=$filename;

$user=Person::create($alldata);
$res=[];
$res['token']=$user->createToken('alluser-api')->accessToken;
$res['name']=$user->name;
$res['role_id']=$user->role_id;
return response()->json($res,200);

     }
     public function getadmin(){
        $admin=Person::where('role_id','=',1)->first();
        return response()->json([$admin]);
            }

            /////////////////////////////////
            public function getemergancy(){
                $emer=Person::where('role_id','=',4)->first();
                return response()->json([$emer]);
                    }
                    ///////////////////////////////////
            public function getregistrar(){
                $registrar=Person::where('role_id','=',2)->first();
                return response()->json([$registrar]);
            }
            //////////////////////
            public function onepatient($id){
$one=Patient::find($id);
return response()->json([$one]);
            }
            /////////////////////////
           
            public function getdoctors(){
                $doctors=Person::where('role_id','=',3)->get();
                return response()->json($doctors);
                    }
                    //////////////////////////////////
                    public function mypatient($id){
                        $my=Person::find($id);
                        return $my->patients;
                    }
                    public function addpatient(Request $request){
                        $pat=new Patient;
                        $pat->name=$request->post('name');
                        $pat->age=$request->post('age');
                        $pat->person_id=$request->post('person_id');
                        $pat->address=$request->post('address');
                        $pat->diagnosis=$request->post('diagnosis');
                        $pat->patient_phone_number=$request->post('patient_phone_number');
                        $pat->patient_companion_phone_number=$request->post('patient_companion_phone_number');
                        $file=$request->file('path');
                        $extension=$file->getClientOriginalExtension();
                        $filename=time() .'.'. $extension;
                        $file->move('uploads/',$filename);
                        $pat->path=$filename;
                        if($pat->save()){
                            return response()->json([
                                'success'=>$pat
                            ]);
                            }else{
                                return response()->json([
                                    'success'=>false
                                ]);
                
                    }
                    }
                    public function doctorinfo($id){
                        $info=Person::find($id);
                        return response()->json($info);
                                }
                                public function allpatient(){
                                    $all=Patient::all();
                                    return response()->json($all);
                                }
                                /////////////////////////////////////
                                public function updatepatient($id,Request $request){
                                    $pat=Patient::find($id);
                                    $pat->name=$request->input('name');
                                    $pat->age=$request->input('age');
                                    $pat->address=$request->input('address');
                                    //$pat->diagnosis=$request->input('diagnosis');
                                    $pat->patient_phone_number=$request->input('patient_phone_number');
                                    $pat->patient_companion_phone_number=$request->input('patient_companion_phone_number');
                                    $pat->save();
                                    return response()->json($pat);
                            
                            
                                }
                                ////////////////////////////////
                                public function updatedio($id,Request $request){
                                    $di=Patient::find($id);
                                    $di->diagnosis=$request->input('diagnosis');
                                    $di->save();
                                    return response()->json($di);
                                }
                                /////////////////////////////////////////////
                                public function deletepatient($id,Request $request){
                                    $pati=Patient::find($id);
                                    $pati->delete();
                                    return response()->json([
                                        'success'=>true
                                    ]);
                                    }
                                    //////////////////////////////////////////
                                    public function editall(Request $request,$id){   
                                        $validator=Validator::make($request->all(),[
                                        'name'=>'required',
                                        'age'=>'required',
                                        'address'=>'required',
                                        'qualifications'=>'required',
                                        'phone_number'=>'required',
                                        'path'=>'nullable',
                                        ]);
                                        if($validator->fails()){
                                            return response()->json([
                                                'error'=>$validator->messages()
                                            ],422);
                                        }else{
                                            $blog=Person::find($id);
                                            $blog->name=$request->name;
                                            $blog->phone_number=$request->phone_number;
                                            $blog->age=$request->age;
                                            $blog->address=$request->address;
                                            $blog->qualifications=$request->qualifications;
                                            if($request->path && $request->path->isValid()){
                                                $file_name=time().'.'.$request->path->extension();
                                                $request->path->move(public_path('uploads'),$file_name);
                                                $path=$file_name;
                                                $blog->path=$path;
                                            }
                                            $blog->update();
                                            return response()->json(['success'=>$blog]);
                                        }
                                        
                                            }
                                            ///////////////////////////////////////////////////
                                            public function editdata(Request $request,$id){   
                                                $validator=Validator::make($request->all(),[
                                                'name'=>'required',
                                                'age'=>'required',
                                                'address'=>'required',
                                                'qualifications'=>'required',
                                                'phone_number'=>'required',
                                               
                                                ]);
                                                if($validator->fails()){
                                                    return response()->json([
                                                        'error'=>$validator->messages()
                                                    ],422);
                                                }else{
                                                    $blog=Person::find($id);
                                                    $blog->name=$request->name;
                                                    $blog->age=$request->age;
                                                    $blog->address=$request->address;
                                                    $blog->qualifications=$request->qualifications;
                                                    $blog->phone_number=$request->phone_number;
                                                    $blog->update();
                                                    return response()->json(['success'=>$blog]);
                                                }
                                                
                                                    }
           //////////////////////////////////////////////////////////                                         
                     public function editpatientbyemergency(Request $request,$id){
                        $validator=Validator::make($request->all(),[
                            'diagnosis'=>'required',
                            ]);
                            if($validator->fails()){
                                return response()->json([
                                    'error'=>$validator->messages()
                                ],422);
                            }else{
                        $blog=Patient::find($id);
                        $blog->diagnosis=$request->diagnosis;
                        $blog->update();
                        //$blog->save();
                        //$blog->update(['diagnosis',[$blog->diagnosis=$request->diagnosis]]);
                        return response()->json(['success'=>$blog]);
                            }
                 }   
                 ////////////////////////////////////////////////////////
                 public function editpatientbydoctor(Request $request,$id){
                    $validator=Validator::make($request->all(),[
                        'diagnosis'=>'required',
                        ]);
                        if($validator->fails()){
                            return response()->json([
                                'error'=>$validator->messages()
                            ],422);
                        }else{
                    $blog=Patient::find($id);
                    $blog->diagnosis=$request->diagnosis;
                    $blog->update();
                    //$blog->save();
                    //$blog->update(['diagnosis',[$blog->diagnosis=$request->diagnosis]]);
                    return response()->json(['success'=>$blog]);
                        }
             }                             
         ///////////////////////////////////////////////////////////////////////////////////////////
 public function editregistrar(Request $request,$id){
                    $validator=Validator::make($request->all(),[
                 'name'=>'required',
       'age'=>'required',
             'address'=>'required',
         'qualifications'=>'required',
      'phone_number'=>'required',
         'path'=>'nullable',
             ]);
              if($validator->fails()){
               return response()->json([
              'error'=>$validator->messages()
       ],422);
           }else{
             $blog=Person::find($id);
               $blog->name=$request->name;
                $blog->phone_number=$request->phone_number;
                  $blog->age=$request->age;
                $blog->address=$request->address;
             $blog->qualifications=$request->qualifications;
             if($request->path && $request->path->isValid()){
             $file_name=time().'.'.$request->path->extension();
               $request->path->move(public_path('uploads'),$file_name);
                $path=$file_name;
                $blog->path=$path;
          }
            $blog->update();
             return response()->json(['success'=>$blog]);
         }
      }
    public function editregistrardata(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'age'=>'required',
            'address'=>'required',
            'qualifications'=>'required',
            'phone_number'=>'required',
           
            ]);
            if($validator->fails()){
                return response()->json([
                    'error'=>$validator->messages()
                ],422);
            }else{
                $blog=Person::find($id);
                $blog->name=$request->name;
                $blog->age=$request->age;
                $blog->address=$request->address;
                $blog->qualifications=$request->qualifications;
                $blog->phone_number=$request->phone_number;
                $blog->update();
                return response()->json(['success'=>$blog]);
            }
            
    }  
   ////////////////////////////////////////////////////////////////
   public function editemergency(Request $request,$id){
    $validator=Validator::make($request->all(),[
 'name'=>'required',
'age'=>'required',
'address'=>'required',
'qualifications'=>'required',
'phone_number'=>'required',
'path'=>'nullable',
]);
if($validator->fails()){
return response()->json([
'error'=>$validator->messages()
],422);
}else{
$blog=Person::find($id);
$blog->name=$request->name;
$blog->phone_number=$request->phone_number;
  $blog->age=$request->age;
$blog->address=$request->address;
$blog->qualifications=$request->qualifications;
if($request->path && $request->path->isValid()){
$file_name=time().'.'.$request->path->extension();
$request->path->move(public_path('uploads'),$file_name);
$path=$file_name;
$blog->path=$path;
}
$blog->update();
return response()->json(['success'=>$blog]);
}
}
public function editemergencydata(Request $request,$id){
$validator=Validator::make($request->all(),[
'name'=>'required',
'age'=>'required',
'address'=>'required',
'qualifications'=>'required',
'phone_number'=>'required',

]);
if($validator->fails()){
return response()->json([
    'error'=>$validator->messages()
],422);
}else{
$blog=Person::find($id);
$blog->name=$request->name;
$blog->age=$request->age;
$blog->address=$request->address;
$blog->qualifications=$request->qualifications;
$blog->phone_number=$request->phone_number;
$blog->update();
return response()->json(['success'=>$blog]);
}

}   
  ////////////////////////////////////////////////////////////////
  public function editdoctor(Request $request,$id){
    $validator=Validator::make($request->all(),[
        'name'=>'required',
'age'=>'required',
    'address'=>'required',
'qualifications'=>'required',
'phone_number'=>'required',
'path'=>'nullable',
    ]);
     if($validator->fails()){
      return response()->json([
     'error'=>$validator->messages()
],422);
  }else{
    $blog=Person::find($id);
      $blog->name=$request->name;
       $blog->phone_number=$request->phone_number;
         $blog->age=$request->age;
       $blog->address=$request->address;
    $blog->qualifications=$request->qualifications;
    if($request->path && $request->path->isValid()){
    $file_name=time().'.'.$request->path->extension();
      $request->path->move(public_path('uploads'),$file_name);
       $path=$file_name;
       $blog->path=$path;
 }
   $blog->update();
    return response()->json(['success'=>$blog]);
}
  }  
  public function editdoctordata(Request $request,$id){
    $validator=Validator::make($request->all(),[
        'name'=>'required',
        'age'=>'required',
        'address'=>'required',
        'qualifications'=>'required',
        'phone_number'=>'required',
       
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>$validator->messages()
            ],422);
        }else{
            $blog=Person::find($id);
            $blog->name=$request->name;
            $blog->age=$request->age;
            $blog->address=$request->address;
            $blog->qualifications=$request->qualifications;
            $blog->phone_number=$request->phone_number;
            $blog->update();
            return response()->json(['success'=>$blog]);
        }
  }
  ////////////////////////////////////////////
  public function addpatientwithoutimage(Request $request){
    $pat=new Patient;
    $pat->name=$request->post('name');
    $pat->age=$request->post('age');
    $pat->person_id=$request->post('person_id');
    $pat->address=$request->post('address');
    $pat->diagnosis=$request->post('diagnosis');
    $pat->patient_phone_number=$request->post('patient_phone_number');
    $pat->patient_companion_phone_number=$request->post('patient_companion_phone_number');
    $file=$request->file('path');
    $extension=$file->getClientOriginalExtension();
    $filename=time() .'.'. $extension;
    $file->move('uploads/',$filename);
    $pat->path=$filename;
    if($pat->save()){
        return response()->json([
            'success'=>$pat
        ]);
        }else{
            return response()->json([
                'success'=>false
            ]);

}
  }
 /////////////////////////////////////
 public function patbydoctor($id){
    $pats=Patient::where('person_id','=',$id)->get();
    return response()->json([$pats]);
 } 
}
