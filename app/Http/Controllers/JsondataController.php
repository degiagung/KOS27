<?php

namespace App\Http\Controllers;

use App\Models\fasilitas;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Helpers\Master;
use App\Models\User;
use App\Models\MenusAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JsonDataController extends Controller
{   
    public function signup(){
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
                    $result = $MasterClass->selectGlobal($select,$table,$where);
                    
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
    public function getListKamar(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];
                    
                    $select = "
                        k.id,
                        k.lantai,
                        k.no_kamar,
                        k.status,
                        tk.tipe,
                        GROUP_CONCAT(fs.fasilitas SEPARATOR ',') as faskos,
                        GROUP_CONCAT(fsp.fasilitas SEPARATOR ',') as faskosp,
                        GROUP_CONCAT(fs.id SEPARATOR ',') as idfaskos,
                        GROUP_CONCAT(fsp.id SEPARATOR ',') as idfaskosp,
                        CASE
                            WHEN mk.tgl_awal is not null THEN 'Sudah Terisi'
                            else 'Kosong'
                        END as status_kamar,
                        us.name,
                        us.handphone,
                        mk.user_id,
                        concat(mk.tgl_awal,' SD ',mk.tgl_akhir) as durasi,
                        CONVERT(mk.tgl_awal,date) tgl_awal,
                        CONVERT(mk.tgl_akhir,date) tgl_akhir,
                        CONVERT(mk.tgl_akhir,date) - CURRENT_DATE as sisa_durasi
                    ";
                    
                    $table = "
                        kamar k
                        LEFT JOIN mapping_kamar mk ON k.id = mk.id_kamar
                        LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                        LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id AND fs.penyedia = 'pihak kos'
                        LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id AND fsp.penyedia = 'penghuni'
                        LEFT JOIN tipe_kamar tk ON mk.id_tipe = tk.id
                        LEFT JOIN users us ON mk.user_id = us.id
                    ";

                    $where = " 
                        k.id is not null
                    ";
                    $status     = $request->status ;
                    $kondisi    = $request->kondisi ;
                    if($status == 1){
                        $where .="
                             AND mk.user_id is not null
                        ";
                    }elseif($status == 2){
                         $where .="
                             AND mk.user_id is null
                        ";
                    }

                    if($kondisi == 1){
                        $where .="
                             AND k.status is null
                        ";
                    }elseif($kondisi == 2){
                         $where .="
                             AND k.status = 'perbaikan'
                        ";
                    }

                    $where .= " 
                        GROUP BY
                        k.id,
                        k.lantai,
                        k.no_kamar,
                        k.status,
                        mk.tgl_awal,
                        us.name,
                        us.handphone,
                        mk.tgl_awal,
                        mk.tgl_akhir,
                        mk.user_id,
                        tk.tipe
                        ORDER BY mk.tgl_akhir asc
                    ";
                    $result = $MasterClass->selectGlobal($select,$table,$where);
                    
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
    public function getListFasilitas(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];
                    
                    $select = "
                        f.*
                    ";
                    
                    $table = '
                        fasilitas f
                    ';
                    // $where = " ur.role_name like  'penghuni' ";
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
    public function getPenghuni(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());

                    
                    DB::beginTransaction();
            
                    $status = [];
  
                    $saved = DB::select("SELECT us.* FROM users us
                            LEFT JOIN users_roles ur ON us.role_id = ur.id 
                            where 
                            ur.role_name like  'penghuni' ");
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
    public function getTipeKamar(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());

                    
                    DB::beginTransaction();
            
                    $status = [];
  
                    $saved = DB::select("SELECT * FROM tipe_kamar ");
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
    public function getFasilitas(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();
            
                    $status = [];
                    
                    if($request->jenis == 'kos'){
                        $where = "where penyedia= 'pihak kos'";
                    }elseif($request->jenis == 'penghuni'){
                        $where = "where penyedia= 'penghuni'";
                    }else{
                        $where = '';
                    }
                    $saved = DB::select("SELECT * FROM fasilitas $where");
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
    public function getListTipeKamar(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];
                    
                    $select = "
                        tk.*
                    ";
                    
                    $table = '
                        tipe_kamar tk
                    ';
                    // $where = " ur.role_name like  'penghuni' ";
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
    public function listKamarDashboard(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    $idlogin    = strtolower($MasterClass->getSession('user_id'));
                    $rolelogin  = strtolower($MasterClass->getSession('role_name'));
                    $status = [];
                    
                    $select = "
                        k.id,
                        k.lantai,
                        k.no_kamar,
                        GROUP_CONCAT(fs.fasilitas SEPARATOR ',') as faskos,
                        GROUP_CONCAT(fsp.fasilitas SEPARATOR ',') as faskosp,
                        CASE
                            WHEN mk.tgl_awal is not null THEN 'Sudah Terisi'
                            else 'Kosong'
                        END as status_kamar,
                        us.name,
                        mk.user_id,
                        concat(mk.tgl_awal,' SD ',mk.tgl_akhir) as durasi,
                        mk.tgl_awal,
                        mk.tgl_akhir,
                        CONVERT(mk.tgl_akhir,date) - CURRENT_DATE as sisa_durasi,
                        tk.tipe,
                        us.handphone,
                        sum(fsp.biaya)+k.harga as biaya,
                        sum(fsp.biaya) as biayatambah,k.harga,
                        ht.id as status_transaksi,
                        ht.created_at as tgl_bayar
                    ";
                    
                    $table = "
                        kamar k
                        LEFT JOIN mapping_kamar mk ON k.id = mk.id_kamar
                        LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                        LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id
                        LEFT JOIN tipe_kamar tk ON mk.id_tipe = tk.id
                        LEFT JOIN users us ON mk.user_id = us.id
                        LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id and fsp.penyedia = 'penghuni'
                        LEFT JOIN history_transaksi ht ON ht.user_id = mk.user_id AND ht.tgl_awal = mk.tgl_awal
                            AND ht.tgl_akhir = mk.tgl_akhir
                    ";
                    $where = " 
                        mk.user_id is not null
                    ";
                    $sisawaktu = $request->sisawaktu ;
                    $statusbayar = $request->status ;
                    if($rolelogin != 'superadmin' && $rolelogin != 'penjaga'){
                        $where  .=" AND us.id = $idlogin ";
                    }
                    if($sisawaktu){
                        $where .="
                             AND (CONVERT(mk.tgl_akhir,date) - CURRENT_DATE) >= 0 AND (CONVERT(mk.tgl_akhir,date) - CURRENT_DATE) $sisawaktu 
                        ";
                    }
                    if($statusbayar == '0'){
                        
                        $where .=" AND ht.id is null";
                    }elseif($statusbayar == '1'){
                        $where .=" AND ht.id is not null";
                    }
                    $where .= " GROUP BY
                        k.id,
                        k.lantai,
                        k.no_kamar,
                        mk.tgl_awal,
                        mk.user_id,
                        us.name,
                        mk.tgl_awal,
                        mk.tgl_akhir,
                        tk.tipe,
                        us.handphone,
                        k.harga,
                        ht.id,
                        ht.created_at
                        ORDER BY mk.tgl_akhir asc
                    ";

                    // print_r($where);die;;
                    $result = $MasterClass->selectGlobal($select,$table,$where);
                    
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
    public function listTransaksi(Request $request){
        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];
                    
                    $select = "
                        k.id,
                        k.lantai,
                        k.no_kamar,
                        GROUP_CONCAT(fs.fasilitas SEPARATOR ',') as faskos,
                        GROUP_CONCAT(fsp.fasilitas SEPARATOR ',') as faskosp,
                        CASE
                            WHEN mk.tgl_awal is not null THEN 'Sudah Terisi'
                            else 'Kosong'
                        END as status_kamar,
                        us.name,
                        mk.user_id,
                        concat(mk.tgl_awal,' SD ',mk.tgl_akhir) as durasi,
                        mk.tgl_awal,
                        mk.tgl_akhir,
                        CONVERT(mk.tgl_akhir,date) - CURRENT_DATE as sisa_durasi,
                        tk.tipe,
                        us.handphone,
                        sum(fsp.biaya)+k.harga as biaya,
                        sum(fsp.biaya) as biayatambah,k.harga,
                        ht.id as status_transaksi,
                        ht.created_at as tgl_bayar
                    ";
                    
                    $table = "
                        kamar k
                        LEFT JOIN mapping_kamar mk ON k.id = mk.id_kamar
                        LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                        LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id
                        LEFT JOIN tipe_kamar tk ON mk.id_tipe = tk.id
                        LEFT JOIN users us ON mk.user_id = us.id
                        LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id and fsp.penyedia = 'penghuni'
                        LEFT JOIN history_transaksi ht ON ht.user_id = mk.user_id AND ht.tgl_awal = mk.tgl_awal
                            AND ht.tgl_akhir = mk.tgl_akhir
                    ";
                    $where = " 
                        mk.user_id is not null
                    ";
                    $sisawaktu = $request->sisawaktu ;
                    if($sisawaktu){
                        $where .="
                             AND (CONVERT(mk.tgl_akhir,date) - CURRENT_DATE) >= 0 AND (CONVERT(mk.tgl_akhir,date) - CURRENT_DATE) $sisawaktu 
                        ";
                    }
                    $where .= "GROUP BY
                        k.id,
                        k.lantai,
                        k.no_kamar,
                        mk.tgl_awal,
                        mk.user_id,
                        us.name,
                        mk.tgl_awal,
                        mk.tgl_akhir,
                        tk.tipe,
                        us.handphone,
                        k.harga,
                        ht.id,
                        ht.created_at
                        ORDER BY mk.tgl_akhir asc
                    ";

                    // print_r($where);die;;
                    $result = $MasterClass->selectGlobal($select,$table,$where);
                    
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
        public function actionFasilitas(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data       = json_decode($request->getContent());
                        $id         = $data->id;

                        if($data->tipe == 'deleted'){
                             $where     = [
                                'id' => $id
                            ];
                            $saved      = $MasterClass->deleteGlobal('fasilitas', $where );
                        }else{
                            
                            $fasilitas  = $data->name;
                            $penyedia   = $data->penyedia;
                            $biaya      = $data->biaya;
                            if($id){
                                $attributes     = [
                                    'fasilitas' => $fasilitas,
                                    'penyedia'  => $penyedia,
                                    'biaya'     => $biaya,
                                ];
                                $where     = [
                                    'id' => $id
                                ];
                                $saved      = $MasterClass->updateGlobal('fasilitas', $attributes,$where );
                                $status     = $saved;
                            }else{
                                $attributes     = [
                                    'fasilitas' => $fasilitas,
                                    'penyedia'  => $penyedia,
                                    'biaya'     => $biaya,
                                ];
                                $saved      = $MasterClass->saveGlobal('fasilitas', $attributes );
                                
                            }
                        }
                        $status     = $saved;
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code'  => $status['code'],
                            'info'  => $status['info'],
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
        public function actionTipeKamar(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data       = json_decode($request->getContent());
                        $id         = $data->id;
                        $table      = 'tipe_kamar';
                        if($data->tipe == 'deleted'){
                             $where     = [
                                'id' => $id
                            ];
                            $saved      = $MasterClass->deleteGlobal($table, $where );
                        }else{
                            
                            $fasilitas  = $data->name;
                            if($id){
                                $attributes     = [
                                    'tipe' => $fasilitas
                                ];
                                $where     = [
                                    'id' => $id
                                ];
                                $saved      = $MasterClass->updateGlobal($table, $attributes,$where );
                                $status     = $saved;
                            }else{
                                $attributes     = [
                                    'tipe' => $fasilitas
                                ];
                                $saved      = $MasterClass->saveGlobal($table, $attributes );
                                
                            }
                        }
                        $status     = $saved;
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code'  => $status['code'],
                            'info'  => $status['info'],
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
        public function actionKamar(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $id                 = $request->id;
                        $tipe               = $request->tipe;
                        $tipekamar          = $request->tipekamar;
                        $no                 = $request->no;
                        $lantai             = $request->lantai;
                        $harga              = $request->harga;
                        $fasilitas          = $request->fasilitas;
                        $fasilitaspenghuni  = $request->fasilitaspenghuni;
                        $penghuni           = $request->penghuni;
                        $durasi             = $request->durasi;
                        $tglawal            = null;
                        $tglakhir           = null;
                        if($penghuni){
                            $tglawal        = explode(" ",$durasi)[0];
                            $tglakhir       = explode(" ",$durasi)[2];
                        }
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'kos';
                        $idkamar            = null;

                        if($tipe == 'deleted'){
                             $where     = [
                                 'id' => $id
                            ];
                            $where1     = [
                                'id_kamar' => $id
                            ];
                            $deleted1      = $MasterClass->deleteGlobal('mapping_fasilitas', $where1 );
                            $deleted2      = $MasterClass->deleteGlobal('mapping_kamar', $where1 );
                            $deleted3      = $MasterClass->deleteGlobal('foto_kamar', $where1 );
                            $deleted4      = $MasterClass->deleteGlobal('kamar', $where );
                            $status        = $deleted4;
                            $code          = $MasterClass::CODE_SUCCESS;
                            if($deleted1['code'] != $code || $deleted2['code'] != $code 
                            || $deleted3['code'] != $code || $deleted4['code'] != $code){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data kamar",
                                ];
                                return $MasterClass->Results($results);
                            }
                        }else{
                            
                            $cekkamar = $MasterClass->selectGlobal("*",'kamar',"no_kamar= '$no'");
                            if(count($cekkamar['data']) >= 1){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "No Kamar sudah tersedia",
                                ];
                                return $MasterClass->Results($results);
                            }
                            if($id){
                                $attributes     = [
                                    'fasilitas' => $fasilitas,
                                    'penyedia'  => $penyedia,
                                    'biaya'     => $biaya,
                                ];
                                $where     = [
                                    'id' => $id
                                ];
                                $saved      = $MasterClass->updateGlobal('fasilitas', $attributes,$where );
                                $status     = $saved;
                            }else{
                                // save data kamar
                                $attrkamar     = [
                                    'no_kamar'  => $no,
                                    'lantai'    => $lantai,
                                    'harga'     => $harga,
                                    'created_at'=> $now,
                                ];
                                $savedkamar      = $MasterClass->saveGlobal('kamar', $attrkamar );
                                if($savedkamar['code'] != '0'){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Gagal simpan data kamar",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                                $idkamar        = $savedkamar['data'];
                                
                                //save mapping kamar
                                $attrmapping     = [
                                    'user_id'       => $penghuni,
                                    'id_kamar'      => $idkamar,
                                    'id_tipe'       => $tipekamar,
                                    'tgl_awal'      => $tglawal,
                                    'tgl_akhir'     => $tglakhir,
                                    'created_at'    => $now,
                                ];
                                $savedmapping      = $MasterClass->saveGlobal('mapping_kamar', $attrmapping );
                                if($savedmapping['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Gagal simpan data kamar",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                                
                                //save mapping fasilitas kos
                                $fasilitas = explode(",",$fasilitas) ;
                                foreach ($fasilitas as $value) {
                                    $attrmappingfas     = [
                                        'id_kamar'      => $idkamar,
                                        'id_fasilitas'  => $value,
                                        'created_at'    => $now,
                                    ];
                                    $savedmappingfas      = $MasterClass->saveGlobal('mapping_fasilitas', $attrmappingfas );
                                    if($savedmappingfas['code'] != $MasterClass::CODE_SUCCESS){
                                        DB::rollBack();
                                        $results = [
                                            'code' => '1',
                                            'info'  => "Gagal simpan data kamar",
                                        ];
                                        return $MasterClass->Results($results);
                                    }
                                }
                                //save mapping fasilitas penghuni
                                $fasilitas = explode(",",$fasilitaspenghuni) ;
                                foreach ($fasilitas as $value) {
                                    $attrmappingfas     = [
                                        'id_kamar'      => $idkamar,
                                        'id_fasilitas'  => $value,
                                        'created_at'    => $now,
                                    ];
                                    $savedmappingfas      = $MasterClass->saveGlobal('mapping_fasilitas', $attrmappingfas );
                                    if($savedmappingfas['code'] != $MasterClass::CODE_SUCCESS){
                                        DB::rollBack();
                                        $results = [
                                            'code' => '1',
                                            'info'  => "Gagal simpan data kamar",
                                        ];
                                        return $MasterClass->Results($results);
                                    }
                                }

                                //save foto kamar lainnya
                                for ($i=0; $i < count($_FILES['filelainnya']['name']); $i++) { 
       
                                    $nama_file          = $_FILES['filelainnya']['name'][$i];
                                    $type		        = $_FILES['filelainnya']['type'][$i];
                                    $ukuran		        = $_FILES['filelainnya']['size'][$i];
                                    $tmp_name		    = $_FILES['filelainnya']['tmp_name'][$i];
                                    $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                                    $alamatfile         = '../public/data/kos/'; // directory file
                                    $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                                    
                                    if (move_uploaded_file($tmp_name,$uploaddir)){
                                        chmod($uploaddir, 0777);

                                        $attrphoto     = [
                                            'id_kamar'  => $idkamar,
                                            'file'      => $nama_file_upload,
                                            'alamat'    => $alamatfile,
                                            'size'      => $ukuran,
                                            'tipe'      => $type,
                                            'jenis'     => 'lainnya',
                                            'created_at'=> $now,
                                        ];
                                        $savefoto      = $MasterClass->saveGlobal('foto_kamar', $attrphoto );
                                        if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                            DB::rollBack();
                                            $results = [
                                                'code' => '1',
                                                'info'  => "Gagal simpan data kamar",
                                            ];
                                            return $MasterClass->Results($results);
                                        }
                                    }

                                }
                            }
                        }

                        if($idkamar != null){// ini save
                            DB::commit();
                            $results = [
                            'code'  => $MasterClass::CODE_SUCCESS,
                            'info'  => 'ok',
                            'data'  => $idkamar, //balikin id kamar untuk save foto sampul
                            ];
                        }else{// ini update & delete
                            if($status['code'] == $MasterClass::CODE_SUCCESS){
                                DB::commit();
                            }else{
                                DB::rollBack();
                            }

                            $results = [
                                'code'  => $status['code'],
                                'info'  => $status['info'],
                            ];
                        }
            
            
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
        public function saveFileSampul(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $idkamar            = $request->idkamar;
                        
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'kos';

                        $nama_file          = $_FILES['form-sampul']['name'];
                        $type		        = $_FILES['form-sampul']['type'];
                        $ukuran		        = $_FILES['form-sampul']['size'];
                        $tmp_name		    = $_FILES['form-sampul']['tmp_name'];
                        $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                        $alamatfile         = '../public/data/kos/'; // directory file
                        $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                        
                        if (move_uploaded_file($tmp_name,$uploaddir)){
                            chmod($uploaddir, 0777);

                            $attrphoto     = [
                                'id_kamar'  => $idkamar,
                                'file'      => $nama_file_upload,
                                'alamat'    => $alamatfile,
                                'size'      => $ukuran,
                                'tipe'      => $type,
                                'jenis'     => 'sampul',
                                'created_at'=> $now,
                            ];
                            $savefoto      = $MasterClass->saveGlobal('foto_kamar', $attrphoto );
                            if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data kamar",
                                ];
                                return $MasterClass->Results($results);
                            }
                        }

                            

                        DB::commit();
                        $results = [
                            'code'  => $MasterClass::CODE_SUCCESS,
                            'info'  => 'ok',
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
        public function saveBukti(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $user_id            = $request->user_id;
                        $name               = $request->name;
                        $handphone          = $request->handphone;
                        $no_kamar           = $request->no_kamar;
                        $faskos             = $request->faskos;
                        $faskosp            = $request->faskosp;
                        $tgl_awal           = $request->tgl_awal;
                        $tgl_akhir          = $request->tgl_akhir;
                        $harga              = $request->harga;
                        $biayatambah        = $request->biayatambah;
                        $biaya              = $request->biaya;
                         if($user_id == '' || $user_id == null || $user_id == 'undefined'){//ngebaca yg upload apakah admin / penghuni
                            $user_id = $MasterClass->getSession('user_id') ; 
                         }
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'bukti';

                        $nama_file          = $_FILES['form-bukti']['name'];
                        $type		        = $_FILES['form-bukti']['type'];
                        $ukuran		        = $_FILES['form-bukti']['size'];
                        $tmp_name		    = $_FILES['form-bukti']['tmp_name'];
                        $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                        $alamatfile         = '../public/data/bukti/'; // directory file
                        $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                        
                        if (move_uploaded_file($tmp_name,$uploaddir)){
                            chmod($uploaddir, 0777);

                            $attrphoto     = [
                                'user_id'   => $user_id,
                                'tgl_awal'  => $tgl_awal,
                                'tgl_akhir' => $tgl_akhir,
                                'file'      => $nama_file_upload,
                                'alamat'    => $alamatfile,
                                'size'      => $ukuran,
                                'tipe'      => $type,
                                'jenis'     => 'bukti',
                                'created_at'=> $now,
                            ];
                            $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                            if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data",
                                ];
                                return $MasterClass->Results($results);
                            }

                            
                            $attrtransaksi     = [
                                'user_id'           => $user_id,
                                'name'              => $name,
                                'handphone'         => $handphone,
                                'no_kamar'          => $no_kamar,
                                'fasilitas'         => $faskos,
                                'fasilitas_penghuni'=> $faskosp,
                                'tgl_awal'          => $tgl_awal,
                                'tgl_akhir'         => $tgl_akhir,
                                'biaya_kamar'       => $harga,
                                'biaya_tambahan'    => $biayatambah,
                                'total_biaya'       => $biaya,
                                'created_at'        => $now,
                            ];
                            $savetransaksi      = $MasterClass->saveGlobal('history_transaksi', $attrtransaksi );
                            if($savetransaksi['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data",
                                ];
                                return $MasterClass->Results($results);
                            }
                        }

                            

                        DB::commit();
                        $results = [
                            'code'  => $MasterClass::CODE_SUCCESS,
                            'info'  => 'ok',
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
