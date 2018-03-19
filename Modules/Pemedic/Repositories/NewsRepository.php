<?php

namespace Modules\Pemedic\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface NewsRepository extends BaseRepository
{
	/**
     * Author: Dung Vo
     * [pushCriteria get model of repository, filter condition]
     * @return [object] [model]
     */
    public function pushCriteria();

    /**
	 * Author: Dung Vo
	 * [getList get list items news with pagination or count number items news]
	 * @param  string  $option [list: return list items using pagination; count: return number of list items]
	 * @param  string  $lang   [en, vi]
	 * @param  boolean $page   [position page]
	 * @param  boolean $limit  [limit of pagination]
	 * @return [mixed]         [list: array, count: intteger]
	 */
	public function getList($option = "list", $lang = 'en', $page = false, $limit = false);

	/**
	 * Author: Dung Vo
	 * [getAll get all news]
	 * @return [array]      [list items news]
	 */
	public function getAll();
}
