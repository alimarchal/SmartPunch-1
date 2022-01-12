<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Mail\OTPSent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $adminRole = Role::with('permissions')->where('name', 'admin')->first();
        $permissions = $adminRole->permissions->pluck('name');

        $otp = mt_rand(1000, 9999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'mac_address' => $request->mac_address,
            'user_role' => $adminRole->id,
            'otp' => $otp,
        ])->assignRole($adminRole)->syncPermissions($permissions);

        Mail::to($user->email)->send(new OTPSent($user->otp));

        return response([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user,
            'permission' => $user->getAllPermissions(),
            'role' => $adminRole
        ], 200);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password) || $user->status == 0) {
            /*throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);*/
            if (!$user || !Hash::check($request->password, $user->password))
            {
                return response([
                    'email' => ['The provided credentials are incorrect.'],
                ], 200);
            }
            elseif ($user->status == 0)
            {
                return response([
                    'status' => ['Your account is suspended'],
                ], 200);
            }
        }

        $user->device_name = $request->device_name;
        $user->save();
        return response([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'permission' => $user->getAllPermissions(), 'user' => $user,
            'user_role' => Role::findById($user->user_role)
        ], 200);

    }

    /**
     * @param Request $request
     * @return string[]
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged out'], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = null;
        if ($request->has('business_id')) {
            $user = User::with('office')->where('business_id', $request->business_id)->get();
        } elseif ($request->has('office_id')) {
            $user = User::where('office_id', $request->office_id)->get();
        } elseif ($request->has('business_id') && $request->has('office_id')) {
            $user = User::where('business_id', $request->business_id)->where('office_id', $request->office_id)->get();
        } else {
            $user = User::paginate(10);
        }
        return response()->json($user, 200);

    }

    public function email_notification(Request $request)
    {
        $user = User::find($request->user_id);
        if (!empty($user)) {
            $user->sendEmailVerificationNotification();
            return response()->json('Verification link sent!', 200);
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            $office = $user->office();
            $permissions = $user->getAllPermissions();
            return response()->json(['user' => $user, 'office' => $office, 'permissions' => $permissions], 200);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $user->update($request->all());
            return response()->json($user, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'string', 'max:255'],
        ],[
            'otp.required' => 'OTP is required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::findOrFail(auth()->user()->id);

        if ($user->otp != $request->otp)
        {
            return response([
                'error' => ['Incorrect OTP entered.'],
            ], 200);
        }
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();

        return response([
            'user' => 'verified'
        ], 200);
    }
}
