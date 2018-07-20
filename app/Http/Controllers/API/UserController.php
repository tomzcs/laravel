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
            return response()->json(['status' => true,'message' => 'login success','data' => $success], $this-> successStatus);
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
        return response()->json(['status' => true,'message' => 'success','data' => $user], $this-> successStatus);
    }


    public function latlong()
    {
      return response()->json(['status' => true,'message' => 'success','data' => DB::table('latlongs')->get()],$this-> successStatus);
    }

    //get image Base64
    public function InsertImg(Request $request)
    {
      $file_data = $request->input('files');
      if ($file_data) {
        $file_name = 'image_'.time().'.png'; //generating unique file name;
        @list($type, $file_data) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data);
        if($file_data!=""){ // storing image in storage/app/public Folder
               \Storage::disk('public')->put($file_name,base64_decode($file_data));
         }
        $data = [
          'name' => $file_name,
          'path' =>  url('storage/'.$file_name)
        ];
        return response()->json(['status' => true,'message' => 'success','data' =>$data], $this-> successStatus);
      }else{
        return response()->json(['status' => false,'message' => 'The files field is required.'], 401);
      }


    }


// -----------------------------------------------------------------------------end
}
