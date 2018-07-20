<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/5/29
 * Time: 下午12:04
 */

namespace Tests;

class QuestionLibraryServiceTest extends IntegrationTestCase
{
    public function testCreateLibrary()
    {
        $mockLibrary = $this->mockLibrary();
        $createLibrary = $this->getQuestionLibraryService()->createLibrary($mockLibrary);
        print_r($createLibrary);

        $this->assertEquals($mockLibrary['name'], $createLibrary['name']);
        $this->assertEquals($mockLibrary['description'], $createLibrary['description']);
        $this->assertEquals($mockLibrary['questionNum'], $createLibrary['questionNum']);
        $this->assertEquals($mockLibrary['testpaperNum'], $createLibrary['testpaperNum']);
        $this->assertEquals($mockLibrary['source'], $createLibrary['source']);
        $this->assertEquals($mockLibrary['clientId'], $createLibrary['clientId']);
        $this->assertEquals($mockLibrary['status'], $createLibrary['status']);

        fwrite(STDOUT, __METHOD__ . "\n =======createLibrary======= \n");
    }

    public function testGetLibrary()
    {
        $mockLibrary = $this->mockLibrary();
        $createLibrary = $this->getQuestionLibraryService()->createLibrary($mockLibrary);

        $getLibrary = $this->getQuestionLibraryService()->getLibrary($createLibrary['id']);
        print_r($getLibrary);

        $this->assertEquals($mockLibrary['name'], $getLibrary['name']);
        $this->assertEquals($mockLibrary['description'], $getLibrary['description']);
        $this->assertEquals($mockLibrary['questionNum'], $getLibrary['questionNum']);
        $this->assertEquals($mockLibrary['testpaperNum'], $getLibrary['testpaperNum']);
        $this->assertEquals($mockLibrary['source'], $getLibrary['source']);
        $this->assertEquals($mockLibrary['clientId'], $getLibrary['clientId']);
        $this->assertEquals($mockLibrary['status'], $getLibrary['status']);

        fwrite(STDOUT, __METHOD__ . "\n =======getLibrary======= \n");
    }

    public function testUpdateLibrary()
    {
        $mockLibrary = $this->mockLibrary();
        $mockUpdateLibrary = $this->mockUpdateLibrary();

        $createLibrary = $this->getQuestionLibraryService()->createLibrary($mockLibrary);

        $getLibrary = $this->getQuestionLibraryService()->getLibrary($createLibrary['id']);

        $updateLibrary = $this->getQuestionLibraryService()->updateLibrary($createLibrary['id'], $mockUpdateLibrary);
        print_r($updateLibrary);

        $this->assertEquals($mockLibrary['name'], $getLibrary['name']);
        $this->assertEquals($mockLibrary['description'], $getLibrary['description']);
        $this->assertEquals($mockLibrary['questionNum'], $getLibrary['questionNum']);
        $this->assertEquals($mockLibrary['testpaperNum'], $getLibrary['testpaperNum']);
        $this->assertEquals($mockLibrary['source'], $getLibrary['source']);
        $this->assertEquals($mockLibrary['clientId'], $getLibrary['clientId']);
        $this->assertEquals($mockLibrary['status'], $getLibrary['status']);

        fwrite(STDOUT, __METHOD__ . "\n =======updateLibrary======= \n");
    }

    public function testDeleteLibrary()
    {
        $mockLibrary = $this->mockLibrary();
        $createLibrary = $this->getQuestionLibraryService()->createLibrary($mockLibrary);

        $deleteLibrary = $this->getQuestionLibraryService()->deleteLibrary($createLibrary['id']);
        print_r($deleteLibrary);

        $this->assertEquals('closed', $deleteLibrary['status']);

        fwrite(STDOUT, __METHOD__ . "\n =======deleteLibrary======= \n");
    }

    public function testSearchLibraryCount()
    {
        $mockLibrary = $this->mockLibrary();
        $mockUpdateLibrary = $this->mockUpdateLibrary();

        $createLibrary = $this->getQuestionLibraryService()->createLibrary($mockLibrary);
        $updateLibrary = $this->getQuestionLibraryService()->createLibrary($mockUpdateLibrary);

        $conditions['nameLike'] = '题库';

        $count = $this->getQuestionLibraryService()->searchLibraryCount($conditions);

        $librarys = $this->getQuestionLibraryService()->searchLibrarys($conditions,false,0,10);

        print_r($librarys);

        $this->assertEquals(2, $count);

        fwrite(STDOUT, __METHOD__ . "\n =======searchLibraryCount======= \n");
    }

    protected function mockLibrary()
    {
        return array(
            'name'             =>  '测试的题库',
            'description'      =>  '简介',
            'questionNum'       =>  10,
            'testpaperNum'      =>  20,
            'source'            =>  'standard',
            'clientId'          =>  110,
            'status'            =>  'published',
        );
    }

    protected function mockUpdateLibrary()
    {
        return array(
            'name'             =>  '测试的题库1',
            'description'      =>  '简介1',
            'questionNum'       =>  101,
            'testpaperNum'      =>  201,
            'source'            =>  'teacher',
            'clientId'          =>  1101,
            'status'            =>  'draft',
        );
    }


    protected function getQuestionLibraryService()
    {
        return $this->biz->service('Quiz:QuestionLibraryService');
    }
}