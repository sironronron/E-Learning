<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HelpCenter\Contact;

// Mail
use Mail;

class ContactController extends Controller
{
    /**
     * Send inquiry to email and save to database
     * 
     * @return Illuminate\Response\Request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role' => 'required',
            'subject' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required'
        ]);

        Contact::create($request->all());

        $data = [
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'user_message' => $request->body,
        ];

        Mail::send('email.customer_inquiry', $data, function($message) use ($data) {
            $message->from($data['email']);
            $message->to('ronron.ceo@gmail.com');
            $message->subject($data['subject']);
        });

        return response()
            ->json([
                'saved' => true,
                'message' => 'Your inquiry is sent! We will contact you the soonest that we can.'
            ]);

    }
}
