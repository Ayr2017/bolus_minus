<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organisation\EditOrganisationRequest;
use App\Http\Requests\Organisation\IndexOrganisationRequest;
use App\Http\Requests\Organisation\ShowOrganisationRequest;
use App\Http\Requests\Organisation\StoreOrganisationRequest;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Models\Organisation;
use App\Models\StructuralUnit;
use App\Services\Organisation\OrganisationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrganisationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexOrganisationRequest $request): View
    {
        $organisations = Organisation::orderBy('name')->get();
        $title = "Organisations";

        return view('organisations.index', compact('organisations', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Organisation";
        $organisations = Organisation::orderBy('name')->get();
        $structural_units = StructuralUnit::orderBy('name')->get();

        return view('organisations.create', compact('organisations', 'title', 'structural_units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganisationRequest $request, OrganisationService $organisationService): View|RedirectResponse
    {
        $organisation = $organisationService->storeOrganisation($request->validated());
        if ($organisation) {
            return redirect()->route('organisations.index')->with('success', 'Organisation created successfully.');
        }

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowOrganisationRequest $organisationRequest, Organisation $organisation): View
    {
        $parents = Organisation::all()->except([$organisation->id]);
        $structuralUnits = StructuralUnit::all();
        // $category_activ = CategoryActive::all();
        return view('organisations.show', [
            'organisation' => $organisation,
            'title' => "Edit Organisation",
            'parents' => $parents,
            'structural_units' => $structuralUnits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditOrganisationRequest $request, Organisation  $organisation): View
    {

        $parents = Organisation::all()->except([$organisation->id]);
        $structuralUnits = StructuralUnit::all();
        return view('organisations.edit', [
            'organisation' => $organisation,
            'title' => "Edit Organisation",
            'parents' => $parents,
            'structural_units' => $structuralUnits,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganisationRequest $request, Organisation $organisation, OrganisationService $organisationService): RedirectResponse
    {
        $organisation = $organisationService->updateOrganisation($request->validated(), $organisation);
        if ($organisation) {
            return redirect()->route('organisations.show', ['organisation' => $organisation])->with('message', 'Organisation updated successfully.');
        }

        return redirect()->back()->withErrors(['message' => 'An error occurred while updating the organisation.'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
