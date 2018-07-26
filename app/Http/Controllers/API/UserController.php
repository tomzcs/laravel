<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
public $successStatus = 200;
/**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
      // return response()->json(['status' => false,'message' => 'Unauthorised' , 'data' => $request->all()], 200);

      $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required'
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
          $user = Auth::user();
          $success = [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'img'   => DB::table('imgpfs')->where('userId', $user->id)->value('imgName'),
            'token' => $user->createToken('MyApp')-> accessToken
          ];
          return response()->json(['status' => true,'message' => 'login success','data' => $success], $this-> successStatus);
      }
      else{
          return response()->json(['status' => false,'message' => 'Unauthorised'], 401);
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
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->roles()->attach(Role::where('name', 'mobile')->first());

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
    public function InsertImg(Request $request,ImageOptimizer $imageOptimizer)
    {
      $validator = Validator::make($request->all(), [
          'files' => 'required',
          'userId' => 'required'
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $file_data = $request->input('files');
      $userId = $request->input('userId');
      $imgpf = DB::table('imgpfs')->where('userId', $userId)->get();
      // dd($imgpf);
      // Storage::delete('public/'.$imgpf->imgName);

      $file_name = 'image_'.time().'.png'; //generating unique file name;
      @list($type, $file_data) = explode(';', $file_data);
      @list(, $file_data) = explode(',', $file_data);
      if($file_data!=""){ // storing image in storage/app/public Folder
            // optimize
            $imageOptimizer->optimizeUploadedImageFile(base64_decode($file_data));
            Storage::disk('public')->put($file_name,base64_decode($file_data));
       }
      $data = [
        'name' => $file_name,
        'path' =>  url('storage/'.$file_name)
      ];

      if ($imgpf->isEmpty()) {
        // insert
        DB::table('imgpfs')->insert(['userId' => $userId, 'imgName' => $file_name]);
      }else{
        //update
        Storage::disk('public')->delete($imgpf[0]->imgName);
        DB::table('imgpfs')
                    ->where('userId', $userId)
                    ->update(['imgName' => $file_name]);
      }

      return response()->json(['status' => true,'message' => 'success','data' =>$data], $this-> successStatus);

    }

    public function Air($id)
    {
      return response()->json(['status' => true,'message' => 'success','data' => DB::table('airs')->where('userId', $id)->get()],$this-> successStatus);
    }

    public function InsertVideo(Request $request)
    {
      $parm = $request->all();
      $file_data = $parm['video'];
      $file_name = 'video_'.time().'.mp4'; //generating unique file name;
      @list($type, $file_data) = explode(';', $file_data);
      @list(, $file_data) = explode(',', $file_data);
      if($file_data!=""){ // storing image in storage/app/public Folder
             Storage::disk('public')->put($file_name,base64_decode($file_data));
       }
      return response()->json(['status' => true,'message' => 'success','data' => url('storage/'.$file_name)],$this-> successStatus);

    }


// -----------------------------------------------------------------------------end
}
