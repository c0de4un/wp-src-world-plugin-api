<?php

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// USE
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// SRCWController
SRCWDependenciesResolver::includeOnce( 'includes/controllers/class-srcw-controller.php' );

// GraphQL
SRCWDependenciesResolver::includeOnce( 'vendor/webonyx/graphql-php/src/GraphQL.php' );
SRCWDependenciesResolver::includeOnce( 'vendor/autoload.php' );

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\OutputType;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// CLASS
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

final class SRCWGraphQLController extends SRCWController
{

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTRUCTOR
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function __construct()
    {
        parent::__construct();
    }
    
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                       METHODS.PUBLIC
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * GraphQL index
     * Allows to retrieve map
     * 
     * @method GET
    */
    public function index()
    {
        try {
            // Получение запроса
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
        
            // Содание типа данных "Запрос"
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'hello' => [
                        'type' => Type::string(),
                        'description' => 'Возвращает приветствие',
                        'resolve' => function () {
                            return 'Привет, GraphQL!';
                        }
                    ]
                ]
            ]);
        
            // Создание схемы
            $schema = new Schema([
                'query' => $queryType
            ]);
        
            // Выполнение запроса
            $result = GraphQL::executeQuery($schema, $query)->toArray();
        } catch (\Exception $e) {
            $result = [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ];
        }

        return $result;
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

};

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
