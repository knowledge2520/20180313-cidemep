<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\MessageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMessageDecorator extends BaseCacheDecorator implements MessageRepository
{
    public function __construct(MessageRepository $message)
    {
        parent::__construct();
        $this->entityName = 'pemedic__message';
        $this->repository = $message;
    }
}
