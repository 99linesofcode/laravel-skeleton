<?php

declare(strict_types=1);

namespace App\Api\Types;

use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'User',
        'description' => 'A user',
        'model'       => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'email' => [
                'type'        => Type::string(),
                'description' => 'The email of user',
            ],
        ];
    }

    protected function resolveEmailField($root, array $args)
    {
        return strtolower($root->email);
    }
}
