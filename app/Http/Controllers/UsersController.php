<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\CreateUser;
use JobApis\JobsToMail\Jobs\ConfirmUser;
use JobApis\JobsToMail\Jobs\CreateUserAndSearch;
use JobApis\JobsToMail\Jobs\DeleteUser;

class UsersController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Home page and signup form
     */
    public function index()
    {
        return view('users.welcome');
    }

    /**
     * Create new User.
     */
    public function create(CreateUser $request)
    {
        $data = $request->only(array_keys($request->rules()));

        $message = $this->dispatchNow(new CreateUserAndSearch($data));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * Confirm user account
     */
    public function confirm(Request $request, $token)
    {
        $message = $this->dispatchNow(new ConfirmUser($token));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * Unsubscribe user account
     */
    public function unsubscribe(Request $request, $userId)
    {
        $message = $this->dispatchNow(new DeleteUser($userId));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * View searches for this user
     */
    public function searches(Request $request, $userId)
    {
        dd($userId);
    }
}
