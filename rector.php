<?php

declare(strict_types=1);

use Rector\Config\Level\CodeQualityLevel;
use Rector\Config\Level\DeadCodeLevel;
use Rector\Config\Level\TypeDeclarationLevel;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/resources',
        __DIR__.'/tests',
    ])
    ->withPhpSets()
    ->withTypeCoverageLevel(count(TypeDeclarationLevel::RULES))
    ->withDeadCodeLevel(count(DeadCodeLevel::RULES))
    ->withCodeQualityLevel(count(CodeQualityLevel::RULES))
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
    ])
    ->withSkip([
        ClosureToArrowFunctionRector::class,
        RemoveUnusedPromotedPropertyRector::class,
        RemoveUnusedPrivateMethodParameterRector::class,
        RemoveUnusedPublicMethodParameterRector::class,
        RemoveUnusedPrivateMethodRector::class,
        RemoveUnreachableStatementRector::class,
        RemoveUnusedVariableAssignRector::class,
        RemoveUnusedConstructorParamRector::class,
        RemoveEmptyClassMethodRector::class,
        RemoveDeadReturnRector::class,
        StringToClassConstantRector::class,
    ]);
