<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
class UserController extends Controller
{
public $successStatus = 200;
/**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json([
                                      'status' => true,
                                      'message' => 'login success',
                                      'data' => $success
                                    ], $this-> successStatus);
        }
        else{
            return response()->json(['status' => false,'message'=>'Unauthorised'], 401);
        }
    }
/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
$input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
return response()->json(['success'=>$success], $this-> successStatus);
    }
/**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json([
                                  'status' => true,
                                  'message' => 'success',
                                  'data' => $user
                                ], $this-> successStatus);
    }


    public function latlong()
    {
      return response()->json([
                                'status' => true,
                                'message' => 'success',
                                'data' => DB::table('latlongs')->get()
                              ], $this-> successStatus);
    }
}
