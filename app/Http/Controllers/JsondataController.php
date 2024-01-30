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
                            k.harga,
                            tk.tipe,
                            GROUP_CONCAT(fs.fasilitas SEPARATOR ',') as faskos,
                            GROUP_CONCAT(fsp.fasilitas SEPARATOR ',') as faskosp,
                            GROUP_CONCAT(fsper.fasilitas SEPARATOR ',') as perbaikan,
                            GROUP_CONCAT(fs.id SEPARATOR ',') as idfaskos,
                            GROUP_CONCAT(fsp.id SEPARATOR ',') as idfaskosp,
                            GROUP_CONCAT(fsper.id SEPARATOR ',') as idperbaikan,
                            CASE 
                                WHEN ur.role_name = 'guest' THEN 'Booking'
                                ELSE
                                    CASE
                                        WHEN mk.tgl_awal is not null THEN 'Sudah Terisi'
                                        ELSE 'Kosong'
                                    END
                            END as status_kamar,
                            us.name,
                            us.handphone,
                            ur.role_name,
                            mk.user_id,
                            concat(mk.tgl_awal,' SD ',mk.tgl_akhir) as durasi,
                            CONVERT(mk.tgl_awal,date) tgl_awal,
                            CONVERT(mk.tgl_akhir,date) tgl_akhir,
                            DATEDIFF(CONVERT(mk.tgl_akhir,date) , CURRENT_DATE) as sisa_durasi,
                            mk.jml_bulan_booking as jmlbooking ,
                            count(fsper.fasilitas) countperbaikan
                        ";
                        
                        $table = "
                            kamar k
                            LEFT JOIN mapping_kamar mk ON k.id = mk.id_kamar
                            LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                            LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id AND fs.penyedia = 'pihak kos'
                            LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id AND fsp.penyedia = 'penghuni'
                            LEFT JOIN fasilitas fsper ON mf.id_fasilitas = fsper.id AND fsper.penyedia = 'pihak kos' AND mf.status = 'perbaikan'
                            LEFT JOIN tipe_kamar tk ON mk.id_tipe = tk.id
                            LEFT JOIN users us ON mk.user_id = us.id
                            LEFT JOIN users_roles ur ON ur.id = us.role_id
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
                        }elseif($status == 3){
                            $where .="
                                AND mk.user_id is not  null and ur.role_name = 'guest'
                            ";
                        }

                        
                        $where .= " 
                            GROUP BY
                            k.id,
                            k.lantai,
                            k.no_kamar,
                            k.status,
                            k.harga,
                            mk.tgl_awal,
                            us.name,
                            us.handphone,
                            ur.role_name,
                            mk.tgl_awal,
                            mk.tgl_akhir,
                            mk.user_id,
                            mk.jml_bulan_booking,
                            tk.tipe
                            ORDER BY k.no_kamar asc
                        ";

                        if($kondisi ){
                            $table = " ( select ".$select." from ".$table." where ".$where." ) a" ;
                            $select = " * ";
                            if($kondisi == 1){
                                $where =" countperbaikan = 0";
                            }elseif($kondisi == 2){
                                $where =" countperbaikan >= 1";
                            }
                        }
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
                        
                        if($request->kamar){
                            $where = "inner join mapping_fasilitas b on a.id= b.id_fasilitas where b.id_kamar = $request->kamar and a.penyedia= 'pihak kos'";
                        }else{
                            if($request->jenis == 'kos'){
                                $where = "where penyedia= 'pihak kos'";
                            }elseif($request->jenis == 'penghuni'){
                                $where = "where penyedia= 'penghuni'";
                            }else{
                                $where = '';
                            }
                        }
                        $saved = DB::select("SELECT a.* FROM fasilitas a $where");
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
                            DATEDIFF(CONVERT(mk.tgl_akhir,date) , CURRENT_DATE) as sisa_durasi,
                            PERIOD_DIFF(DATE_FORMAT(mk.tgl_akhir, '%Y%m') , DATE_FORMAT(mk.tgl_awal, '%Y%m')) as periode,
                            PERIOD_DIFF(DATE_FORMAT(mk.tgl_akhir, '%Y%m') , DATE_FORMAT(mk.tgl_awal, '%Y%m')) * (coalesce(sum(fsp.biaya),0)+k.harga) as biaya,
                            tk.tipe,
                            us.handphone,
                            sum(fsp.biaya) as biayatambah,k.harga,
                            ht.id as status_transaksi,
                            ht.created_at as tgltransaksi,
                            ht.total_biaya totaltransaksi,
                            ht.tgl_awal tgltransaksi1,
                            ht.tgl_akhir tgltransaksi2,
                            ht.name nametransaksi,
                            ht.biaya_kamar biayatransaksi,
                            ht.biaya_tambahan biayatambahtransaksi,
                            ht.tipe tipetransaksi,
                            ht.no_kamar kamartransaksi,
                            ht.jml_bulan blntransaksi,
                            ht.handphone hptranaksi,
                            ht.invoice,
                            mk.jml_bulan_booking
                        ";
                        
                        $table = "
                            kamar k
                            LEFT JOIN mapping_kamar mk ON k.id = mk.id_kamar
                            LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                            LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id and fs.penyedia = 'pihak kos'
                            LEFT JOIN tipe_kamar tk ON mk.id_tipe = tk.id
                            LEFT JOIN users us ON mk.user_id = us.id
                            LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id and fsp.penyedia = 'penghuni'
                            LEFT JOIN history_transaksi ht ON ht.user_id = mk.user_id AND ht.tgl_awal = mk.tgl_awal
                                AND ht.tgl_akhir = mk.tgl_akhir
                        ";
                        $where = " 
                            mk.user_id is not null and mk.tgl_awal is not null
                        ";
                        $sisawaktu = $request->sisawaktu ;
                        $statusbayar = $request->status ;
                        if($rolelogin != 'superadmin' && $rolelogin != 'penjaga' && $rolelogin != 'pemilik'){
                            $where  .=" AND us.id = $idlogin ";
                        }
                        if($sisawaktu){
                            $where .="
                                AND DATEDIFF(CONVERT(mk.tgl_akhir,date) , CURRENT_DATE) $sisawaktu 
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
                            ht.created_at,
                            ht.total_biaya,
                            ht.tgl_awal,
                            ht.tgl_akhir,
                            ht.name,
                            ht.biaya_kamar,
                            ht.biaya_tambahan,
                            ht.tipe,
                            ht.no_kamar,
                            ht.jml_bulan,
                            ht.handphone,
                            ht.invoice,
                            mk.jml_bulan_booking
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

                        
                        $idlogin    = strtolower($MasterClass->getSession('user_id'));
                        $rolelogin  = strtolower($MasterClass->getSession('role_name'));
                        $fbln       = $request->fbln;
                        DB::beginTransaction();     
                        
                        $status = [];
                        
                        $select = "
                            ht.*
                        ";
                        
                        $table = "
                        history_transaksi ht
                        ";
                        $where = " 
                            ht.user_id is not null 
                        ";
                        if($fbln){
                            $where .= " and DATE_FORMAT(created_at, '%Y-%m') = '$fbln' ";
                        }

                        if($rolelogin != 'superadmin' && $rolelogin != 'penjaga' && $rolelogin != 'pemilik'){
                            $where  .=" AND ht.user_id = $idlogin ";
                        }
                        $where .= " 
                        order by created_at desc
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
        public function getfotokamar(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
    
                        $saved = DB::select("SELECT * FROM foto_kamar where id_kamar = ".$request->id);
                        $saved = $MasterClass->checkErrorModel($saved);
                        
                        $status = $saved;
            
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
        public function cekdatakamar(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();
                        
                        $id     = $request->id ;
                        $status = [];
                        
                        $select = "
                            k.id as idkamar,k.no_kamar,k.lantai,k.harga,
                            GROUP_CONCAT(f.fasilitas SEPARATOR ',') as faskos,
                            tk.tipe,tk.id as idtipe
                        ";
                        $from   = " 
                            kamar k 
                            join mapping_kamar mk on mk.id_kamar = k.id
                            join mapping_fasilitas mf on mf.id_kamar = k.id
                            join fasilitas f on f.id = mf.id_fasilitas and f.penyedia = 'pihak kos'
                            join tipe_kamar tk on tk.id = mk.id_tipe
                        ";
                        $where = " k.id = $id and mk.user_id is null";
                        $where .="
                            GROUP BY 
                            k.id,k.no_kamar,k.lantai,k.harga,
                            tk.tipe,tk.id
                        ";
                        // print_r("SELECT $select FROM $from WHERE $where");die;
                        $saved = DB::select("SELECT $select FROM $from WHERE $where");
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
        public function tipeKamar(Request $request){

            $data = json_decode($request->getContent());

            DB::beginTransaction();

            $status = [];

            $saved = DB::select("SELECT * FROM tipe_kamar ");

            // if($status['code'] == $MasterClass::CODE_SUCCESS){
            //     DB::commit();
            // }else{
            //     DB::rollBack();
            // }

            $results = [
                'code' => '0',
                'info'  => 'ok',
                'data'  =>  $saved,
            ];

            return $results;
        }
        public function listkamaravailable(Request $request){

            $MasterClass = new Master();

            try {
                DB::beginTransaction();
                    
                $status = [];
                
                $select = "
                    k.id as idkamar,k.no_kamar,k.lantai,k.harga,
                    GROUP_CONCAT(f.fasilitas SEPARATOR ',') as faskos,
                    tk.tipe,tk.id as idtipe,fk.alamat,fk.file,fk.jenis
                ";
                $from   = " 
                    kamar k 
                    join mapping_kamar mk on mk.id_kamar = k.id
                    join mapping_fasilitas mf on mf.id_kamar = k.id
                    join fasilitas f on f.id = mf.id_fasilitas and f.penyedia = 'pihak kos'
                    join tipe_kamar tk on tk.id = mk.id_tipe
                    join foto_kamar fk on fk.id_kamar = k.id and fk.jenis='sampul'
                ";
                $where = " mk.user_id is null";
                $where .="
                    GROUP BY 
                    k.id,k.no_kamar,k.lantai,k.harga,
                    tk.tipe,tk.id,fk.alamat,fk.file,fk.jenis
                ";
                $saved = DB::select("SELECT $select FROM $from WHERE $where");
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
                    
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
            
            return $MasterClass->Results($results);

        }
        public function getdataprofile(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
    
                        $saved = DB::select("SELECT * FROM users where id = ".$MasterClass->getSession('user_id'));
                        $saved = $MasterClass->checkErrorModel($saved);
                        
                        $status = $saved;
            
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
        public function getva(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                $status = [];
                    $id = $MasterClass->getSession('user_id') ;
                    // $id = 21 ;
                        $select              = " 
                            us.name,us.handphone,k.*,mk.tgl_awal,mk.tgl_akhir,tk.tipe as tipe_kamar,
                            mk.jml_bulan_booking as jmlbulan,ur.role_name,
                            GROUP_CONCAT(fs.fasilitas SEPARATOR ',') as faskos,
                            GROUP_CONCAT(fsp.fasilitas SEPARATOR ',') as faskosp
                        ";
                        $table              = " 
                            users us
                            LEFT JOIN users_roles ur ON ur.id = us.role_id
                            LEFT JOIN mapping_kamar mk ON us.id = mk.user_id
                            LEFT JOIN kamar k ON k.id = mk.id_kamar
                            LEFT JOIN tipe_kamar tk ON tk.id = mk.id_tipe
                            LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                            LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id AND fs.penyedia = 'pihak kos'
                            LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id AND fsp.penyedia = 'penghuni'

                        ";
                        $where              = " 
                            us.id = $id
                            GROUP BY
                            us.name,us.handphone,mk.tgl_awal,mk.tgl_akhir,tk.tipe,
                            mk.jml_bulan_booking,
                            k.id,k.harga,k.no_kamar,k.lantai,ur.role_name
                        ";
                    $cekdata           = DB::select("select $select from $table where $where");
                    $saved = $MasterClass->checkErrorModel($cekdata);
                    // dd($saved);
                    $status = $saved;
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                return $MasterClass->Results($results);
            }
         

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
                                    'handphone'=> $data->handphone,
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
                                    'handphone'=> $data->handphone,
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
                        $fasilitasperbaikan = $request->fasilitasperbaikan;
                        $penghuni           = $request->penghuni;
                        $durasi             = $request->durasi;
                        $jmlbulan           = $request->jmlbulan;
                        $tglawal            = null;
                        $tglakhir           = null;
                        if($penghuni){
                            // $tglawal        = explode(" ",$durasi)[0];
                            // $tglakhir       = explode(" ",$durasi)[2];
                            $tglawal       = date("Y-m-d",strtotime($durasi)) ;
                            $tglakhir      = date("Y-m-d", strtotime("+".$jmlbulan." month", strtotime($tglawal))) ;
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
                        }elseif($tipe == 'update'){
                            if($request->noold != $no){
                                $cekkamar = $MasterClass->selectGlobal("*",'kamar',"no_kamar= '$no'");
                                if(count($cekkamar['data']) >= 1){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "No Kamar sudah tersedia",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }

                            $attrkamar     = [
                                'no_kamar'  => $no,
                                'lantai'    => $lantai,
                                'harga'     => $harga,
                                'created_at'=> $now,
                            ];
                            $where     = [
                                'id' => $id
                            ];
                            $savedkamar      = $MasterClass->updateGlobal('kamar', $attrkamar, $where );
                            if($savedkamar['code'] != '0'){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal update data kamar",
                                ];
                                return $MasterClass->Results($results);
                            }
                            
                            $attrmapping     = [
                                'user_id'       => $penghuni,
                                'id_tipe'       => $tipekamar,
                                'tgl_awal'      => $tglawal,
                                'tgl_akhir'     => $tglakhir,
                                'created_at'    => $now,
                            ];
                            $where = [
                                'id_kamar'      => $id,
                            ];
                            $savedmapping      = $MasterClass->updateGlobal('mapping_kamar', $attrmapping,$where );
                            if($savedmapping['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal update data kamar",
                                ];
                                return $MasterClass->Results($results);
                            }

                            //save mapping fasilitas kos
                            $MasterClass->deleteGlobal('mapping_fasilitas', $where );
                            $fasilitas = explode(",",$fasilitas) ;
                            foreach ($fasilitas as $value) {
                                $attrmappingfas     = [
                                    'id_kamar'      => $id,
                                    'id_fasilitas'  => $value,
                                    'created_at'    => $now,
                                ];
                                $savedmappingfas      = $MasterClass->saveGlobal('mapping_fasilitas', $attrmappingfas );
                                if($savedmappingfas['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Gagal update data kamar",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }

                            if($fasilitaspenghuni){
                                //save mapping fasilitas penghuni
                                $fasilitas = explode(",",$fasilitaspenghuni) ;
                                foreach ($fasilitas as $value) {
                                    $attrmappingfas     = [
                                        'id_kamar'      => $id,
                                        'id_fasilitas'  => $value,
                                        'created_at'    => $now,
                                    ];
                                    $savedmappingfas      = $MasterClass->saveGlobal('mapping_fasilitas', $attrmappingfas );
                                    if($savedmappingfas['code'] != $MasterClass::CODE_SUCCESS){
                                        DB::rollBack();
                                        $results = [
                                            'code' => '1',
                                            'info'  => "Gagal update data kamar",
                                        ];
                                        return $MasterClass->Results($results);
                                    }
                                }
                            }

                            //Perbaikan
                            if($fasilitasperbaikan){
                                $fasilitasperbaikan = explode(",",$fasilitasperbaikan) ;
                                foreach ($fasilitasperbaikan as $value) {
                                    $whereperbaikan     = [
                                        'id_fasilitas'  => $value,
                                        'id_kamar'      => $id,
                                    ];
                                    $attrmappingfas     = [
                                        'status'        => 'perbaikan',
                                        'updated_at'    => $now,
                                    ];
                                    $savedmappingfas      = $MasterClass->updateGlobal('mapping_fasilitas', $attrmappingfas,$whereperbaikan );
                                    if($savedmappingfas['code'] != $MasterClass::CODE_SUCCESS){
                                        DB::rollBack();
                                        $results = [
                                            'code' => '1',
                                            'info'  => "Gagal update data kamar",
                                        ];
                                        return $MasterClass->Results($results);
                                    }
                                }
                            }else{
                                $whereperbaikan     = [
                                    'id_kamar'      => $id,
                                ];
                                $attrmappingfas     = [
                                    'status'        => 'aman',
                                    'updated_at'    => $now,
                                ];
                                $savedmappingfas      = $MasterClass->updateGlobal('mapping_fasilitas', $attrmappingfas,$whereperbaikan );
                                if($savedmappingfas['code'] != $MasterClass::CODE_SUCCESS){
                                        DB::rollBack();
                                        $results = [
                                            'code' => '1',
                                            'info'  => "Gagal update data kamar",
                                        ];
                                        return $MasterClass->Results($results);
                                    }
                            }

                            //save foto lainnya jika diganti
                            if(!empty($_FILES['filelainnya']['name'])){
                                //save foto kamar lainnya
                                $MasterClass->deleteGlobal('foto_kamar', [
                                'id_kamar'      => $id,
                                'jenis'         => 'lainnya'
                            ]   );
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
                                            'id_kamar'  => $id,
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
                                                'info'  => "Gagal update data kamar",
                                            ];
                                            return $MasterClass->Results($results);
                                        }
                                    }
    
                                }
                            }
                            
                        }else{ // action save
                            
                            $cekkamar = $MasterClass->selectGlobal("*",'kamar',"no_kamar= '$no'");
                            if(count($cekkamar['data']) >= 1){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "No Kamar sudah tersedia",
                                ];
                                return $MasterClass->Results($results);
                            }
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
                            
                            if($fasilitas){
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
                            }
                            //save mapping fasilitas penghuni
                            if($fasilitaspenghuni){
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

                        if($tipe == 'deleted'){// ini deleted
                            if($status['code'] == $MasterClass::CODE_SUCCESS){
                                DB::commit();
                            }else{
                                DB::rollBack();
                            }

                            $results = [
                                'code'  => $status['code'],
                                'info'  => $status['info'],
                            ];
                        }elseif($tipe == 'update'){// ini update
                            DB::commit();
                            $results = [
                            'code'  => $MasterClass::CODE_SUCCESS,
                            'info'  => 'ok',
                            'data'  => $id, //balikin id kamar untuk save foto sampul
                            ];
                        }else{//ini add
                            DB::commit();
                            $results = [
                            'code'  => $MasterClass::CODE_SUCCESS,
                            'info'  => 'ok',
                            'data'  => $idkamar, //balikin id kamar untuk save foto sampul
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
                        if(!empty($_FILES['form-sampul']['name'])){//jika file ada maka masukan file 
                            $where = [
                                'id_kamar'      => $idkamar,
                                'jenis'         => 'sampul'
                            ];
                            $MasterClass->deleteGlobal('foto_kamar', $where );

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
                        }else{//jika tidak ada anggao sukses
                            $results = [
                                'code'  => $MasterClass::CODE_SUCCESS,
                                'info'  => 'ok',
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
        public function saveBukti(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $idkamar            = $request->idkamar;
                        $user_id            = $request->user_id;
                        $name               = $request->name;
                        $handphone          = $request->handphone;
                        $no_kamar           = $request->no_kamar;
                        $tipe_kamar         = $request->tipe_kamar;
                        $faskos             = $request->faskos;
                        $faskosp            = $request->faskosp;
                        $tgl_awal           = $request->tgl_awal;
                        $tgl_awal_old       = $request->tgl_awal;
                        $tgl_akhir_old      = $request->tgl_akhir;
                        $jmlbulan           = $request->jmlbulan;
                        $harga              = $request->harga;
                        $biayatambah        = $request->biayatambah;
                        $biaya              = $request->biaya;
                        $jenispembayaran    = $request->jenispembayaran;
                        $invoice            = date('YmdHis').'-'.$no_kamar.'-'.$user_id ;
                        if($biayatambah == 'null'){
                            $biayatambah = 0.00;
                        }
                        if($jenispembayaran == '1'){
                            $tgl_akhir          = $tgl_akhir_old;
                        }else{
                            $tgl_awal           = date("Y-m-d", strtotime("+".$jmlbulan." month", strtotime($tgl_awal)));
                            $tgl_akhir          = date("Y-m-d", strtotime("+".$jmlbulan." month", strtotime($tgl_awal)));
                        }

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
                                'invoice'   => $invoice,
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
                                'invoice'           => $invoice,
                                'user_id'           => $user_id,
                                'name'              => $name,
                                'handphone'         => $handphone,
                                'no_kamar'          => $no_kamar,
                                'tipe'              => $tipe_kamar,
                                'fasilitas'         => $faskos,
                                'fasilitas_penghuni'=> $faskosp,
                                'tgl_awal'          => $tgl_awal,
                                'tgl_akhir'         => $tgl_akhir,
                                'tgl_awal_old'      => $tgl_awal_old,
                                'tgl_akhir_old'     => $tgl_akhir_old,
                                'jml_bulan'         => $jmlbulan,
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

                            // update masa kos 1 bulan
                            $attributes     = [
                                'tgl_awal'      => $tgl_awal,
                                'tgl_akhir'     => $tgl_akhir,
                                'updated_at'    => $now,
                            ];
                            $where     = [
                                'id_kamar' => $idkamar,
                                'user_id' => $user_id,
                            ];
                            $updatemasa      = $MasterClass->updateGlobal('mapping_kamar', $attributes,$where );

                            if($updatemasa['code'] != $MasterClass::CODE_SUCCESS){
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
        public function savebooking(Request $request){
            $MasterClass = new Master();
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();
                        $penghuni           = $MasterClass->getSession('user_id');
                        
                        $cekdata = DB::select("SELECT * FROM mapping_kamar mk WHERE mk.user_id = $penghuni");
                        if($cekdata){
                            DB::rollBack();
                            $results = [
                                'code' => '12',
                                'info' => "Anda sudah booking kamar,silahkan untuk menghubungi pihak kos lewat WA",
                            ];
                            return $MasterClass->Results($results);
                        }
                        $id                 = $request->idkamar;                        
                        $durasi             = $request->tanggal;
                        $jmlbulan           = $request->bulan;
                        $tipekamar          = $request->tipe;
                        $tglawal            = null;
                        $tglakhir           = null;
                        if($penghuni){
                            $tglawal       = date("Y-m-d",strtotime($durasi)) ;
                            $tglakhir      = date("Y-m-d", strtotime("+".$jmlbulan." month", strtotime($tglawal))) ;
                        }
                        $now                = date('Y-m-d H:i:s');
                        $attrmapping     = [
                            'user_id'           => $penghuni,
                            'id_tipe'           => $tipekamar,
                            'jml_bulan_booking' => $jmlbulan,
                            'tgl_awal'          => $tglawal,
                            'tgl_akhir'         => $tglakhir,
                            'booking_dtm'       => date('Y-m-d'),
                            'updated_at'        => $now,
                        ];
                        $where     = [
                            'id_kamar'      => $id
                        ];
                        $savedmapping      = $MasterClass->updateGlobal('mapping_kamar', $attrmapping,$where );
                        if($savedmapping['code'] != $MasterClass::CODE_SUCCESS){
                            DB::rollBack();
                            $results = [
                                'code' => '1',
                                'info'  => "Gagal simpan data booking",
                            ];
                            return $MasterClass->Results($results);
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
        public function setujuibooking(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        
                        $tglawal    = date("Y-m-d",strtotime($data->tgl)) ;
                        $tglakhir   = date("Y-m-d", strtotime("+".$data->bln." month", strtotime($tglawal))) ;
                        $mapkam     = DB::update("UPDATE mapping_kamar set tgl_awal = '$tglawal' ,tgl_akhir = '$tglakhir',jml_bulan_booking = $data->bln  where user_id= $data->id ");
                        $users      = DB::update("UPDATE users us set role_id = (select id from users_roles where role_name='penghuni') where id= $data->id ");
                        if($mapkam == 1 && $users == 1){
                            DB::commit();
                            
                            $results = [
                                'code' => '0',
                                'info'  => 'ok',
                            ];
                        }else{
                            $results = [
                                'code' => '1',
                                'info'  => 'Gagal Setujui Booking',
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
        public function deleteTransaksi(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data               = json_decode($request->getContent());                        
                        $status             = [];
                        
                        $gettransaksi       = $MasterClass->selectGlobal('a.*,b.id as idkamar','history_transaksi a join kamar b on a.no_kamar = b.no_kamar','a.id = '.$data->id);
                        $attrmapping        = [
                            'tgl_awal'      => $gettransaksi['data'][0]->tgl_awal_old,
                            'tgl_akhir'     => $gettransaksi['data'][0]->tgl_akhir_old,
                        ];
                        $where = [
                            'user_id'       => $gettransaksi['data'][0]->user_id,
                            'id_kamar'      => $gettransaksi['data'][0]->idkamar,
                        ];
                        $updatemapping      = $MasterClass->updateGlobal('mapping_kamar', $attrmapping,$where );
                        $where     = [
                                'id' => $data->id
                        ];
                        $saved      = $MasterClass->deleteGlobal('history_transaksi', $where );
                        $status = $saved;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS && $updatemapping['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code' => $status['code'],
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
        public function editprofile(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $nama               = $request->nama;
                        $handphone          = $request->handphone;
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'profile';
                        
                        if(!empty($_FILES['form-file']['name'])){

                            $nama_file          = $_FILES['form-file']['name'];
                            $type		        = $_FILES['form-file']['type'];
                            $ukuran		        = $_FILES['form-file']['size'];
                            $tmp_name		    = $_FILES['form-file']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/profile/'; // directory file
                            $filenya         = '/data/profile/'.$nama_file_upload; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file

                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
                            }else{
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal update profile",
                                ];
                                return $MasterClass->Results($results);
                            }

                            $attr     = [
                                'name'          => $nama,
                                'handphone'     => $handphone,
                                'profile'       => $filenya,
                                'updated_at'    => $now,
                            ];
                        }else{
                            $attr     = [
                                'name'          => $nama,
                                'handphone'     => $handphone,
                                'updated_at'    => $now,
                            ];
                        }

                        $where = [
                            'id'      => $MasterClass->getSession('user_id'),
                        ];
                        $updated      = $MasterClass->updateGlobal('users', $attr,$where );
                        if($updated['code'] != $MasterClass::CODE_SUCCESS){
                            DB::rollBack();
                            $results = [
                                'code' => '1',
                                'info'  => "Gagal update profile",
                            ];
                            return $MasterClass->Results($results);
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
        public function updatekamar7hari(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $users      = DB::update("UPDATE mapping_kamar mk set tgl_awal = null ,tgl_akhir = null,jml_bulan_booking = null,booking_dtm = null,user_id = null WHERE DATEDIFF(CONVERT(mk.tgl_akhir,date) , CURRENT_DATE)  < -7");
                        $results = [
                            'code' => '0',
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
        public function cancelbooking(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $users      = DB::update("UPDATE mapping_kamar mk set tgl_awal = null ,tgl_akhir = null,jml_bulan_booking = null,booking_dtm = null,user_id = null WHERE DATEDIFF(CONVERT(mk.booking_dtm,date) , CURRENT_DATE)  < -2");
                        $results = [
                            'code' => '0',
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
        public function cekmasakos(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $userid     = $MasterClass->getSession('user_id');
                        $select     = "
                                        DATEDIFF(CONVERT(mk.tgl_akhir,date) , CURRENT_DATE) as masa
                        ";
                        $users      = DB::select("SELECT $select FROM mapping_kamar mk where user_id = $userid ");
                        $results = [
                            'code'  => '0',
                            'info'  => 'ok',
                            'data'  => $users
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
        public function SaveVa(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $user_id            = $MasterClass->getSession('user_id') ;
                        $select              = " 
                            us.name,us.handphone,k.*,mk.tgl_awal,mk.tgl_akhir,tk.tipe as tipe_kamar,
                            mk.jml_bulan_booking as jmlbulan,
                            GROUP_CONCAT(fs.fasilitas SEPARATOR ',') as faskos,
                            GROUP_CONCAT(fsp.fasilitas SEPARATOR ',') as faskosp
                        ";
                        $table              = " 
                            users us
                            LEFT JOIN mapping_kamar mk ON us.id = mk.user_id
                            LEFT JOIN kamar k ON k.id = mk.id_kamar
                            LEFT JOIN tipe_kamar tk ON tk.id = mk.id_tipe
                            LEFT JOIN mapping_fasilitas mf ON k.id = mf.id_kamar
                            LEFT JOIN fasilitas fs ON mf.id_fasilitas = fs.id AND fs.penyedia = 'pihak kos'
                            LEFT JOIN fasilitas fsp ON mf.id_fasilitas = fsp.id AND fsp.penyedia = 'penghuni'

                        ";
                        $where              = " 
                            us.id = $user_id
                            GROUP BY
                            us.name,us.handphone,mk.tgl_awal,mk.tgl_akhir,tk.tipe,
                            mk.jml_bulan_booking,
                            k.id,k.harga,k.no_kamar,k.lantai
                        ";
                        $getkamar           = DB::select("select $select from $table where $where");
                        
                        $idkamar            = $getkamar[0]->id;
                        $name               = $getkamar[0]->name;
                        $handphone          = $getkamar[0]->handphone;
                        $no_kamar           = $getkamar[0]->no_kamar;
                        $tipe_kamar         = $getkamar[0]->tipe_kamar;
                        $faskos             = $getkamar[0]->faskos;
                        $faskosp            = $getkamar[0]->faskosp;
                        $tgl_awal           = $getkamar[0]->tgl_awal;
                        $tgl_akhir          = $getkamar[0]->tgl_akhir;
                        $jmlbulan           = $getkamar[0]->jmlbulan;
                        $harga              = $getkamar[0]->harga;
                        $biaya              = $getkamar[0]->harga * $jmlbulan;
                        $invoice            = date('YmdHis').'-'.$no_kamar.'-'.$user_id ;
                        
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'bukti';

                        $nama_file          = $_FILES['formbayar']['name'];
                        $type		        = $_FILES['formbayar']['type'];
                        $ukuran		        = $_FILES['formbayar']['size'];
                        $tmp_name		    = $_FILES['formbayar']['tmp_name'];
                        $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                        $alamatfile         = '../public/data/bukti/'; // directory file
                        $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                        
                        if (move_uploaded_file($tmp_name,$uploaddir)){
                            chmod($uploaddir, 0777);

                            $attrphoto     = [
                                'user_id'   => $user_id,
                                'invoice'   => $invoice,
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
                                'invoice'           => $invoice,
                                'user_id'           => $user_id,
                                'name'              => $name,
                                'handphone'         => $handphone,
                                'no_kamar'          => $no_kamar,
                                'tipe'              => $tipe_kamar,
                                'fasilitas'         => $faskos,
                                'fasilitas_penghuni'=> $faskosp,
                                'tgl_awal'          => $tgl_awal,
                                'tgl_akhir'         => $tgl_akhir,
                                'tgl_awal_old'      => $tgl_awal,
                                'tgl_akhir_old'     => $tgl_akhir,
                                'jml_bulan'         => $jmlbulan,
                                'biaya_kamar'       => $harga,
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

                            $updaterole      = DB::update("UPDATE users us set role_id = (select id from users_roles where role_name='penghuni') where id= $user_id ");
                            if($updaterole != 1){
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
        public function batalbooking(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        
                        $mapkam     = DB::update("UPDATE mapping_kamar set tgl_awal = null ,tgl_akhir = null,jml_bulan_booking = null,booking_dtm = null,user_id = null  where user_id= ".$MasterClass->getSession('user_id'));
                        if($mapkam == 1){
                            DB::commit();
                            
                            $results = [
                                'code' => '0',
                                'info'  => 'ok',
                            ];
                        }else{
                            $results = [
                                'code' => '1',
                                'info'  => 'Permintaan Gagal',
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

}
