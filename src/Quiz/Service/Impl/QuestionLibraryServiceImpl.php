<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 3018/7/18
 * Time: 下午4:27
 */

namespace Biz\Quiz\Service\Impl;

use Codeages\Biz\Framework\Service\BaseService;
use Biz\Quiz\Service\QuestionLibraryService;
use Wqedu\Common\ArrayToolkit;

class QuestionLibraryServiceImpl extends BaseService implements QuestionLibraryService
{
    protected $source = array('standard', 'teacher');

    protected $status = array('draft', 'published', 'closed');

    public function getLibrary($id)
    {
        return $this->getQuestionLibraryDao()->get($id);
    }

    public function createLibrary($library)
    {
        if (!ArrayToolkit::requireds($library, array('name')))
            throw new \Exception('Missing Necessary Fields', 20401);

        $library                = $this->_filterLibraryFields($library, 'create');
        $library                = $this->getQuestionLibraryDao()->create($library);

        //todo, log

        return $library;
    }

    public function updateLibrary($id, $fields)
    {
        $library   = $this->getQuestionLibraryDao()->get($id);
        if(empty($library))
            throw new \Exception('Library Resource Not Found', 20404);

        $fields = $this->_filterLibraryFields($fields);
        $fields        = $fields;
        $library = $this->getQuestionLibraryDao()->update($id, $fields);

        //todo,log

        return $library;
    }

    /*
     * 做逻辑删除
     * status->closed
     */
    public function deleteLibrary($id)
    {
        $library   = $this->getQuestionLibraryDao()->get($id);
        if(empty($library))
            throw new \Exception('Library Resource Not Found', 20404);

        //todo,log

        return $this->getQuestionLibraryDao()->closeLibrary($id);
    }

    public function searchLibraryCount($conditions)
    {
        $conditions = $this->_prepareLibraryConditions($conditions);

        return $this->getQuestionLibraryDao()->count($conditions);

    }

    public function searchLibrarys($conditions, $sort, $start, $limit)
    {
        $conditions = $this->_prepareLibraryConditions($conditions);

        $orderBy = $this->_prepareLibraryOrderBy($sort);

        return $this->getQuestionLibraryDao()->search($conditions, $orderBy, $start, $limit);
    }

    /*
     * library
     */

    protected function _filterLibraryFields($fields, $mode = 'update')
    {
        $fields = ArrayToolkit::filter($fields, array(
            'name'             =>  '',
            'description'      =>  '',
            'questionNum'       =>  0,
            'testpaperNum'      =>  0,
            'source'            =>  'standard',
            'clientId'          =>  0,
            'status'            =>  'published',
        ));

        if( isset($fields['source']) && !in_array($fields['source'], $this->source) )
            throw new \Exception('Invalid Source Value', 20404);

        if( isset($fields['status']) && !in_array($fields['status'], $this->status) )
            throw new \Exception('Invalid Status Value', 20404);

        $fields['updatedTime'] = time();

        if($mode=='create')
        {
            $fields['createdTime'] = time();
        }

        return $fields;
    }

    protected function _prepareLibraryConditions($conditions)
    {
        $conditions = array_filter(
            $conditions,
            function ($value) {
                if (0 == $value) {
                    return true;
                }

                return !empty($value);
            }
        );

        return $conditions;
    }

    protected function _prepareLibraryOrderBy($sort)
    {
        if (is_array($sort)) {
            $orderBy = $sort;
        } elseif ('createdTimeByAsc' == $sort) {
            $orderBy = array('createdTime' => 'ASC');
        } else {
            $orderBy = array('createdTime' => 'DESC');
        }

        return $orderBy;
    }

    /**
     * @return LibraryDao
     */
    protected function getQuestionLibraryDao()
    {
        return $this->biz->dao('Quiz:QuestionLibraryDao');
    }
}