<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/7/18
 * Time: 下午4:24
 */
namespace Biz\Quiz\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface QuestionLibraryDao extends GeneralDaoInterface
{
    public function closeLibrary($id);
}
