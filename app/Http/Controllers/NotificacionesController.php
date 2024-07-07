<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        //return "desde notificaciones";

        $notificaciones = auth()->user()->unreadNotifications;
        //dd($notificaciones);

        auth()->user()->unreadNotifications->markAsread();

        return view('notificaciones.index', compact('notificaciones'));
    }
}
