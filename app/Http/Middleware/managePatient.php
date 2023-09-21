<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Patient;
use Illuminate\Contracts\Auth\Guard;

class managePatient
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $patient = Patient::findOrFail($request->segments()[1]);
        if (auth()->user()->role != 'admin') {
            if ($patient->referred_by_id !== $this->auth->getUser()->id) {
                abort(403, 'Unauthorized action.');
            }
        }
        return $next($request);
    }
}
