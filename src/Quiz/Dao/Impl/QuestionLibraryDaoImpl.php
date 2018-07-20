<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/5/28
 * Time: 下午4:27
 */

namespace Biz\Quiz\Dao\Impl;

use Biz\Quiz\Dao\QuestionLibraryDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class QuestionLibraryDaoImpl extends GeneralDaoImpl implements QuestionLibraryDao
{
    protected $table = 'question_library';

    public function declares()
    {
        return array(
            'serializes' => array(
            ),
            'orderbys' => array(
                'createdTime',
                'updatedTime',
                'id',
            ),
            'timestamps' => array('createdTime', 'updatedTime'),
            'conditions' => array(
                'id = :id',
                'updatedTime >= :updatedTime_GE',
                'status = :status',
                'name LIKE :nameLike',
                'createdTime >= :startTime',
                'createdTime < :endTime',
                'id NOT IN ( :excludeIds )',
                'id IN ( :Ids )',
            ),
            'wave_cahceable_fields' => array(),
        );
    }

    public function closeLibrary($id)
    {
        return $this->updateById($id, array( 'status'=>'closed','updatedTime'=>time() ));
    }
}