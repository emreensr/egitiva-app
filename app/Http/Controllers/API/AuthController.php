<?php

namespace App\Http\Controllers\API;

use Hash;
use Validator;
use App\Models\User;
use App\Models\Teacher;
use App\Models\UserInfo;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\CourseRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'studentRegister', 'teacherRegister', 'forgotPassword', 'resetPassword']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where([
            'email' => $request->email
        ])->first();

        if ($user) {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Kullanıcı bilgileri yanlış.'
                ], 401);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'details' => [
                    'user' => $user,
                ],

            ], 200);
        } else {
            return response()->json(['error' => 'Kullanıcı bilgileri yanlış!'], 401);
        }
    }

    public function studentRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string|min:6|max:11',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'level_id' => 'required|integer',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'expectations' => 'required|string|between:2,300',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        $course_request = new CourseRequests();
        $course_request->user_id = $user->id;
        $course_request->category_id = $request->category_id;
        $course_request->sub_category_id = $request->sub_category_id;
        $course_request->level_id = $request->level_id;
        $course_request->city_id = $request->city_id;
        $course_request->district_id = $request->district_id;
        $course_request->expectations = $request->expectations;
        $course_request->save();

        $token = $user->createToken('authToken')->plainTextToken;

        // Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'details' => [
                'user' => $user,
            ],
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

        return $this->createNewToken($user);
    }

    public function teacherRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string|min:6|max:11'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        $teacher = new Teacher();
        $teacher->user_id = $user->id;
        $teacher->save();

        $token = $user->createToken('authToken')->plainTextToken;

        // Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'details' => [
                'user' => $user,
            ],
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

        return $this->createNewToken($user);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'The email does not exist in our system'], 404);
        }


        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent to email.'], 200);
        } else {
            return response()->json(['message' => 'Unable to send password reset link.'], 422);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unable to reset password.'], 422);
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function updateUserInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'file|nullable',
            'company' => 'string|min:6|nullable',
            'phone' => 'string|min:6|nullable',
            'website' => 'string|nullable',
            'country' => 'string|nullable',
            'ord_state' => 'integer|nullable',
            'ord_city' => 'integer|nullable',
            'ord_county' => 'integer|nullable',
            'ord_street' => 'string|nullable',
            'ord_location' => 'string|nullable',
            'ord_houseNumber' => 'string|nullable',
            'ord_postcode' => 'string|nullable',
            'sameAddress' => 'boolean|nullable',
            'bil_state' => 'integer|nullable',
            'bil_city' => 'integer|nullable',
            'bil_county' => 'integer|nullable',
            'bil_street' => 'string|nullable',
            'bil_location' => 'string|nullable',
            'bil_houseNumber' => 'string|nullable',
            'bil_postcode' => 'string|nullable',
            'language' => 'string|nullable',
            'timezone' => 'string|nullable',
            'currency' => 'string|nullable',
            'communication' => 'string|nullable',
            'marketing' => 'boolean|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!Auth::guard('sanctum')->check()) {
            // User is not authenticated.
            return response()->json([
                'error' => 'User with this token is not found or not authenticated!'
            ], 404);
        }

        $user = Auth::guard('sanctum')->user();

        $userInfo = UserInfo::where('user_id', $user->id)->first();
        if (!$userInfo) {
            $userInfo = new UserInfo();
        }

        // include to save avatar
        if ($request->avatar) {
            if ($avatar = $this->upload()) {
                if (request()->hasFile('avatar')) {
                    if ($userInfo->avatar) {
                        File::delete($userInfo->avatar);
                    }
                }
                $userInfo->avatar = $avatar;
            }
        }

        $userInfo->user_id = $user->id;
        $userInfo->company = $request->company;
        $userInfo->phone = $request->phone;
        $userInfo->website = $request->website;
        $userInfo->ord_state = $request->ord_state;
        $userInfo->ord_city = $request->ord_city;
        $userInfo->ord_county = $request->ord_county;
        $userInfo->ord_street = $request->ord_street;
        $userInfo->ord_location = $request->ord_location;
        $userInfo->ord_houseNumber = $request->ord_houseNumber;
        $userInfo->ord_postcode = $request->ord_postcode;
        $userInfo->sameAddress = $request->sameAddress;
        $userInfo->bil_state = isset($request->bil_state) ? $request->bil_state : $request->ord_state;
        $userInfo->bil_city = isset($request->bil_city) ? $request->bil_city : $request->ord_city;
        $userInfo->bil_county = isset($request->bil_county) ? $request->bil_county : $request->ord_county;
        $userInfo->bil_street = isset($request->bil_street) ? $request->bil_street : $request->ord_street;
        $userInfo->bil_location = isset($request->bil_location) ? $request->bil_location : $request->ord_location;
        $userInfo->bil_houseNumber = isset($request->bil_houseNumber) ? $request->bil_houseNumber : $request->ord_houseNumber;
        $userInfo->bil_postcode = isset($request->bil_postcode) ? $request->bil_postcode : $request->ord_postcode;
        $userInfo->communication = $request->communication;
        $userInfo->marketing = $request->marketing;

        $userInfo->country = $request->country ?? 'DE';
        $userInfo->language = $request->language ?? 'de';
        $userInfo->timezone = $request->timezone ?? 'Berlin';
        $userInfo->currency = $request->currency ?? 'EUR';

        $userInfo->save();

        $user = User::findOrFail($userInfo->user_id);

        return response()->json([
            'status' => 'success',
            'message' => 'User\'s Information updated successfully',
            'details' => [
                'user' => $user,
                'user_info' =>  $userInfo
            ]
        ]);
    }

    public function upload($folder = 'images', $key = 'avatar', $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes')
    {
        request()->validate([$key => $validation]);

        $file = null;

        if (request()->hasFile($key)) {
            $file = request()->file($key);
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public_uploads')->putFileAs($folder, $file, $fileName);

            $file = 'uploads/' . $path;
        }

        return $file;
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($user)
    {
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
