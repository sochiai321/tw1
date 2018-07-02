<?php

namespace App\Http\Controllers\Auth;

use App\User;
use DB;
use Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/twitter';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::firstOrNew([
                'email' => $data['email']
            ]);
            $user->password = bcrypt($data['password']);
            $user->name = $data['name'];

            // $referralCode = $this->getReferralCode($data);
            // if ($referralCode) {
            //     $user->referral_id = User::where('referral_code', $referralCode)->value('id');
            // }

            $user->referral_code = $this->generateUniqueReferrerCode(6);
            $user->save();

            
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            Log::error("Error creating new user: " . $e->getMessage());
            DB::rollback();
            throw $e;
        }
    }
    private function generateUniqueReferrerCode($length = 6) {
        $str = str_random($length);
        return (User::where('referral_code', $str)->exists()) ? $this->generateUniqueReferrerCode($length) : $str;

    }


}
