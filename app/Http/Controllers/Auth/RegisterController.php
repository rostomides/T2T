<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Payment;
use App\Monitoring;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

// Add these to overide the function
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;





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
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function redirectTo(){        
        if(Auth::user()->role_id == 3){
            if(Auth::user()->status_id == 1){ //Just refistered
                return route('create_profile');
            }
            else if(Auth::user()->status_id == 2 || Auth::user()->status_id == 3){
                return route('my_profile');
            }else if(Auth::user()->status_id == 4){
                return route('expired_account');
            }
            else if(Auth::user()->status_id == 5){
                return route('banned_account');
            } 

        }else{
            return route('dashboard');
        }
    }




    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();


        // Stripe validation here
        try{
            $charge= \Stripe::charges()->create([
                'amount'=> 84,
                'currency'=>'CAD',
                'source'=> $request->stripeToken,
                'description'=>"Billing for ". $request['name'],
                'receipt_email'=> $request->email,
            ]);

        }catch(Exception $e){
            return redirect()->back()->with('error', "Your payment could not be processed, please review your credit card information");
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect()->route('create_profile'); //redirect($this->redirectPath());
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

        $user = new User;
        $user->name = $data['name'];
        $user->email= $data['email'];
        $user->password= Hash::make($data['password']);
        $user->role_id= 3; //Correspond to customer
        $user->status_id= 1;// Corresponds to the status of registerd
        $user->save();

        // Record the date of payment and expiration
        $expiration_date = date('Y-m-d', strtotime(date('Y-m-d')) + (366*24*3600));
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->payment_date = date('Y-m-d'); //format accepted by sql
        $payment->expiration_date = $expiration_date;
        $payment->save();

        return $user;

    }

    // ---------------------
    // Create an admin
    // ---------------------
    protected function validator_admin(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
        ]);
    }


    // --------------------------------
    // Register an admin aftervalidation
    // --------------------------------
    public function register_admin(Request $request)
    {
        // dd($request->toArray());
        
        $this->validator_admin($request->all())->validate();

        event(new Registered($user = $this->create_admin($request->all())));
        

        return $this->registered($request, $user)
                        ?: redirect()->route('manage_admin'); //redirect($this->redirectPath());
    }

    // --------------------------------
    // Create an admin account
    // --------------------------------
    protected function create_admin(array $data)
    {    

        $user = new User;
        $user->name = $data['name'];
        $user->email= $data['email'];
        $user->password= Hash::make($data['password']);
        $user->role_id= $data['role']; //correspond to customer
        $user->status_id= 10; // 10 for active 11 for non active
        $user->save();

        return $user;

    }

    // --------------------------------
    // Delete user
    // --------------------------------
    public function delete_user($id){        
        // Make sure that we have at least one super user
        if(auth()->user()->id == $id){
            return redirect()->route('manage_admin')->with('error', 'Operation not allowed');
        }

        $user = User::find($id);
        $user->delete();

        // Record it in the log 

        // $monitor = new Monitoring;
        // $monitor->admin_id = auth()->user()->id;
        // $monitor->admin_action_id = 5;
        // $monitor->user_id = $user->id;


        // $table->integer('admin_id')->unsigned();
        //     $table->integer('admin_action_id')->unsigned();
        //     $table->integer('user_id')->unsigned();


        return redirect()->route('manage_admin');
    }

}
