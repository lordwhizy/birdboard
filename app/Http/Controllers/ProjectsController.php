<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{

    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $attributes = request()->validate(['title' => 'required', 'description' => 'required', 'notes' => 'min:3']);

        $project = auth()->user()->projects()->create($attributes);


        return redirect($project->path());
    }

    public function show(Project $project)
    { 
        // if (auth()->user()->isNot($project->owner)) {
        //     abort(403);
        // }
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Project $project)
    {
        // if (auth()->user()->isNot($project->owner)) {
        //     abort(403);
        // }
        $this->authorize('update', $project);

        $project->update(request(['notes']));

        return redirect($project->path());
    }

}
