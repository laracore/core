<?php
namespace Laracore\Core\App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use JWTAuth;

class UpdateFilesMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateModelMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return Type::nonNull(GraphQL::Type('UpdateFiles'));
    }

    public function args()
    {
        return [
            'package' => ['name' => 'package', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        /**
         * [$args 解析 itemValue json 为数组对象]
         * @var [type]
         */
        $args['value'] = json_decode($args['value']);
        return app()->call(UpdateModelAction::class, [$args], 'run');
    }

    public function authenticated($root, $args, $context)
    {
        return JWTAuth::parseToken()->authenticate() ? true : false;
    }
}
