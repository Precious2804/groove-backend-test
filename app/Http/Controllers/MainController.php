<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectTokenResource;
use App\Http\Resources\TokenInvestmentResource;
use App\Models\Project;
use App\Models\ProjectToken;
use App\Models\TokenInvestment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    use ApiResponse;

    //fetch all projects
    public function allProjects()
    {
        $projects = Project::orderBy('created_at', 'DESC')->get();
        $projectResource = ProjectResource::collection($projects);
        return ApiResponse::successResponseWithData($projectResource, "All Projects retrieved", Response::HTTP_OK);
    }

    public function singleProject(Project $project)
    {
        $projectResource = new ProjectResource($project);
        return ApiResponse::successResponseWithData($projectResource, "Single Project retrieved", Response::HTTP_OK);
    }

    //fetch all tokens
    public function allTokens()
    {
        $tokens = ProjectToken::all();
        $tokenResource = ProjectTokenResource::collection($tokens);
        return ApiResponse::successResponseWithData($tokenResource, "All Tokens", Response::HTTP_OK);
    }

    //fetch single token
    public function getSingleToken(ProjectToken $token)
    {
        $tokenResource = new ProjectTokenResource($token);
        return ApiResponse::successResponseWithData($tokenResource, "Single Token retrieved", Response::HTTP_OK);
    }

    //fetch transactions on a token
    public function transOnToken(ProjectToken $token)
    {
        $transactions = TokenInvestment::where('token_code', $token['token_code'])->get();
        $transResource = TokenInvestmentResource::collection($transactions);
        return ApiResponse::successResponseWithData($transResource, "All Transaction for token " . $token['token_code'] . " retrieved", Response::HTTP_OK);
    }
}
