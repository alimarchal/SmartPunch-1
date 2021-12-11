<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Logout
{
    public function logout($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (auth()->user())
        {
            auth()->user()->tokens()->delete();
            return [
                'status' => '200',
                'message' => 'Your session has been terminated'
            ];
        }

        return [
            'status' => '401',
            'message' => 'Bad request'
        ];
    }
}
