<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\PasswordReset;
use App\Mail\VerifyMailable;
use App\Mail\WelcomeMailable;
use App\Mail\ForgetMailable;
use App\Mail\ResetMailable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthStoreRequest;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ResetRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', 
                ['except' => ['login', 'register', 'verification', 'forget', 'reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthStoreRequest $request)
    {
        
        try {
            $row = User::where('email', request('email'))->where('status', 0)->first();
            if($row) {
                $user               = User::findOrFail($row->id);
            } else {
                $user               = new User;
            }
                $user->first_name   = request('first_name');
                $user->last_name    = request('last_name');
                $user->email        = request('email');
                $user->country      = request('country') ?? NULL;
                $plainPassword      = request('password');
                $user->password     = app('hash')->make($plainPassword);
                $user->verification = $user->id.mt_rand(100000,999999);
                $user->save();

                $data = EmailTemplate::find(1);

                // Send Email
                try {
                    Mail::to($user->email)->send(new VerifyMailable($user, $data));
                } catch (\Exception $e) { }

            return response()->json(['message' => ''], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verification()
    {   
        $row = User::where('verification', request('verification'))->first();
        if($row) {
            $row->verification = NULL;
            $row->active = true;
            $row->save();
            $data = EmailTemplate::find(1);
            return response()->json(['message' => ''], 200);

            // Send Email
            try {
                Mail::to($row->email)->send(new WelcomeMailable($row, $data));
            } catch (\Exception $e) { }

        } else {
            return response()->json(['message' => 'Invalid Verification Code!'], 409);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if(auth()->guard('api')->user()->role_id == 1) {
            auth()->logout();
            return response()->json(['error' => 'Access denied'], 403);
        }
        if(auth()->guard('api')->user()->active == 0) {
            auth()->logout();
            return response()->json(['error' => 'Please verifiy your account'], 403);
        }
        
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => new UserResource(User::findOrFail(auth()->guard('api')->user()->id)),
        ], 200);
    }




    public function forget(ForgetRequest $request)
    {
        $isExist = User::where('email', $request->email)->first();
        if($isExist) {
            PasswordReset::where('email', $request->email)->delete();
        }

        $token = $isExist->id.mt_rand(100000,999999);
        $row = PasswordReset::create(['email' => $request->email, 'token' => $token]);
        $data = EmailTemplate::find(1);
            // Send Email
            try {
                Mail::to($request->email)->send(new ForgetMailable($row, $data));
            } catch (\Exception $e) { }

        if($row) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to find email, ' . $row], 500);
        }
    }

    public function reset(ResetRequest $request)
    {
        $row           = User::where('email', $request->email)->first();
        $plainPassword = request('new_password');
        $row->password = app('hash')->make($plainPassword);
        $row->save();
        PasswordReset::where('email', $request->email)->delete();
        $data = EmailTemplate::find(1);
            // Send Email
            try {
                Mail::to($row->email)->send(new ResetMailable($row, $data));
            } catch (\Exception $e) { }

        if($row) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to reset password, ' . $row], 500);
        }
    }
}