<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();
        $categories = Category::all();
        return view('confirm', compact('contact', 'categories'));
    }

    public function store(Request $request)
    {
        $tel = $request->input('tel1') . $request->input('tel2') . $request->input('tel3');

        Contact::create([
            'category_id' => $request->input('category_id'),
            'first_name'  => $request->input('first_name'),
            'last_name'   => $request->input('last_name'),
            'gender'      => $request->input('gender'),
            'email'       => $request->input('email'),
            'tel'         => $tel,
            'address'     => $request->input('address'),
            'building'    => $request->input('building'),
            'detail'      => $request->input('detail'),
    ]);

        return redirect('/thanks');
    }

    public function thanks()
    {
        return view('thanks');
    }
}
