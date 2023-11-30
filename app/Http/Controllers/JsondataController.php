<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\PengadaanDetail;
use App\Models\Supplier;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Helpers\Master;
use App\Models\User;
use App\Models\MenusAccess;
use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JsonDataController extends Controller
{   
    public function signup()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => 'required|max:50|unique:users',
            'handphone' => ['required', 'min:5', 'max:20'],
            'password' => ['required', 'min:5', 'max:20'],
        ]);
        DB::beginTransaction();  
        $MasterClass    = new Master();
        $request        = request();
        $attributes     = [
            'name'      => $request->name,
            'email'     => $request->email,
            'handphone' => $request->handphone,
            'password'  => $request->password,
            'is_active' => '1',
            'role_id'   => 10
        ];
        $attributes['password'] = bcrypt($attributes['password'] );
        $user = $MasterClass->saveGlobal('users', $attributes );
        $credentials = [
            "email"     =>  $request->email,
            "password"  =>  $request->password,
        ];

        Auth::attempt($credentials); 
        if(Auth::check() == true){
            DB::commit();
            Session::put('user_id', Auth::user()->id);
            Session::put('name', Auth::user()->name);
            Session::put('role_id', Auth::user()->role_id);
            $code = $MasterClass::CODE_SUCCESS ;
            $info = $MasterClass::INFO_SUCCESS ;
        }else{
            DB::rollback();
            $code = $MasterClass::CODE_FAILED ;
            $info = $MasterClass::INFO_FAILED ;
        }
        $results = [
            'code'  => $code,
            'info'  => $info,
        ];

        return $MasterClass->Results($results);
    }
    
    // for list menu side bar
    public function getAccessMenu(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $data = json_decode($request->getContent());
                    $status = [];
                    $role_id = $MasterClass->getSession('role_id');
                    $saved = DB::select("SELECT * FROM menus_access ma LEFT JOIN users_access ua ON ma.id = ua.menu_access_id WHERE ua.role_id =".$role_id. " AND ua.i_view=1 order by ma.menu_name asc");

                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    //USER ROLE
    public function getRoleMenuAccess(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());
                    
                    DB::beginTransaction();
            
                    $status = [];
                    $sql    ="SELECT * FROM users_roles ur LEFT JOIN users_access ua ON ur.id = ua.role_id WHERE ua.menu_access_id=".$data->id;
                    // dd($sql);
                    $saved = DB::select($sql);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function getRole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());

                    
                    DB::beginTransaction();
            
                    $status = [];
  
                    $saved = DB::select('SELECT * FROM users_roles ur');
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function getAccessRole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();

                    $dataArray = $request->get('param_type');

                    $status = [];
                    $sql ='SELECT ma.*  FROM menus_access ma WHERE ma.param_type ="'.$dataArray.'"';
                    
                    $saved = DB::select($sql);
                    // $saved = MenusAccess::leftJoin()where('param_type', 'VIEW')->get();
                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function saveUserAccessRole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $dataArray = json_decode($request->getContent());

                    DB::beginTransaction();
                    $status = [];
                    // Simpan informasi metode ke dalam database AccessUser
                    foreach ($dataArray as $data) {

                        $saved = UserAccess::updateOrCreate(
                            [
                                'menu_access_id' => $data->mid,
                                'role_id' => $data->rid, // Gantilah $roleId dengan nilai yang sesuai
                            ], // Kolom dan nilai kriteria
                            [
                                'i_view' => $data->is_active,
                            ] // Kolom yang akan diisi
                        );
                        $saved = $MasterClass->checkErrorModel($saved);
                        
                        $status = $saved;
                        
                        if($status['code'] != $MasterClass::CODE_SUCCESS){
                            break;
                        }
                       
                    }   

                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        
                    }               
                    
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function updateMenuAccessName(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $mid = $request->get('mid');
                    $headmenu = $request->get('nhead');
                    $menuname = $request->get('nmenu');

                    DB::beginTransaction();
                    // dd($mid);
                    
                    $status = [];
                    // Simpan informasi metode ke dalam database AccessUser
                    
                    $saved = MenusAccess::where([
                        'id' => $mid,
                    ])->update([
                        'header_menu' => $headmenu,
                        'menu_name' => $menuname,
                    ]);


                    $saved = $MasterClass->checkerrorModelUpdate($saved);
                    
                    $status = $saved;
                

                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        
                    }               
                    
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];

                    // dd($results);
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    
    //USER LIST
    public function getUserList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];
                    
                    $select = "
                        us.id,
                        us.name,
                        us.email,
                        us.handphone,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                            end status_name,
                        us.is_active,
                        us.role_id,
                        ur.role_name 
                    ";
                    
                    $table = '
                        users us
                        LEFT JOIN users_roles ur ON us.role_id = ur.id
                    ';
                    $result = $MasterClass->selectGlobal($select,$table);
                    
                    $results = [
                        'code'  => $result['code'],
                        'info'  => $result['info'],
                        'data'  => $result['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function getPenghuniList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];
                    
                    $select = "
                        us.id,
                        us.name,
                        us.email,
                        us.handphone,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                            end status_name,
                        us.is_active,
                        us.role_id,
                        ur.role_name 
                    ";
                    
                    $table = '
                        users us
                        LEFT JOIN users_roles ur ON us.role_id = ur.id
                    ';
                    $where = " ur.role_name like  'penghuni' ";
                    $result = $MasterClass->selectGlobal($select,$table);
                    
                    $results = [
                        'code'  => $result['code'],
                        'info'  => $result['info'],
                        'data'  => $result['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }

    //CRUD FUNCTION
    public function saveUser(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];
                    if ($data->password){
                        
                        $saved = User::updateOrCreate(
                            [
                                'id' => $data->id,
                            ], 
                            [
                                'name' => $data->name,
                                'email'=> $data->email,
                                'role_id' => $data->role_id,
                                'password' => Hash::make($data->password),
                                'is_active' => $data->is_active,
                            ] // Kolom yang akan diisi
                        );

                    }else{
                      
                        $saved = User::updateOrCreate(
                            [
                                'id' => $data->id,
                            ], 
                            [
                                'name' => $data->name,
                                'email'=> $data->email,
                                'role_id' => $data->role_id,
                                'is_active' => $data->is_active,
                            ] // Kolom yang akan diisi
                        );
                        
                    }
                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function deleteUser(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
                    
                    $status = [];

                    $saved = User::where('id', $data->id)->delete();
                    
                    $saved = $MasterClass->checkerrorModelUpdate($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
    public function deleteGlobal(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
                    
                    $status = [];

                    $saved =   DB::table($data->tableName)->where('id', $data->id)->delete();
                    
                    $saved = $MasterClass->checkerrorModelUpdate($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }

}
