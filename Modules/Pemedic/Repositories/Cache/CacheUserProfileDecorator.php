<?php

namespace Modules\Pemedic\Repositories\Cache;

use Modules\Pemedic\Repositories\UserProfileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserProfileDecorator extends BaseCacheDecorator implements UserProfileRepository
{
    public function __construct(UserProfileRepository $userProfile)
    {
        parent::__construct();
        $this->entityName = 'pemedic__user_profiles';
        $this->repository = $userProfile;
    }
}
