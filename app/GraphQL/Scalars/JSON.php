<?php
/**
 * Class JSON scalar
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Scalars
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\GraphQL\Scalars;

use GraphQL\Language\AST\BooleanValueNode;
use GraphQL\Language\AST\FloatValueNode;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\ListValueNode;
use GraphQL\Language\AST\ObjectValueNode;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

/**
 * Json scalar for graphql datatypes
 *
 * PHP version 8.1
 *
 * @category GraphQL
 * @package  App\GraphQL\Scalars
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
class JSON extends ScalarType
{
    public $description = "The `JSON` scalar type represents JSON values as specified by
        [ECMA-404](http://www.ecma-international.org/publications/files/ECMA-ST/ECMA-404.pdf).";

    /**
     * Serializes an internal value to include in a response.
     *
     * @param mixed $value use for serialize value
     *
     * @return mixed
     */
    public function serialize($value)
    {
        // Assuming the internal representation of the value is always correct
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value use for parse value
     *
     * @return mixed
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided literal value
     * (hardcoded in GraphQL query) to use as an input.
     *
     * E.g.
     * {
     *   user(email: "user@example.com")
     * }
     *
     * @param \GraphQL\Language\AST\Node $valueNode default argument
     * @param mixed[]|null               $variables optional variable
     *
     * @return mixed
     * @SuppressWarnings("unused")
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        switch ($valueNode) {
            case ($valueNode instanceof StringValueNode):
            case ($valueNode instanceof BooleanValueNode):
                return $valueNode->value;
            case ($valueNode instanceof IntValueNode):
            case ($valueNode instanceof FloatValueNode):
                return floatval($valueNode->value);
            case ($valueNode instanceof ObjectValueNode):
                $value = [];
                foreach ($valueNode->fields as $field) {
                    $value[$field->name->value] = $this->parseLiteral($field->value);
                }
                return $value;
            case ($valueNode instanceof ListValueNode):
                return array_map([$this, 'parseLiteral'], $valueNode->values);
            default:
                return null;
        }
    }
}
