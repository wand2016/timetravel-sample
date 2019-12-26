<?php

namespace App\Http\Controllers;

use App\Utils\TimeTravelerInterface;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @param Request $request
     * @param TimeTravelerInterface $timeTraveler
     * @return View
     */
    public function index(
        Request $request,
        TimeTravelerInterface $timeTraveler
    ): View
    {
        $timeTraveler->travel(Carbon::parse($request->get('timetravel', '')));
        return view('home');
    }

    /**
     * @param Request $request
     * @param TimeTravelerInterface $timeTraveler
     * @return RedirectResponse
     */
    public function post(
        Request $request,
        TimeTravelerInterface $timeTraveler
    ): RedirectResponse
    {
        $timeTraveler->travel(Carbon::parse($request->get('timetravel', '')));
        return redirect()->route('home', ['timetravel' => $request->get('timetravel', '')]);
    }

}
