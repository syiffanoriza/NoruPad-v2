<?php

namespace App\Http\Middleware;

use App\Models\Notes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isNoteOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::User();
        $note = Notes::findOrFail($request->id);

        if ($note->owner != $currentUser->id) {
            return response()->json(['message' => 'data not found'], 404);
        }

        return $next($request);
    }
}
