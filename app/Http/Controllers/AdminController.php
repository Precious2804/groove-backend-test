<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMoreTokenRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectTokenResource;
use App\Http\Resources\TokenInvestmentResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\ProjectToken;
use App\Models\TokenInvestment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    use ApiResponse;

    public function getAllUsers()
    {
        $users = User::orderBy('created_at', 'DESC')->get();
        $userResource = UserResource::collection($users);
        return ApiResponse::successResponseWithData($userResource, "All Users Retrieved", Response::HTTP_OK);
    }

    public function getSingleUser(User $user)
    {
        $userResource = new UserResource($user);
        return ApiResponse::successResponseWithData($userResource, "Single User Retrieved", Response::HTTP_OK);
    }

    public function createProject(CreateProjectRequest $request)
    {
        $data = $request->validated();

        //create a new project
        $project = Project::create($data);

        //create token for the just created project
        ProjectToken::create([
            'project_id' => $project['id'],
            'token_code' => $this->createUniqueRand('project_tokens', 'token_code')
        ]);

        $projectResource = new ProjectResource($project);
        return ApiResponse::successResponseWithData($projectResource, "New Project Created Successfully and Tokens has been generated for the project", Response::HTTP_CREATED);
    }


    public function allInvestments()
    {
        $investments = TokenInvestment::orderBy('created_at', 'DESC')->get();
        $investmentResource = TokenInvestmentResource::collection($investments);
        return ApiResponse::successResponseWithData($investmentResource, "All Investments retrieved", Response::HTTP_OK);
    }

    public function viewInvestment(Request $request)
    {
        $token = ProjectToken::where('token_code', $request->token)->first();
        if (!$token) {
            return ApiResponse::errorResponse("Token does not exists in our Databaase", Response::HTTP_NOT_FOUND);
        }
        $investment = TokenInvestment::where('token_code', $request->token)->first();
        $investmentResource = new TokenInvestmentResource($investment);
        return ApiResponse::successResponseWithData($investmentResource, "Investment Details retrieved", Response::HTTP_OK);
    }

    //a function that created random tokens
    private function createUniqueRand($table, $column)
    {
        $id = rand(10000000, 99999999);
        return DB::table($table)->where($column, $id)->first() ? $this->createUniqueRand($table, $column) :  $id;
    }
}
