<?php

namespace Org\Jvhsa\Surgiscript\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Org\Jvhsa\Surgiscript\Http\Requests\SiteApprovalRequest;
use Org\Jvhsa\Surgiscript\Http\Requests\SiteRegistrationRequest;
use Org\Jvhsa\Surgiscript\Site;
use Org\Jvhsa\Surgiscript\SiteRegistration;
use Zizaco\Entrust\Entrust;

class SiteRegistrationController extends Controller
{
	public function index()
	{
        // TODO: implement role check here
        $admin_role = auth()->user()->hasRole('admin');

        // dd($admin_role);

        if($admin_role)
        {
            $registrations = SiteRegistration::latest()->get();
        }
        else
        {
		    $registrations = auth()->user()->signups()->latest()->get();
        }

		return view('site.registration.index', compact('registrations'));
	}
	/**
	 * Display sign up page where user can request
	 * a new site
	 * @return Illuminate\Contracts\View\View
	 */
    public function create()
    {
    	return view('site.registration.create');
    }

    /**
     * Save SiteRegistration
     * @param  SiteRegistrationRequest
     * @param  Illuminate\Support\Facades\Request
     * @return Illuminate\Support\Facades\Redirect 
     */
    public function store(SiteRegistrationRequest $registration)
    {
    	// when the request is validated
    	$site = new SiteRegistration($registration->all());
    	$site->registration_id = str_random(8);

    	$owner = auth()->user();
    	//TODO: catch exception while trying to save the object
    	$owner->signups()->save($site);

    	// when save is completed
    	return redirect()->route('signup.index');
    }

    /**
     * Display details of a site registration
     * @param  SiteRegistration $registration
     * @return Illuminate\Support\Facades\View
     */
    public function show(SiteRegistration $registration)
    {
    	return view('site.registration.show', compact('registration'));
    }

    // TODO: move this to admin controller
    // TODO: ensure only admin can get here
    /**
     * Displays form to approve and create the site
     * @param  SiteRegistration $registration [description]
     * @return [type]                         [description]
     */
    public function approval(SiteRegistration $registration)
    {
        return view('site.registration.approval', compact('registration'));
    }

    // TODO: move this to admin controller
    // TODO: ensure only admin can get here
    /**
     * Approve site registration request
     * @param  SiteApprovalRequest $request      [description]
     * @param  SiteRegistration    $registration [description]
     * @return [type]                            [description]
     */
    public function approve(SiteApprovalRequest $request, SiteRegistration $registration)
    {
        $site = new Site([
            'name' => $registration->name,
            'address' => $registration->address,
            'slug' => $request->slug,
            'registration_id' => $registration->registration_id
        ]);

        // update registration
        $registration->approval = 'approved';
        $registration->approver_id = auth()->user()->id;
        $registration->update();

        // extract registration owner
        $owner = $registration->owner;

        // store new site
        $owner->sites()->save($site);

        // redirect to the registrations
        return redirect()->route('signup.index');
    }

    public function reject(SiteRegistration $registration)
    {
        $registration->approval = 'rejected';
        $registration->approver_id = auth()->user()->id;
        $registration->update();

        return redirect()->route('signup.approval', $registration);
    }

}
