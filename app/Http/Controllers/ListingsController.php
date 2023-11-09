<?php

namespace App\Http\Controllers;
use App\Models\Listing;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingsController extends Controller
{
    public function index() {

        $data = array(
            'heading' => 'Latest Gigs',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        );
        return view('listings.index')->with($data);
    }

    public function show($id) {

        $listing = Listing::find($id);
         
        if($listing) {
            return view('listings.show')->with('listing', $listing);
        }
    }

    public function create() {

        return view('listings.create');
    }

    public function store(Request $request) {

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        Listing::create($formFields);
        return redirect('/');

    }

}
