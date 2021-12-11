<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Spatie\Permission\Models\Role;

class AuthMutator
{
    public function loginCheck($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = Arr::only($args, ['email', 'password']);

        if (Auth::once($credentials)) {
            $user = auth()->user();
            return [
                'token' => Auth::user()->createToken('device_name')->plainTextToken,
                'permission' => $user->getAllPermissions(),
                'user' => auth()->user(),
                'user_role' => Role::findById($user->user_role)
            ];
        }

        throw new AuthenticationException('Authentication Failed');
    }
}
