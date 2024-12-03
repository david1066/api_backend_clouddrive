<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendTwoFactorCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    // Register API, Login API, Profile API, Logout API
   

    public function __construct() {
        $this->errorPermission= response()->json([
            "code" => 401,
            "status" => "error",
            "message"=> "unauthorization"
        ], 401);
    }


    // POST [name, email, password]
    public function store(Request $request)
    {
       
        // Validation
        try{
            $request->validate([
                "name" => "required|string",
                "last_name" => "required|string",
                "email" => "required|string|email:rfc,dns|unique:users",
                "password" => "required|confirmed"
            ]);
            
        }catch(\Exception $e){
            return response()->json([
                "code"=>404,
                "status" => 'error',
                "message" => $e->getMessage(),
                
            ],404);
        }
        

        // User
        $user=User::create([
            "name" => $request->name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
                   
        ]);
       

        return response()->json([
            "code"=>200,
            "status" => 'success',
            "message" => "User registered successfully",
            
        ],200);
    }

    // POST [email, password]
    public function login(Request $request)
    {

        // Validation
        $request->validate([
            "email" => "required|string",
            "password" => "required"
        ]);

        // Email check
        $user = User::whereraw("name = ?", $request->name)->where('state_id',1)->first();
        $specifiedDate = Carbon::parse($user->two_factor_expires_at); 
       
        if($user->two_factor && empty($request->two_factor_code)){
            $user->generateTwoFactorCode();
            $user->notify(new SendTwoFactorCode());

            return response()->json([
                "code" => 201,
                "status" => "success",
                "message"=> "The code have been send to  your email"
              
            ], 201);
        }

        if (!empty($user)) {

            // User exists
            if (Hash::check($request->password, $user->password)) {

                
                if($user->two_factor && !empty($request->two_factor_code) && $request->two_factor_code==$user->two_factor_code){
                     
                    $specifiedDate = Carbon::parse($user->two_factor_expires_at); 
                    $user->resetTwoFactorCode();
                    // Comparar con la fecha actual 
                    if (Carbon::now()->isAfter($specifiedDate)) {
                    
                        return response()->json([
                            "code" => 404,
                            "status" => "error",
                            "message"=> "Code expires"
                        ], 404);
                    }
                    
                   
                }else if($user->two_factor && !empty($request->two_factor_code) && $request->two_factor_code!=$user->two_factor_code){
                    return response()->json([
                        "code" => 404,
                        "status" => "error",
                        "message"=> "Code invalid"
                    ], 404);
                }
               
                // Password matched
                $token = $user->createToken("mytoken")->plainTextToken;

                
                  return response()->json([
                        "code" => 200,
                        "status" => "success",
                        "_token" => $token,
                        "_user"=>$user,
                    ], 200);

                

                return response()->json([
                    "code" => 404,
                    "status" => "error",
                    "message"=> "invalid credencials"
                ], 404);
               
            } else {

                return response()->json([
                    "code" => 404,
                    "status" => "error",
                    "message"=> "invalid credencials"
                ], 404);
            }
        } else {

            return response()->json([
                "code" => 404,
                "status" => "error",
                "message"=> "invalid credencials"
            ], 404);
        }
    }

     // PUT
     public function update(Request $request)
     {
     
         // Validation
        try{
            $request->validate([

            
                "name" => "required|string",
                "last_name" => "required|string",
                 //debe ser unico a excepcion de el mismo usuario
                "email" => "required|string|email:rfc,dns|unique:users,email,".Auth::user()->id,
            ]);
            
        }catch(\Exception $e){
            return response()->json([
                "code"=>404,
                "status" => 'error',
                "message" => $e->getMessage(),
                
            ],404);
        }
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'two_factor' => !empty($user->email_verified_at) ? $request->two_factor : $user->two_factor,
            'password' => !empty($request->password) ? bcrypt($request->password) : $user->password,
        ]);
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Updated successfully',
        ], 200);
        
        
    }

   

    // GET USER ID Y GET ALL
    public function show()
    {
        $user=Auth::user();

    
        return response()->json([
            'code'=>200,
            "status" => 'success',
            "user"=>$user
        ],200);
    }

    // GET [Auth: Token]
    public function logout()
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            'code'=>200,
            "status" => 'success',
            "message" => "logged out",
            
        ],200);
    }

 
}
