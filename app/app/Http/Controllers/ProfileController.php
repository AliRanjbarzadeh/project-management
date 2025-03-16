<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function index(Request $request)
	{
		$this->setPageTitle(__('profile.singular'));

		$user = $request->user();
		return view('profile.index', compact('user'));
	}

	public function update(ProfileRequest $request)
	{
		if ($request->user()->update(
			$request->only(['full_name', 'email']),
		)) {
			return redirect(route('profile.index'))->with('success', __('profile.sentences.success'));
		}

		return redirect()->back()->withInput()->withErrors(['message' => __('profile.sentences.error')]);
	}
}
