<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Area;
use App\SupplierArea;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = "/";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRegister()
    {
        $areas = Area::select('id','name')->orderBy('name','ASC')->get();
        

        return view('auth.register',compact('areas'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type'=> ['required'],
            'area_id'=>['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    { 
      
      
        if($request->user_type == 'Supplier')       
       {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'confirmPassword'=>['required','string','min:8'],
                'user_type'=> ['required'],
                'contact_no'=>['required','numeric'],     
                'areas'=>['required']       
            ]); 
       }else
       {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'confirmPassword'=>['required','string','min:8'],
                'user_type'=> ['required'],
                'contact_no'=>['required','numeric'],            
            ]);       
       }

        try {
                $result= 0;
                $area = $request->areas;
                DB::beginTransaction();                
              
                $user = new User();
                $user->name = $request->name;            
                $user->email = $request->email;            
                $user->user_type = $request->user_type; 
                $user->contact_no = $request->contact_no;
                $user->password = Hash::make($request->password);   
                $result = $user->save();

                if($request->user_type == 'Supplier')      
               {
                    foreach ($area as $value) {
                        $supplierArea = new SupplierArea();
                        $supplierArea->user_id = $user->id;
                        $supplierArea->area_id = $value['id'];
                        $result = $supplierArea->save();
                    }
               }
         
                DB::commit();
                if($result)
                    return 1;
                else
                    return 0;
        } catch (Exception $th) {
                DB::rollback();
                return $th;
        }

        
    }
}
