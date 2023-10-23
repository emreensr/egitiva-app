<?php

namespace App\Http\Controllers\API;

use Hash;
use Exception;
use Validator;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserInfo;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\CourseRequests;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'studentRegister', 'teacherRegister', 'forgotPassword', 'resetPassword']]);
    }

    public function login(UserLoginRequest $request)
    {

        try {
            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Kullanıcı bulunamadı.'
                ], 404);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Kullanıcı bilgileri yanlış.'
                ], 401);
            }
            $token = $user->createToken('authToken')->plainTextToken;

            if ($user->user_type === 'student') {
                $userInfo = $user->students;
            } elseif ($user->user_type === 'teacher') {
                $userInfo = $user->teacher;
            } else {
                return response()->json(['error' => 'Kullanıcının geçerli bir rolü yok.'], 400);
            }

            return response()->json([
                'access_token' => $token,
                'details' => [
                    'user' => new UserResource($user),
                    'userInfo' => $userInfo,
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function studentRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'user_type' => 'required|string',
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


        $student = new Student([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
        ]);
        $student->save();

        $course_request = new CourseRequests();
        $course_request->user_id = $user->id;
        $course_request->category_id = $request->category_id;
        $course_request->sub_category_id = $request->sub_category_id;
        $course_request->level_id = $request->level_id;
        $course_request->city_id = $request->city_id;
        $course_request->district_id = $request->district_id;
        $course_request->expectations = $request->expectations;
        $course_request->save();

        $course_request->locations()->attach($request->location);

        $token = $user->createToken('authToken')->plainTextToken;

        // Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json([
            'access_token' => $token,
            'details' => [
                'user' => new UserResource($user),
                'userInfo' => $student,
                ]
        ], 200);
    }

    public function teacherRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'required|string',
            'user_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        $teacher = new Teacher([
            'user_id' => $user->id,
            'phone' => $request->phone
        ]);
        $teacher->save();

        $token = $user->createToken('authToken')->plainTextToken;

        // Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json([
            'access_token' => $token,
            'details' => [
                'user' => new UserResource($user),
                'userInfo' => $teacher,
                ]
        ], 200);
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

    public function updateImage(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

           if ($request->avatar) {
            if ($avatar = $this->upload()) {
                if (request()->hasFile('avatar')) {
                    if ($user->avatar) {
                        File::delete($user->avatar);
                    }
                }
                $user->avatar = $avatar;
            }
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar güncellendi.',
            'details' => [
                'user' =>  $user
            ]
        ]);
    }

    public function getUserDetails(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user->user_type === 'student') {
              $userInfo = $user->students;
        } elseif ($user->user_type === 'teacher') {
              $userInfo = $user->teacher;
        } else {
            return response()->json(['error' => 'Kullanıcının geçerli bir rolü yok.'], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar güncellendi.',
            'details' => [
                'user' =>  $user,
                'userInfo' => $userInfo
            ]
        ]);
    }

    public function updateStudentInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'phone' => 'required|string',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
        ]);

        $user = Auth::guard('sanctum')->user();

        $validator->sometimes('email', 'required|string|email|max:100|unique:users', function ($input) use ($user) {
            return $input->email !== $user->email;
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'error' => 'User with this token is not found or not authenticated!'
            ], 404);
        }

        $student = Student::where('user_id', $user->id)->first();

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        if ($student) {
            $student->update([
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
            ]);
        } else {
            $student = new Student([
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
            ]);
            $user->students()->save($student);
        }

        $student = Student::where('user_id', $user->id)->first();

        return response()->json([
            'details' => [
                'user' => new UserResource($user),
                'userInfo' =>  $student
            ]
        ], 200);
    }

    public function updateTeacherInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'phone' => 'required|string',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'birth_date' => 'required|string',
        ]);

        $user = Auth::guard('sanctum')->user();

        $validator->sometimes('email', 'required|string|email|max:100|unique:users', function ($input) use ($user) {
            return $input->email !== $user->email;
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'error' => 'User with this token is not found or not authenticated!'
            ], 404);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        $teacher = Teacher::where('user_id', $user->id)->first();

        $teacher->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        if ($teacher) {
            $teacher->update([
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'birth_date' => $request->birth_date
            ]);
        } else {
            $teacher = new Teacher([
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'birth_date' => $request->birth_date
            ]);
            $user->teacher()->save($teacher);
        }

        $teacher = Teacher::where('user_id', $user->id)->first();

        return response()->json([
            'details' => [
                'user' => new UserResource($user),
                'userInfo' =>  $teacher
            ]
        ], 200);
    }

    public function updateTeacherIntroduceInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'university_id' => 'required|integer',
            'department_id' => 'required|integer',
            'education_status' => 'required|string',
            'experience_year' => 'required|string',
            'about' => 'required|string',
            'experience' => 'required|string',
        ]);

        $user = Auth::guard('sanctum')->user();

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'error' => 'User with this token is not found or not authenticated!'
            ], 404);
        }

        $teacher = Teacher::where('user_id', $user->id)->first();

        if ($teacher) {
            $teacher->update([
                'university_id' => $request->university_id,
                'department_id' => $request->department_id,
                'education_status' => $request->education_status,
                'experience_year' => $request->experience_year,
                'about' => $request->about,
                'experience' => $request->experience
            ]);
        } else {
            $teacher = new Teacher([
                'university_id' => $request->university_id,
                'department_id' => $request->department_id,
                'education_status' => $request->education_status,
                'experience_year' => $request->experience_year,
                'about' => $request->about,
                'experience' => $request->experience
            ]);
            $user->teacher()->save($teacher);
        }

        $teacher = Teacher::where('user_id', $user->id)->first();

        return response()->json([
            'details' => [
                'user' => new UserResource($user),
                'userInfo' =>  $teacher
            ]
        ], 200);
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
