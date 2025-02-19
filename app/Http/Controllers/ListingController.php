<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Clockwork\Request\RequestType;

class ListingController extends Controller
{
	// Show all listings
	public function index(){
		return view('listings.index', [
			'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(7)
		]);
	}

	// Show single listing
	public function show(Listing $listing){
		return view('listings.show', [
			'listing' => $listing
		]);
	}

	// Show Create Form
	public function create(){
		return view('listings.create');
	}

	// Store a new listing
	public function store(Request $request){
		$formFields = $request->validate([
			'title' => 'required',
			'company' => ['required', Rule::unique('listings', 'company')],
			'location' => 'required',
			'website' => 'required',
			'email' => ['required', 'email'],
			'tags' => 'required',
			'description' => 'required'
		]);

		if($request->hasFile('logo')){
			$formFields['logo'] = $request->file('logo')->store('logos', 'public');
		}

		Listing::create($formFields);

		return redirect('/')->with('message', 'Listing created successfully!');
	}

	// Show Edit Form
	public function edit(Listing $listing){
		return view('listings.edit', [
			'listing' => $listing
		]);
	}

	// Edit Listing Form
	public function update(Request $request, $id)
	{
		// Validate the incoming request data
		$validatedData = $request->validate([
			'title' => 'required|string|max:255',
			'company' => ['required', Rule::unique('listings', 'company')],
			'location' => 'required',
			'website' => 'required',
			'email' => ['required', 'email'],
			'tags' => 'required',
			'description' => 'required|string',
		]);

		// Find the listing by ID
		$listing = Listing::findOrFail($id);

		// Update the listing with validated data
		$listing->update($validatedData);

		// Redirect or return a response as needed
		return redirect()->route('listings.show', $listing->id)
						 ->with('success', 'Listing updated successfully.');
	}
}

