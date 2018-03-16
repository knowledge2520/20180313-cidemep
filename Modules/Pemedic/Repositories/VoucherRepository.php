<?php

namespace Modules\Pemedic\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface VoucherRepository extends BaseRepository
{
	/**
     * Author: Dung Vo
     * [pushCriteria filter repository]
     * @param  boolean $user [user]
     * @return [object]      [model]
     */
    public function pushCriteria($user = false);

    /**
	 * Author: Dung Vo
	 * [getList get list voucher]
	 * @param  string  $option [list: return list voucher using pagination; count: return number of list voucher]
	 * @param  [type]  $user   [object user]
	 * @param  boolean $page   [position page]
	 * @param  boolean $limit  [limit of pagination]
	 * @return [mixed]          [list: array, count: intteger]
	 */
	public function getList($option = "list", $user, $page = false, $limit = false);

	/**
	 * Author: Dung Vo
	 * [getAll get all voucher of user]
	 * @param  [type] $user [user]
	 * @return [array]      [list items voucher]
	 */
	public function getAll($user);
}
