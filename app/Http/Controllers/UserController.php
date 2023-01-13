<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyTokenRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\TokenInvestmentResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\ProjectToken;
use App\Models\TokenInvestment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ApiResponse;
    //get User Profile
    public function getProfile()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $userResource = new UserResource($user);
        return ApiResponse::successResponseWithData($userResource, "User Profile retrieved", Response::HTTP_OK);
    }

    //change user password
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = User::where('id', auth()->user()->id)->first();

        $user->update([
            'password' => Hash::make($data['password'])
        ]);
        $userResource = new UserResource($user);
        return ApiResponse::successResponseWithData($userResource, "Password updated successfully", Response::HTTP_OK);
    }

    //update user profile
    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $user = User::where('id', auth()->user()->id)->first();
        $user->update($data);
        $userResource = new UserResource($user);
        return ApiResponse::successResponseWithData($userResource, "Profile updated successfully", Response::HTTP_OK);
    }

    //purchase a token
    public function buyToken(Project $project, BuyTokenRequest $request)
    {
        $data = $request->validated();
        //NB: the payment process was not implemented on this test application in other to keep the project simple for now
        //after payment has been confirmed by any payment process used the we can proceed with assigning tokens to users

        $token = ProjectToken::where('project_id', $project['id'])->first();

        //create token investment
        $investment = TokenInvestment::create([
            'user_id' => auth()->user()->id,
            'token_code' => $token['token_code'],
            'token_id' => $token['id'],
            'project_id' => $project['id'],
            'amount_paid' => $data['amount'],
            'total_amount' => $data['amount'],
        ]);

        //update the project status
        $project->update([
            'number_of_sales' => $project['number_of_sales'] + 1,
            'amount' => $project['amount'] + $data['amount']
        ]);
        $investmentResource = new TokenInvestmentResource($investment);
        return ApiResponse::successResponseWithData($investmentResource, "Innvestment for project " . $project['project_name'] . " completed successfully", Response::HTTP_CREATED);
    }

    public function myInvestments()
    {
        $investments = TokenInvestment::where('user_id', auth()->user()->id)->get();
        $investmentResource = TokenInvestmentResource::collection($investments);
        return ApiResponse::successResponseWithData($investmentResource, "All my Investments retrieved", Response::HTTP_OK);
    }

    public function viewInvestment(ProjectToken $token)
    {
        $investment = TokenInvestment::where('token_code', $token['token_code'])->first();

        $investmentResource = new TokenInvestmentResource($investment);
        return ApiResponse::successResponseWithData($investmentResource, "Investment Details retrieved", Response::HTTP_OK);
    }
}
