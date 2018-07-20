<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/7/18
 * Time: 下午4:24
 */
namespace Biz\Quiz\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface QuestionLibraryService
{
    public function getLibrary($id);

    public function createLibrary($library);

    public function updateLibrary($id, $fields);

    public function deleteLibrary($id);

    public function searchLibraryCount($conditions);

    public function searchLibrarys($conditions, $sort, $start, $limit);

}
