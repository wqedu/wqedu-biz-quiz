<?php

use Phpmig\Migration\Migration;

class QuestionLibrary extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $biz = $this->getContainer();
        $connection = $biz['db'];
        $connection->exec("
            CREATE TABLE IF NOT EXISTS `question_library` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统ID',
              `name` varchar(256) NOT NULL DEFAULT '' COMMENT '名称',
              `description` text DEFAULT NULL COMMENT '题库描述',
              `questionNum` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '总题数',
              `testpaperNum` int(10) NOT NULL DEFAULT 0 COMMENT '试卷数量',
              `createdTime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
              `updatedTime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
              `source` enum('standard','teacher','school') NOT NULL DEFAULT 'standard' COMMENT '题库来源类别',
              `status` enum('draft','published','closed') NOT NULL DEFAULT 'draft' COMMENT '状态',
              `clientId` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT 'OAuth客户端ID',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='题库表';
        ");

        $connection->exec("
            CREATE TABLE IF NOT EXISTS `question_library_admin` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统ID',
              `userId` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '用户ID',
              `libraryId` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '题库ID',
              `role` enum('admin','teacher') NOT NULL DEFAULT 'admin' COMMENT '用户题库角色',
              `createdTime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
              `updatedTime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
              `clientId` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT 'OAuth客户端ID',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='题库管理员表';
        ");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $biz = $this->getContainer();
        $connection = $biz['db'];
        $connection->exec("
            DROP TABLE `question_library`;
            DROP TABLE `question_library_admin`;
        ");
    }
}
