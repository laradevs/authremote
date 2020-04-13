<?php


namespace LaraDevs\AuthRemote;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Socialite\Facades\Socialite;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function logout(){
        session()->forget(config('rest-provider.name_session_rest'));
        return redirect()->route(config('rest-provider.route_not_session'));
    }

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->user();
        return $this->authAndRedirect($social_user); // Login y redirección
    }

    /**
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authAndRedirect($user)
    {
        $userSession=new User((array)$user);
        session()->put(config('rest-provider.name_session_rest'),$userSession->token);
        Auth::login($userSession);
        return redirect()->to('/home');
    }
}
