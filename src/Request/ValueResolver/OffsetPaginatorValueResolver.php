<?php

declare(strict_types=1);

namespace PaginatorBundle\Request\ValueResolver;

use ExceptionHandlerBundle\Exception\ValidationException;
use PaginatorBundle\Paginator\OffsetPaginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OffsetPaginatorValueResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly int $limit,
        private readonly ?ValidatorInterface $validator = null
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if (!is_subclass_of($argumentType, OffsetPaginator::class) && !($argumentType === OffsetPaginator::class)) {
            return [];
        }

        $limit = $request->query->getInt('limit', $this->limit);
        $offset = $request->query->getInt('offset', 0);

        $object = new $argumentType($offset, $limit);
        if ($this->validator) {
            $errors = $this->validator->validate($object);

            if ($errors->count()) {
                throw new ValidationException(iterator_to_array($errors->getIterator()));
            }
        }

        return [$object];
    }
}
