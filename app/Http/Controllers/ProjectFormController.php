<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\FormGround;
use App\Models\FormUav;
use App\Models\FormDataProcessing;
use App\Models\AssetPc;
use Illuminate\Http\Request;

class ProjectFormController extends Controller
{
    // --- FORMULIR PERSIAPAN GROUND ---
    public function ground(Project $project)
    {
        $project->load('personnel'); // Load data personil
        $form = FormGround::firstOrCreate(['project_id' => $project->id]);
        return view('projects.qc.form_ground', compact('project', 'form'));
    }

    public function updateGround(Request $request, Project $project)
    {
        $form = FormGround::where('project_id', $project->id)->first();
        $form->update($request->validate([
            'planned_control_points' => 'nullable|string',
            'point_codes' => 'nullable|string',
            'planned_tie_points' => 'nullable|string',
        ]));
        return back()->with('success', 'Formulir Ground berhasil disimpan!');
    }

    // --- FORMULIR PERSIAPAN UAV ---
    public function uav(Project $project)
    {
        $project->load('personnel');
        $form = FormUav::firstOrCreate(['project_id' => $project->id]);
        return view('projects.qc.form_uav', compact('project', 'form'));
    }

    public function updateUav(Request $request, Project $project)
    {
        $form = FormUav::where('project_id', $project->id)->first();
        $form->update($request->validate([
            'product_specs' => 'nullable|string',
            'planned_takeoffs' => 'nullable|integer',
        ]));
        return back()->with('success', 'Formulir UAV berhasil disimpan!');
    }

    // --- FORMULIR PERSIAPAN OLAH DATA ---
    public function processing(Project $project)
    {
        $project->load(['personnel', 'groundReport']); // Load personil dan data titik ground
        $pcs = AssetPc::all(); // Load data PC
        $form = FormDataProcessing::firstOrCreate(['project_id' => $project->id]);
        return view('projects.qc.form_processing', compact('project', 'form', 'pcs'));
    }

    public function updateProcessing(Request $request, Project $project)
    {
        $form = FormDataProcessing::where('project_id', $project->id)->first();
        $form->update($request->validate([
            'requested_products' => 'nullable|string',
            'product_accuracy' => 'nullable|string',
        ]));
        return back()->with('success', 'Formulir Olah Data berhasil disimpan!');
    }
}
