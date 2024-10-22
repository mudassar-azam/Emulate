<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvitationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $signUpLink = route('buyer.front', ['email' => $email, 'modal' => 'true']);

        Mail::to($email)->send(new InvitationEmail($signUpLink));

        return response()->json(['success' => true, 'message' => 'Mail sent successfully!']);
    }
}
